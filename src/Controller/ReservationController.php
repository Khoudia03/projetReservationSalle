<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\CreerReservationDTOBuilder;
use App\Exception\ReservationIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Http\ResponseStrategyInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Service\ReservationService;
use App\Service\SalleService;
use App\Validation\ReservationValidator;
use DateTimeImmutable;
use InvalidArgumentException;


final class ReservationController extends AbstractController
{
    public function __construct(
        private ReservationService $reservationService,
        private SalleService $salleService,
        private CreerReservationService $creerReservationService,
        private AnnulerReservationService $annulerReservationService,
        private ReservationValidator $validator,
        ResponseStrategyInterface $response
    ) {
        parent::__construct($response);
    }


    public function index(): void
    {
        $reservations = $this->reservationService->paginer(5);

        $pagination = [
            'currentPage' => $reservations->currentPage(),
            'lastPage' => $reservations->lastPage(),
            'previousPageUrl' => $reservations->currentPage() > 1
                ? '/reservations?page=' . ($reservations->currentPage() - 1)
                : null,
            'nextPageUrl' => $reservations->hasMorePages()
                ? '/reservations?page=' . ($reservations->currentPage() + 1)
                : null,
            'hasMorePages' => $reservations->hasMorePages(),
            'pages' => [],
        ];

        for ($page = 1; $page <= $reservations->lastPage(); $page++) {
            $pagination['pages'][] = [
                'number' => $page,
                'url' => '/reservations?page=' . $page,
                'current' => $page === $reservations->currentPage(),
            ];
        }

        $this->render(
            'reservation/index',
            [
                'reservations' => $reservations,
                'pagination' => $pagination,
            ]
        );
    }


    public function show(int $id): void
    {
        $reservation = $this->reservationService->trouverParId($id);

        if ($reservation === null) {

            $this->notFound();

            return;
        }

        $this->render(
            'reservation/show',
            [
                'reservation' => $reservation,
            ]
        );
    }


    public function create(): void
    {
        $salles = $this->salleService->lister();

        $this->render(
            'reservation/form',
            [
                'salles' => $salles,
                'errors' => [],
                'old' => [],
            ]
        );
    }


    public function store(): void
    {
        $salles = $this->salleService->lister();


        $data = [
            'salle_id' => (int) ($_POST['salle_id'] ?? 0),
            'responsable' => $_POST['responsable'] ?? '',
            'email' => $_POST['email'] ?? '',
            'motif' => $_POST['motif'] ?? '',
            'date_debut' => $_POST['date_debut'] ?? '',
            'date_fin' => $_POST['date_fin'] ?? '',
        ];


        $result = $this->validator->validate($data);


        if (!$result->isValid()) {

            $this->render(
                'reservation/form',
                [
                    'salles' => $salles,
                    'errors' => $result->getErrors(),
                    'old' => $_POST,
                ]
            );

            return;
        }


        try {

            $dateDebut = new DateTimeImmutable(
                $data['date_debut']
            );

            $dateFin = new DateTimeImmutable(
                $data['date_fin']
            );


            $dto = (new CreerReservationDTOBuilder())

                ->setSalleId(
                    $data['salle_id']
                )

                ->setResponsable(
                    $data['responsable']
                )

                ->setEmail(
                    $data['email']
                )

                ->setMotif(
                    $data['motif']
                )

                ->setDateDebut(
                    $dateDebut
                )

                ->setDateFin(
                    $dateFin
                )

                ->build();


            $reservation = $this->creerReservationService->execute($dto);


            $this->redirect(
                '/reservations/' . $reservation->id
            );

            return;


        } catch (SalleIndisponibleException | InvalidArgumentException $e) {

            $errors = [
                $e->getMessage(),
            ];


        } catch (\Exception $e) {

            $errors = [
                'Les dates saisies sont invalides.',
            ];

        }


        $this->render(
            'reservation/form',
            [
                'salles' => $salles,
                'errors' => $errors,
                'old' => $_POST,
            ]
        );
    }


    public function cancel(int $id): void
    {
        try {

            $this->annulerReservationService->execute($id);


        } catch (ReservationIntrouvableException $e) {

            $this->notFound();

            return;
        }


        $this->redirect('/reservations');
    }
}
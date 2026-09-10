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
use DateTimeImmutable;
use InvalidArgumentException;

final class ReservationController extends AbstractController
{
    public function __construct(
        private ReservationService $reservationService,
        private SalleService $salleService,
        private CreerReservationService $creerReservationService,
        private AnnulerReservationService $annulerReservationService,
        ResponseStrategyInterface $response
    ) {
        parent::__construct($response);
    }

    public function index(): void
    {
        $reservations = $this->reservationService->lister();

        $this->render('reservation/index', [
            'reservations' => $reservations,
        ]);
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationService->trouverParId($id);

        if ($reservation === null) {
            $this->notFound();
            return;
        }

        $this->render('reservation/show', [
            'reservation' => $reservation,
        ]);
    }

    public function create(): void
    {
        $salles = $this->salleService->lister();

        $this->render('reservation/form', [
            'salles' => $salles,
            'errors' => [],
            'old' => [],
        ]);
    }

    public function store(): void
    {
        $salles = $this->salleService->lister();
        $errors = [];

        try {
            $dateDebut = new DateTimeImmutable($_POST['date_debut'] ?? '');
            $dateFin = new DateTimeImmutable($_POST['date_fin'] ?? '');

            $dto = (new CreerReservationDTOBuilder())
                ->setSalleId((int) ($_POST['salle_id'] ?? 0))
                ->setResponsable($_POST['responsable'] ?? '')
                ->setEmail($_POST['email'] ?? '')
                ->setMotif($_POST['motif'] ?? '')
                ->setDateDebut($dateDebut)
                ->setDateFin($dateFin)
                ->build();

            $reservation = $this->creerReservationService->execute($dto);

            $this->redirect('/reservations/' . $reservation->id);
            return;
        } catch (SalleIndisponibleException|InvalidArgumentException $e) {
            $errors[] = $e->getMessage();
        } catch (\Exception $e) {
            $errors[] = 'Les dates saisies sont invalides.';
        }

       
        $this->render('reservation/form', [
            'salles' => $salles,
            'errors' => $errors,
            'old' => $_POST,
        ]);
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
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\CreerSalleDTOBuilder;
use App\Exception\SalleIndisponibleException;
use App\Http\ResponseStrategyInterface;
use App\Service\CreerSalleService;
use App\Service\ModifierSalleService;
use App\Service\SalleService;
use App\Validation\SalleValidator;

final class SalleController extends AbstractController
{
    public function __construct(
        private SalleService $salleService,
        private CreerSalleService $creerSalleService,
        private ModifierSalleService $modifierSalleService,
        private SalleValidator $validator,
        ResponseStrategyInterface $response
    ) {
        parent::__construct($response);
    }


    public function index(): void
    {
      
        $salles = $this->salleService->paginer(5);

        $pagination = [
            'currentPage' => $salles->currentPage(),
            'lastPage' => $salles->lastPage(),
            'previousPageUrl' => $salles->previousPageUrl(),
            'nextPageUrl' => $salles->nextPageUrl(),
            'hasMorePages' => $salles->hasMorePages(),
            'pages' => [],
        ];

        for ($page = 1; $page <= $salles->lastPage(); $page++) {
            $pagination['pages'][] = [
                'number' => $page,
                'url' => $salles->url($page),
                'current' => $page === $salles->currentPage(),
            ];
        }

        $this->render(
            'salle/index',
            [
                'salles' => $salles,
                'pagination' => $pagination,
            ]
        );
    }


    public function show(int $id): void
    {
        $salle = $this->salleService->trouverParId($id);

        if ($salle === null) {

            $this->notFound();

            return;
        }

        $this->render(
            'salle/show',
            [
                'salle' => $salle,
            ]
        );
    }

    public function create(): void
    {
        $this->render(
            'salle/form',
            [
                'salle' => null,
                'errors' => [],
                'old' => [],
            ]
        );
    }

    public function store(): void
    {
        $data = [
            'nom' => $_POST['nom'] ?? '',
            'batiment' => $_POST['batiment'] ?? '',
            'capacite' => (int) ($_POST['capacite'] ?? 0),
            'type' => $_POST['type'] ?? '',
            'active' => true,
        ];


        $result = $this->validator->validate($data);


        if (!$result->isValid()) {

            $this->render(
                'salle/form',
                [
                    'salle' => null,
                    'errors' => $result->getErrors(),
                    'old' => $_POST,
                ]
            );

            return;
        }


        $dto = (new CreerSalleDTOBuilder())

            ->setNom(
                $data['nom']
            )

            ->setBatiment(
                $data['batiment']
            )

            ->setCapacite(
                $data['capacite']
            )

            ->setType(
                $data['type']
            )

            ->build();


        $salle = $this->creerSalleService->execute($dto);


        $this->redirect(
            '/salles/' . $salle->id
        );
    }


    public function edit(int $id): void
    {
        $salle = $this->salleService->trouverParId($id);

        if ($salle === null) {

            $this->notFound();

            return;
        }

        $this->render(
            'salle/form',
            [
                'salle' => $salle,
                'errors' => [],
                'old' => [],
            ]
        );
    }


    public function update(int $id): void
    {
        $data = [
            'nom' => $_POST['nom'] ?? '',
            'batiment' => $_POST['batiment'] ?? '',
            'capacite' => (int) ($_POST['capacite'] ?? 0),
            'type' => $_POST['type'] ?? '',
            'active' => true,
        ];


        $result = $this->validator->validate($data);


        if (!$result->isValid()) {

            $this->render(
                'salle/form',
                [
                    'salle' => $this->salleService->trouverParId($id),
                    'errors' => $result->getErrors(),
                    'old' => $_POST,
                ]
            );

            return;
        }


        $dto = (new CreerSalleDTOBuilder())

            ->setNom(
                $data['nom']
            )

            ->setBatiment(
                $data['batiment']
            )

            ->setCapacite(
                $data['capacite']
            )

            ->setType(
                $data['type']
            )

            ->build();


        try {

            $salle = $this->modifierSalleService->execute(
                $id,
                $dto
            );

        } catch (SalleIndisponibleException $e) {

            $this->notFound();

            return;
        }


        $this->redirect(
            '/salles/' . $salle->id
        );
    }
}
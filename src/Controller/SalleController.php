<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\CreerSalleDTOBuilder;
use App\Exception\SalleIndisponibleException;
use App\Http\ResponseStrategyInterface;
use App\Service\ModifierSalleService;
use App\Service\SalleService;

final class SalleController extends AbstractController
{
    public function __construct(
        private SalleService $salleService,
        private ModifierSalleService $modifierSalleService,
        ResponseStrategyInterface $response
    ) {
        parent::__construct($response);
    }

    public function index(): void
    {
        $salles = $this->salleService->lister();

        $this->render('salle/index', ['salles' => $salles]);
    }

    public function show(int $id): void
    {
        $salle = $this->salleService->trouverParId($id);

        if ($salle === null) {
            $this->notFound();
            return;
        }

        $this->render('salle/show', ['salle' => $salle]);
    }

    public function edit(int $id): void
    {
        $salle = $this->salleService->trouverParId($id);

        if ($salle === null) {
            $this->notFound();
            return;
        }

        $this->render('salle/form', [
            'salle' => $salle,
            'errors' => [],
        ]);
    }

    public function update(int $id): void
    {
        $dto = (new CreerSalleDTOBuilder())
            ->setNom($_POST['nom'] ?? '')
            ->setBatiment($_POST['batiment'] ?? '')
            ->setCapacite((int) ($_POST['capacite'] ?? 0))
            ->setType($_POST['type'] ?? '')
            ->build();

        try {
            $salle = $this->modifierSalleService->execute($id, $dto);
        } catch (SalleIndisponibleException $e) {
            $this->notFound();
            return;
        }

        $this->redirect('/salles/' . $salle->id);
    }
}
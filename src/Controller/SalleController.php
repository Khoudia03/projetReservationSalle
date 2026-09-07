<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repositorie\SalleRepositoryInterface;

final class SalleController
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function index(): void
    {
        $salles = $this->salleRepository->findAll();

        require __DIR__ . '/../../templates/salle/index.php';
    }

    public function show(int $id): void
    {
        $salle = $this->salleRepository->findById($id);

        if ($salle === null) {
            http_response_code(404);
            require __DIR__ . '/../../templates/error/404.php';
            return;
        }

        require __DIR__ . '/../../templates/salle/show.php';
    }

    public function create(): void
    {
        $errors = [];

        require __DIR__ . '/../../templates/salle/form.php';
    }

    public function store(): void
    {
        // À compléter avec le Validator + Builder + Service
    }

    public function edit(int $id): void
    {
        $salle = $this->salleRepository->findById($id);

        if ($salle === null) {
            http_response_code(404);
            require __DIR__ . '/../../templates/error/404.php';
            return;
        }

        $errors = [];

        require __DIR__ . '/../../templates/salle/form.php';
    }

    public function update(int $id): void
    {
        // À compléter
    }
}
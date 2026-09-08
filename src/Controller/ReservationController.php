<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repositorie\ReservationRepositoryInterface;
use App\Repositorie\SalleRepositoryInterface;

final class ReservationController
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function index(): void
    {
        $reservations = $this->reservationRepository->findAll();

        require __DIR__ . '/../../templates/reservation/index.php';
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationRepository->findById($id);

        if ($reservation === null) {
            http_response_code(404);
            require __DIR__ . '/../../templates/error/404.php';
            return;
        }

        require __DIR__ . '/../../templates/reservation/show.php';
    }

    public function create(): void
    {
        $salles = $this->salleRepository->findAll();
        $errors = [];

        require __DIR__ . '/../../templates/reservation/form.php';
    }

    public function store(): void
    {
    }

    public function cancel(int $id): void
    {
    }
}
<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Reservation;
use App\Repositorie\ReservationRepositoryInterface;

final class ReservationService
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function lister(): array
    {
        return $this->reservationRepository->findAll();
    }

    public function trouverParId(int $id): ?Reservation
    {
        return $this->reservationRepository->findById($id);
    }
}
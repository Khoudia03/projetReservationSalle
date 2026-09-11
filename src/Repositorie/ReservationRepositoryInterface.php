<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\Reservation;
use DateTimeImmutable;
use Illuminate\Pagination\LengthAwarePaginator;

interface ReservationRepositoryInterface
{
   
    public function findAll(): array;

    public function findById(int $id): ?Reservation;

    public function hasConflict(
        int $salleId,
        DateTimeImmutable $dateDebut,
        DateTimeImmutable $dateFin
    ): bool;

    public function save(Reservation $reservation): Reservation;

    public function cancel(Reservation $reservation): Reservation;

    public function paginate(int $perPage = 10): LengthAwarePaginator;
}
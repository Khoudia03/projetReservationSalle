<?php

declare(strict_types=1);

namespace Tests\Doubles;

use App\Model\Reservation;
use App\Repositorie\ReservationRepositoryInterface;
use DateTimeImmutable;

final class InMemoryReservationRepository implements ReservationRepositoryInterface
{
    private array $reservations = [];

    public function findAll(): array
    {
        return array_values($this->reservations);
    }

    public function findById(int $id): ?Reservation
    {
        return $this->reservations[$id] ?? null;
    }

    public function hasConflict(
        int $salleId,
        DateTimeImmutable $dateDebut,
        DateTimeImmutable $dateFin
    ): bool {
        foreach ($this->reservations as $reservation) {

            if ($reservation->salle_id !== $salleId) {
                continue;
            }

            if (
                $reservation->date_debut < $dateFin
                && $reservation->date_fin > $dateDebut
            ) {
                return true;
            }
        }

        return false;
    }

    public function save(Reservation $reservation): Reservation
    {
        $this->reservations[$reservation->id] = $reservation;

        return $reservation;
    }

    public function cancel(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulée';

        $this->reservations[$reservation->id] = $reservation;

        return $reservation;
    }

    public function add(Reservation $reservation): void
    {
        $this->reservations[$reservation->id] = $reservation;
    }
}
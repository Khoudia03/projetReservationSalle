<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\Reservation;
use DateTimeImmutable;
use Illuminate\Pagination\LengthAwarePaginator;


final class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function findAll(): array
    {
        return Reservation::query()->get()->all();
    }

    public function findById(int $id): ?Reservation
    {
        return Reservation::find($id);
    }

    public function hasConflict(
        int $salleId,
        DateTimeImmutable $dateDebut,
        DateTimeImmutable $dateFin
    ): bool {
        return Reservation::query()
            ->where('salle_id', $salleId)
            ->where('date_debut', '<', $dateFin)
            ->where('date_fin', '>', $dateDebut)
            ->exists();
    }

    public function save(Reservation $reservation): Reservation
    {
        $reservation->save();

        return $reservation;
    }

    public function cancel(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulée';
        $reservation->save();

        return $reservation;
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Reservation::query()
            ->with('salle')
            ->paginate($perPage);
    }
}
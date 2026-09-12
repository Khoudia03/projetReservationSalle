<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\Reservation;
use App\Filter\ReservationFilter;
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

    public function paginate(ReservationFilter $filter, int $perPage = 10): LengthAwarePaginator
    {
        return Reservation::query()->with('salle')
            ->when(
                $filter->responsable(), 
                fn($query, $responsable) => 
                $query->where('responsable', 'like', "%{$responsable}%")
            )
            ->when(
                $filter->email(), 
                fn($query, $email) => 
                $query->where('email', 'like', "%{$email}%")
            )
            ->when(
                $filter->salleId(), 
                fn($query, $salleId) => 
                $query->where('salle_id', $salleId)
            )
            ->when(
                $filter->statut(), 
                fn($query, $statut) => 
                $query->where('statut', $statut)
            )
            ->when(
                $filter->dateDebut(), 
                fn($query, $dateDebut) => 
                $query->where('date_debut', '>=', $dateDebut)
            )
            ->when(
                $filter->dateFin(), 
                fn($query, $dateFin) => 
                $query->where('date_fin', '<=', $dateFin)
            )
            ->paginate($perPage);
    }
}
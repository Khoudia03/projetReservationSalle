<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\Salle;
use App\Filter\SalleFilter;
use Illuminate\Pagination\LengthAwarePaginator;

final class EloquentSalleRepository implements SalleRepositoryInterface
{
    public function findAll(): array
    {
        return Salle::query()->get()->all();
    }

    public function findById(int $id): ?Salle
    {
        return Salle::find($id);
    }

    public function save(Salle $salle): Salle
    {
        $salle->save();

        return $salle;
    }

    public function paginate(SalleFilter $filter, int $perPage = 10): LengthAwarePaginator
    {
        return Salle::query()
            ->when(
                $filter->nom(), 
                fn($query, $nom) => 
                $query->where('nom', 'like', "%{$nom}%")
            )
            ->when(
                $filter->batiment(), 
                fn($query, $batiment) => 
                $query->where('batiment', 'like', "%{$batiment}%")
            )
            ->when(
                $filter->type(), 
                fn($query, $type) => 
                $query->where('type', $type)
            )
            ->paginate($perPage);
    }
}
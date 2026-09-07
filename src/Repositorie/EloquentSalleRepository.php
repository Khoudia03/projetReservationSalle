<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\Salle;

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
}
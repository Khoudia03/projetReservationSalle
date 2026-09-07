<?php

declare(strict_types=1);

namespace Tests\Doubles;

use App\Model\Salle;
use App\Repositorie\SalleRepositoryInterface;

final class InMemorySalleRepository implements SalleRepositoryInterface
{
    private array $salles = [];

    public function findAll(): array
    {
        return array_values($this->salles);
    }

    public function findById(int $id): ?Salle
    {
        return $this->salles[$id] ?? null;
    }

    public function save(Salle $salle): Salle
    {
        $this->salles[$salle->id] = $salle;

        return $salle;
    }

    public function add(Salle $salle): void
    {
        $this->salles[$salle->id] = $salle;
    }
}
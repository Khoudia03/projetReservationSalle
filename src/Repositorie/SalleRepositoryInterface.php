<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\Salle;
use App\Filter\SalleFilter;
use Illuminate\Pagination\LengthAwarePaginator;

interface SalleRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): ?Salle;

    public function save(Salle $salle): Salle;

    public function paginate(SalleFilter $filter, int $perPage = 10): LengthAwarePaginator;
}
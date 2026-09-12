<?php

declare(strict_types=1);

namespace App\Service;

use App\Filter\SalleFilter;
use App\Model\Salle;
use App\Repositorie\SalleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class SalleService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function lister(): array
    {
        return $this->salleRepository->findAll();
    }

    public function trouverParId(int $id): ?Salle
    {
        return $this->salleRepository->findById($id);
    }

    public function paginer(SalleFilter $filter,int $perPage = 10): LengthAwarePaginator 
    {
        return $this->salleRepository->paginate(
            $filter,
            $perPage
        );
    }
}
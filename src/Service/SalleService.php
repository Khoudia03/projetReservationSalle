<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Salle;
use App\Repositorie\SalleRepositoryInterface;

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
}
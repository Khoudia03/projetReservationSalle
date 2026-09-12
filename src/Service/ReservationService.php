<?php

declare(strict_types=1);

namespace App\Service;

use App\Filter\ReservationFilter;
use App\Model\Reservation;
use App\Repositorie\ReservationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class ReservationService
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function lister(): array
    {
        return $this->reservationRepository->findAll();
    }

    public function trouverParId(int $id): ?Reservation
    {
        return $this->reservationRepository->findById($id);
    }

    public function paginer(ReservationFilter $filter,int $perPage = 10): LengthAwarePaginator 
    {
        return $this->reservationRepository->paginate(
            $filter,
            $perPage
        );
    }
}

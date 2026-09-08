<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ReservationIntrouvableException;
use App\Model\Reservation;
use App\Repositorie\ReservationRepositoryInterface;

final class AnnulerReservationService
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function execute(int $reservationId): Reservation
    {
        $reservation = $this->reservationRepository->findById(
            $reservationId
        );

        if ($reservation === null) {
            throw new ReservationIntrouvableException(
                'La réservation demandée n\'existe pas.'
            );
        }

        return $this->reservationRepository->cancel($reservation);
    }
}
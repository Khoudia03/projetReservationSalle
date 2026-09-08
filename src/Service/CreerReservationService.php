<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Reservation;
use App\Repositorie\ReservationRepositoryInterface;
use App\Repositorie\SalleRepositoryInterface;
use DateTimeImmutable;

final class CreerReservationService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function execute(CreerReservationDTO $dto): Reservation
    {
        $salle = $this->salleRepository->findById($dto->salleId);

        if ($salle === null) {
            throw new SalleIndisponibleException(
                'La salle demandée n\'existe pas.'
            );
        }

        if (!$salle->active) {
            throw new SalleIndisponibleException(
                'La salle est inactive.'
            );
        }

        if ($dto->dateDebut >= $dto->dateFin) {
            throw new \InvalidArgumentException(
                'La date de début doit précéder la date de fin.'
            );
        }

        $duree = $dto->dateFin->getTimestamp()
            - $dto->dateDebut->getTimestamp();

        if ($duree > 4 * 60 * 60) {
            throw new \InvalidArgumentException(
                'La durée de réservation ne peut pas dépasser 4 heures.'
            );
        }

        $maintenant = new DateTimeImmutable();

        if ($dto->dateDebut <= $maintenant) {
            throw new \InvalidArgumentException(
                'La réservation doit être dans le futur.'
            );
        }

        $conflit = $this->reservationRepository->hasConflict(
            $dto->salleId,
            $dto->dateDebut,
            $dto->dateFin
        );

        if ($conflit) {
            throw new SalleIndisponibleException(
                'La salle est déjà réservée pendant cette période.'
            );
        }

        $reservation = new Reservation();

        $reservation->salle_id = $dto->salleId;
        $reservation->responsable = $dto->responsable;
        $reservation->email = $dto->email;
        $reservation->motif = $dto->motif;
        $reservation->date_debut = $dto->dateDebut;
        $reservation->date_fin = $dto->dateFin;
        $reservation->statut = 'confirmée';

        $reservation = $this->reservationRepository->save($reservation);

        return $reservation;
    }
}
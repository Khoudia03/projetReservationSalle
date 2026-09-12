<?php

declare(strict_types=1);

namespace App\Filter;

final class ReservationFilter
{
    public function __construct(
        private ?string $responsable = null,
        private ?string $email = null,
        private ?int $salleId = null,
        private ?string $statut = null,
        private ?string $dateDebut = null,
        private ?string $dateFin = null
    ) {
    }

    public function responsable(): ?string
    {
        return $this->responsable;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function salleId(): ?int
    {
        return $this->salleId;
    }

    public function statut(): ?string
    {
        return $this->statut;
    }

    public function dateDebut(): ?string
    {
        return $this->dateDebut;
    }

    public function dateFin(): ?string
    {
        return $this->dateFin;
    }
}
<?php

declare(strict_types=1);

namespace App\Builder;

use App\DTO\CreerReservationDTO;
use DateTimeImmutable;

class CreerReservationDTOBuilder
{
    private int $salleId;
    private string $responsable;
    private string $email;
    private string $motif;
    private DateTimeImmutable $dateDebut;
    private DateTimeImmutable $dateFin;

    public function setSalleId(int $salleId): self
    {
        $this->salleId = $salleId;

        return $this;
    }

    public function setResponsable(string $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function setDateDebut(DateTimeImmutable $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function setDateFin(DateTimeImmutable $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function build(): CreerReservationDTO
    {
        return new CreerReservationDTO(
            $this->salleId,
            $this->responsable,
            $this->email,
            $this->motif,
            $this->dateDebut,
            $this->dateFin
        );
    }
}
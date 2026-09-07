<?php

declare(strict_types=1);

namespace App\Builder;

use App\DTO\CreerSalleDTO;

final class CreerSalleDTOBuilder
{
    private string $nom;
    private string $batiment;
    private int $capacite;
    private string $type;

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function setBatiment(string $batiment): self
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function build(): CreerSalleDTO
    {
        return new CreerSalleDTO(
            $this->nom,
            $this->batiment,
            $this->capacite,
            $this->type
        );
    }
}
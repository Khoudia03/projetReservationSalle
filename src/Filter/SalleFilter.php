<?php

declare(strict_types=1);

namespace App\Filter;

final class SalleFilter
{
    public function __construct(
        private ?string $nom = null,
        private ?string $batiment = null,
        private ?string $type = null
    ) {
    }

    public function nom(): ?string
    {
        return $this->nom;
    }

    public function batiment(): ?string
    {
        return $this->batiment;
    }

    public function type(): ?string
    {
        return $this->type;
    }
}
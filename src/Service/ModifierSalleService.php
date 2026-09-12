<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Salle;
use App\Repositorie\SalleRepositoryInterface;

final class ModifierSalleService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function execute(int $id, CreerSalleDTO $dto): Salle
    {
        $salle = $this->salleRepository->findById($id);

        if ($salle === null) {
            throw new SalleIndisponibleException(
                'La salle demandée n\'existe pas.'
            );
        }

        $salle->nom = $dto->nom;
        $salle->batiment = $dto->batiment;
        $salle->capacite = $dto->capacite;
        $salle->type = $dto->type;

        return $this->salleRepository->save($salle);
    }
}
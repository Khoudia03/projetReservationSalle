<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Salle;
use App\Repositorie\EloquentSalleRepository;
use PHPUnit\Framework\TestCase;

final class EloquentSalleRepositoryTest extends TestCase
{
    public function testCreationSalleAvecEloquent(): void
    {
        // Arrange
        $repository = new EloquentSalleRepository();

        $salle = new Salle();

        $salle->nom = 'Salle A';
        $salle->batiment = 'Bâtiment A';
        $salle->capacite = 50;
        $salle->type = 'cours';
        $salle->active = true;

        // Act
        $result = $repository->save($salle);

        // Assert
        $this->assertNotNull($result->id);
        $this->assertSame('Salle A', $result->nom);
        $this->assertSame(50, $result->capacite);
    }
}
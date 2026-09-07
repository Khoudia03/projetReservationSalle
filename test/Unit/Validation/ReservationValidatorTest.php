<?php

declare(strict_types=1);

namespace Tests\Unit\Validation;

use App\Validation\ReservationValidator;
use PHPUnit\Framework\TestCase;
use App\Validation\SalleValidator;

final class ReservationValidatorTest extends TestCase
{
    public function testEmailInvalide(): void
    {
        // Arrange
        $validator = new ReservationValidator();

        $data = [
            'salle_id' => 1,
            'responsable' => 'Khoudia',
            'email' => 'email-invalide',
            'motif' => 'Cours de programmation',
            'date_debut' => '2026-09-10 10:00:00',
            'date_fin' => '2026-09-10 12:00:00',
        ];

        // Act
        $result = $validator->validate($data);

        // Assert
        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('email', $result->getErrors());
    }


    public function testResponsableVide(): void
{
    // Arrange
    $validator = new ReservationValidator();

    $data = [
        'salle_id' => 1,
        'responsable' => '',
        'email' => 'khoudia@example.com',
        'motif' => 'Cours de programmation',
        'date_debut' => '2026-09-10 10:00:00',
        'date_fin' => '2026-09-10 12:00:00',
    ];

    // Act
    $result = $validator->validate($data);

    // Assert
    $this->assertFalse($result->isValid());
    $this->assertArrayHasKey(
        'responsable',
        $result->getErrors()
    );
}


public function testCapaciteNegative(): void
{
    // Arrange
    $validator = new SalleValidator();

    $data = [
        'nom' => 'Salle A',
        'batiment' => 'Bâtiment A',
        'capacite' => -5,
        'type' => 'cours',
        'active' => true,
    ];

    // Act
    $result = $validator->validate($data);

    // Assert
    $this->assertFalse($result->isValid());
    $this->assertArrayHasKey(
        'capacite',
        $result->getErrors()
    );
}


public function testTypeSalleInconnu(): void
{
    // Arrange
    $validator = new SalleValidator();

    $data = [
        'nom' => 'Salle A',
        'batiment' => 'Bâtiment A',
        'capacite' => 50,
        'type' => 'restaurant',
        'active' => true,
    ];

    // Act
    $result = $validator->validate($data);

    // Assert
    $this->assertFalse($result->isValid());
    $this->assertArrayHasKey(
        'type',
        $result->getErrors()
    );
}


public function testDateIncorrecte(): void
{
    // Arrange
    $validator = new ReservationValidator();

    $data = [
        'salle_id' => 1,
        'responsable' => 'Khoudia',
        'email' => 'khoudia@example.com',
        'motif' => 'Cours de programmation',
        'date_debut' => '2026-99-99 25:80:00',
        'date_fin' => '2026-09-10 12:00:00',
    ];

    // Act
    $result = $validator->validate($data);

    // Assert
    $this->assertFalse($result->isValid());
    $this->assertArrayHasKey(
        'date_debut',
        $result->getErrors()
    );
}
}
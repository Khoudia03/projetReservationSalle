<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Model\Reservation;
use App\Service\AnnulerReservationService;
use PHPUnit\Framework\TestCase;
use Tests\Doubles\InMemoryReservationRepository;
use App\Exception\ReservationIntrouvableException;

final class AnnulerReservationServiceTest extends TestCase
{
    public function testAnnulerReservationExistante(): void
    {
        // Arrange
        $repository = new InMemoryReservationRepository();

        $reservation = new Reservation();
        $reservation->id = 1;
        $reservation->salle_id = 1;
        $reservation->responsable = 'Khoudia';
        $reservation->email = 'khoudia@example.com';
        $reservation->motif = 'Cours de programmation';
        $reservation->statut = 'confirmée';

        $repository->add($reservation);

        $service = new AnnulerReservationService($repository);

        // Act
        $result = $service->execute(1);

        // Assert
        $this->assertSame($reservation, $result);
        $this->assertSame('annulée', $result->statut);
    }


    public function testReservationInexistante(): void
{
    // Arrange
    $repository = new InMemoryReservationRepository();
    $service = new AnnulerReservationService($repository);

    // Assert
    $this->expectException(ReservationIntrouvableException::class);

    // Act
    $service->execute(999);
}
}
<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\DTO\CreerReservationDTO;
use App\Model\Salle;
use App\Service\CreerReservationService;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Tests\Doubles\InMemoryReservationRepository;
use Tests\Doubles\InMemorySalleRepository;
use App\Exception\SalleIndisponibleException;
use App\Model\Reservation;

final class CreerReservationServiceTest extends TestCase
{
    public function testReservationValide(): void
    {
        // Arrange : préparer les données
        $salleRepository = new InMemorySalleRepository();
        $reservationRepository = new InMemoryReservationRepository();

        $salle = new Salle();

        $salle->id = 1;
        $salle->nom = 'Salle A';
        $salle->batiment = 'Bâtiment 1';
        $salle->capacite = 30;
        $salle->type = 'cours';
        $salle->active = true;

        $salleRepository->add($salle);

        $service = new CreerReservationService(
            $salleRepository,
            $reservationRepository
        );

        $dateDebut = new DateTimeImmutable('+1 day 10:00');
        $dateFin = new DateTimeImmutable('+1 day 12:00');

        $dto = new CreerReservationDTO(
            1,
            'Khoudia',
            'khoudia@example.com',
            'Cours de programmation',
            $dateDebut,
            $dateFin
        );

        // Act : exécuter le service
        $reservation = $service->execute($dto);

        // Assert : vérifier le résultat
        $this->assertNotNull($reservation);
        $this->assertSame(1, $reservation->salle_id);
        $this->assertSame('Khoudia', $reservation->responsable);
        $this->assertSame(
            'khoudia@example.com',
            $reservation->email
        );
        $this->assertSame(
            'Cours de programmation',
            $reservation->motif
        );
        $this->assertSame(
            'confirmée',
            $reservation->statut
        );
    }

    public function testSalleInexistante(): void
{
    // Arrange
    $salleRepository = new InMemorySalleRepository();
    $reservationRepository = new InMemoryReservationRepository();

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dto = new CreerReservationDTO(
        999, // cette salle n'existe pas
        'Khoudia',
        'khoudia@example.com',
        'Cours de programmation',
        new DateTimeImmutable('+1 day 10:00'),
        new DateTimeImmutable('+1 day 12:00')
    );

    // Assert
    $this->expectException(SalleIndisponibleException::class);

    // Act
    $service->execute($dto);
}

public function testSalleInactive(): void
{
    // Arrange
    $salleRepository = new InMemorySalleRepository();
    $reservationRepository = new InMemoryReservationRepository();

    $salle = new Salle();

    $salle->id = 1;
    $salle->nom = 'Salle A';
    $salle->batiment = 'Bâtiment 1';
    $salle->capacite = 30;
    $salle->type = 'cours';
    $salle->active = false;

    $salleRepository->add($salle);

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dto = new CreerReservationDTO(
        1,
        'Khoudia',
        'khoudia@example.com',
        'Cours de programmation',
        new DateTimeImmutable('+1 day 10:00'),
        new DateTimeImmutable('+1 day 12:00')
    );

    // Assert
    $this->expectException(SalleIndisponibleException::class);

    // Act
    $service->execute($dto);
}


public function testDateFinAvantDebut(): void
{
    // Arrange
    $salleRepository = new InMemorySalleRepository();
    $reservationRepository = new InMemoryReservationRepository();

    $salle = new Salle();

    $salle->id = 1;
    $salle->nom = 'Salle A';
    $salle->batiment = 'Bâtiment 1';
    $salle->capacite = 30;
    $salle->type = 'cours';
    $salle->active = true;

    $salleRepository->add($salle);

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dateDebut = new DateTimeImmutable('+1 day 14:00');
    $dateFin = new DateTimeImmutable('+1 day 12:00');

    $dto = new CreerReservationDTO(
        1,
        'Khoudia',
        'khoudia@example.com',
        'Cours de programmation',
        $dateDebut,
        $dateFin
    );

    // Assert
    $this->expectException(\InvalidArgumentException::class);

    // Act
    $service->execute($dto);
}


public function testDureeSuperieureAQuatreHeures(): void
{
    // Arrange
    $salleRepository = new InMemorySalleRepository();
    $reservationRepository = new InMemoryReservationRepository();

    $salle = new Salle();

    $salle->id = 1;
    $salle->nom = 'Salle A';
    $salle->batiment = 'Bâtiment 1';
    $salle->capacite = 30;
    $salle->type = 'cours';
    $salle->active = true;

    $salleRepository->add($salle);

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dateDebut = new DateTimeImmutable('+1 day 10:00');
    $dateFin = new DateTimeImmutable('+1 day 15:00');

    $dto = new CreerReservationDTO(
        1,
        'Khoudia',
        'khoudia@example.com',
        'Cours de programmation',
        $dateDebut,
        $dateFin
    );

    // Assert
    $this->expectException(\InvalidArgumentException::class);

    // Act
    $service->execute($dto);
}


public function testDatePassee(): void
{
    // Arrange
    $salleRepository = new InMemorySalleRepository();
    $reservationRepository = new InMemoryReservationRepository();

    $salle = new Salle();

    $salle->id = 1;
    $salle->nom = 'Salle A';
    $salle->batiment = 'Bâtiment 1';
    $salle->capacite = 30;
    $salle->type = 'cours';
    $salle->active = true;

    $salleRepository->add($salle);

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dateDebut = new DateTimeImmutable('-1 day 10:00');
    $dateFin = new DateTimeImmutable('-1 day 12:00');

    $dto = new CreerReservationDTO(
        1,
        'Khoudia',
        'khoudia@example.com',
        'Cours de programmation',
        $dateDebut,
        $dateFin
    );

    // Assert
    $this->expectException(\InvalidArgumentException::class);

    // Act
    $service->execute($dto);
}


public function testConflitAvecUneReservationExistante(): void
{
    // Arrange
    $salleRepository = new InMemorySalleRepository();
    $reservationRepository = new InMemoryReservationRepository();

    $salle = new Salle();

    $salle->id = 1;
    $salle->nom = 'Salle A';
    $salle->batiment = 'Bâtiment 1';
    $salle->capacite = 30;
    $salle->type = 'cours';
    $salle->active = true;

    $salleRepository->add($salle);

    // Réservation déjà existante : 10h → 12h
    $reservationExistante = new Reservation();

    $reservationExistante->id = 1;
    $reservationExistante->salle_id = 1;
    $reservationExistante->responsable = 'Autre personne';
    $reservationExistante->email = 'autre@example.com';
    $reservationExistante->motif = 'Cours';
    $reservationExistante->date_debut = new DateTimeImmutable('+1 day 10:00');
    $reservationExistante->date_fin = new DateTimeImmutable('+1 day 12:00');
    $reservationExistante->statut = 'confirmée';

    $reservationRepository->add($reservationExistante);

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    // Nouvelle réservation : 11h → 13h
    $dto = new CreerReservationDTO(
        1,
        'Khoudia',
        'khoudia@example.com',
        'Cours de programmation',
        new DateTimeImmutable('+1 day 11:00'),
        new DateTimeImmutable('+1 day 13:00')
    );

    // Assert
    $this->expectException(SalleIndisponibleException::class);

    // Act
    $service->execute($dto);
}


public function testReservationVoisineSansChevauchement(): void
{
    // Arrange
    $salleRepository = new InMemorySalleRepository();
    $reservationRepository = new InMemoryReservationRepository();

    $salle = new Salle();

    $salle->id = 1;
    $salle->nom = 'Salle A';
    $salle->batiment = 'Bâtiment 1';
    $salle->capacite = 30;
    $salle->type = 'cours';
    $salle->active = true;

    $salleRepository->add($salle);

    // Réservation existante : 10h → 12h
    $reservationExistante = new Reservation();

    $reservationExistante->id = 1;
    $reservationExistante->salle_id = 1;
    $reservationExistante->responsable = 'Autre personne';
    $reservationExistante->email = 'autre@example.com';
    $reservationExistante->motif = 'Cours';
    $reservationExistante->date_debut = new DateTimeImmutable('+1 day 10:00');
    $reservationExistante->date_fin = new DateTimeImmutable('+1 day 12:00');
    $reservationExistante->statut = 'confirmée';

    $reservationRepository->add($reservationExistante);

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    // Nouvelle réservation : 12h → 14h
    $dto = new CreerReservationDTO(
        1,
        'Khoudia',
        'khoudia@example.com',
        'Cours de programmation',
        new DateTimeImmutable('+1 day 12:00'),
        new DateTimeImmutable('+1 day 14:00')
    );

    // Act
    $reservation = $service->execute($dto);

    // Assert
    $this->assertNotNull($reservation);
    $this->assertSame(1, $reservation->salle_id);
    $this->assertSame('Khoudia', $reservation->responsable);
    $this->assertSame('confirmée', $reservation->statut);
}
}
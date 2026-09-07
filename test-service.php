<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use App\Builder\CreerReservationDTOBuilder;
use App\Repositorie\EloquentSalleRepository;
use App\Repositorie\EloquentReservationRepository;
use App\Service\CreerReservationService;
use DateTimeImmutable;

echo "===== TEST CREER RESERVATION =====\n\n";

$salleRepository = new EloquentSalleRepository();
$reservationRepository = new EloquentReservationRepository();

$service = new CreerReservationService(
    $salleRepository,
    $reservationRepository
);

$dto = (new CreerReservationDTOBuilder())
    ->setSalleId(1)
    ->setResponsable('Khoudia Cissé')
    ->setEmail('khoudia@gmail.com')
    ->setMotif('Cours de PHP')
    ->setDateDebut(
        new DateTimeImmutable('2026-09-10 08:00:00')
    )
    ->setDateFin(
        new DateTimeImmutable('2026-09-10 10:00:00')
    )
    ->build();

$reservation = $service->execute($dto);

echo "Réservation créée avec succès !\n\n";

var_dump($reservation);
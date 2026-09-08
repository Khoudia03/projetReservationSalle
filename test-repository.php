<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/config/database.php';

use App\Repositorie\EloquentSalleRepository;
use App\Repositorie\EloquentReservationRepository;

echo "===== TEST SALLE =====\n";

$salleRepository = new EloquentSalleRepository();

$salles = $salleRepository->findAll();

foreach ($salles as $salle) {
    echo $salle->nom . "\n";
}

echo "\n===== TEST RESERVATION =====\n";

$reservationRepository = new EloquentReservationRepository();

$reservations = $reservationRepository->findAll();

foreach ($reservations as $reservation) {
    echo $reservation->motif . "\n";
}
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/config/database.php';

use App\Model\Salle;
use App\Model\Reservation;

$salles = Salle::all();

foreach ($salles as $salle) {
    echo $salle->nom . PHP_EOL;
}
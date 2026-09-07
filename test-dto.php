<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Builder\CreerSalleDTOBuilder;

echo "===== TEST SALLE =====\n";

$salleDTO = (new CreerSalleDTOBuilder())
    ->setNom('Salle A')
    ->setBatiment('Bâtiment 1')
    ->setCapacite(100)
    ->setType('Cours')
    ->build();

var_dump($salleDTO);
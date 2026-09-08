<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Validation\SalleValidator;

$data = [
    'nom' => 'Salle B12',
    'batiment' => 'Bâtiment B',
    'capacite' => 40,
    'type' => 'cours',
    'active' => true,
];

$validator = new SalleValidator();

$result = $validator->validate($data);

if ($result->isValid()) {
    echo "Données valides !" . PHP_EOL;
} else {
    print_r($result->getErrors());
}
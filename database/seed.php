<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../config/database.php';

use App\Model\Salle;
use App\Model\Reservation;

$salles = [
    [
        'nom' => 'Amphithéâtre A',
        'batiment' => 'Bâtiment A',
        'capacite' => 250,
        'type' => 'amphitheatre',
        'active' => true,
    ],
    [
        'nom' => 'Salle B12',
        'batiment' => 'Bâtiment B',
        'capacite' => 40,
        'type' => 'cours',
        'active' => true,
    ],
    [
        'nom' => 'Laboratoire Chimie',
        'batiment' => 'Bâtiment C',
        'capacite' => 24,
        'type' => 'laboratoire',
        'active' => true,
    ],
    [
        'nom' => 'Salle Informatique 1',
        'batiment' => 'Bâtiment D',
        'capacite' => 30,
        'type' => 'informatique',
        'active' => true,
    ],
    [
        'nom' => 'Salle de réunion',
        'batiment' => 'Bâtiment E',
        'capacite' => 12,
        'type' => 'reunion',
        'active' => true,
    ],
];

foreach ($salles as $data) {
    Salle::firstOrCreate(
        [
            'nom' => $data['nom'],
            'batiment' => $data['batiment'],
        ],
        $data
    );
}

$toutesLesSalles = Salle::all();

$reservations = [
    [
        'responsable' => 'Amadou Diop',
        'email' => 'amadou.diop@example.com',
        'motif' => 'Cours de mathématiques',
        'date_debut' => '2026-09-15 08:00:00',
        'date_fin' => '2026-09-15 10:00:00',
        'statut' => 'confirmée',
    ],
    [
        'responsable' => 'Fatou Ndiaye',
        'email' => 'fatou.ndiaye@example.com',
        'motif' => 'Réunion pédagogique',
        'date_debut' => '2026-09-16 14:00:00',
        'date_fin' => '2026-09-16 16:00:00',
        'statut' => 'confirmée',
    ],
    [
        'responsable' => 'Moussa Sarr',
        'email' => 'moussa.sarr@example.com',
        'motif' => 'TP de chimie',
        'date_debut' => '2026-09-17 09:00:00',
        'date_fin' => '2026-09-17 12:00:00',
        'statut' => 'en_attente',
    ],
    [
        'responsable' => 'Aïssatou Ba',
        'email' => 'aissatou.ba@example.com',
        'motif' => 'Conférence étudiante',
        'date_debut' => '2026-09-18 13:00:00',
        'date_fin' => '2026-09-18 15:30:00',
        'statut' => 'confirmée',
    ],
];

foreach ($reservations as $index => $data) {
    $salle = $toutesLesSalles[$index % $toutesLesSalles->count()];

    Reservation::firstOrCreate(
        [
            'salle_id' => $salle->id,
            'date_debut' => $data['date_debut'],
        ],
        array_merge($data, ['salle_id' => $salle->id])
    );
}

echo "Seed exécuté avec succès !" . PHP_EOL;
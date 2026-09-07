<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use Illuminate\Database\Capsule\Manager as Capsule;

echo "===== TEST DES MIGRATIONS =====\n\n";

$migrationsPath = __DIR__ . '/database/migrations';

$migrations = glob($migrationsPath . '/*.php');

sort($migrations);

foreach ($migrations as $migration) {

    echo "Migration : " . basename($migration) . "\n";

    $migrationInstance = require $migration;

    $migrationInstance->up();

    echo "✓ Migration exécutée\n\n";
}

echo "===== VERIFICATION DES TABLES =====\n\n";

if (Capsule::schema()->hasTable('salles')) {
    echo "✓ La table salles existe.\n";
} else {
    echo "✗ La table salles n'existe pas.\n";
}

if (Capsule::schema()->hasTable('reservations')) {
    echo "✓ La table reservations existe.\n";
} else {
    echo "✗ La table reservations n'existe pas.\n";
}

echo "\n===== FIN DU TEST =====\n";
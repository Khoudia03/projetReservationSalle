<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/database.php';

$migrations = [
    __DIR__ . '/migrations/001_create_salles_table.php',
    __DIR__ . '/migrations/002_create_reservations_table.php',
];

foreach ($migrations as $migrationFile) {

    echo "\nMigration : " . basename($migrationFile) . "\n";

    $migration = require $migrationFile;

    $migration->up();

    echo "✓ Migration exécutée.\n";
}

echo "\n✓ Toutes les migrations ont été exécutées.\n";

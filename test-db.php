<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$db = require __DIR__ . '/config/database.php';

try {
    $pdo = $db->getConnection()->getPdo();

    echo "Connexion MySQL réussie !";
} catch (Throwable $e) {
    echo "Erreur : " . $e->getMessage();
}
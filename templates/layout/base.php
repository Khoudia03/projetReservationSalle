<?php

declare(strict_types=1);

$title = $title ?? 'Réservation de salles';
$content = $content ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">

    <title><?= e($title) ?></title>
</head>

<body>

<nav>
    <a href="/salles">Salles</a>
    <a href="/reservations">Réservations</a>
    <a href="/reservations/create">Nouvelle réservation</a>
</nav>

<main>
    <?= $content ?>
</main>

</body>
</html>
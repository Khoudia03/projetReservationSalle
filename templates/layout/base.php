<?php

declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

$title = $title ?? 'Réservation de salles';
$content = $content ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($title) ?></title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
        }

        nav {
            background: #222;
            padding: 15px;
        }

        nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
        }

        main {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 15px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
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
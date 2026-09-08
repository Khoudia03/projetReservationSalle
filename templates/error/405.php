<?php

declare(strict_types=1);

$title = 'Méthode non autorisée';

ob_start();
?>

<h1>405 - Méthode non autorisée</h1>

<p>
    La méthode HTTP utilisée n'est pas autorisée pour cette URL.
</p>

<p>
    <a href="/salles">
        Retour à l'accueil
    </a>
</p>

<?php
$content = ob_get_clean();

require __DIR__ . '/../layout/base.php';
<?php

declare(strict_types=1);

$title = 'Détail de la salle';

ob_start();
?>

<h1><?= e($salle->nom) ?></h1>

<p>
    <strong>ID :</strong>
    <?= e($salle->id) ?>
</p>

<p>
    <strong>Bâtiment :</strong>
    <?= e($salle->batiment) ?>
</p>

<p>
    <strong>Capacité :</strong>
    <?= e($salle->capacite) ?>
</p>

<p>
    <strong>Type :</strong>
    <?= e($salle->type) ?>
</p>

<p>
    <strong>Active :</strong>
    <?= $salle->active ? 'Oui' : 'Non' ?>
</p>

<p>
    <a href="/salles">Retour aux salles</a>
</p>

<p>
    <a href="/salles/<?= e($salle->id) ?>/edit">
        Modifier cette salle
    </a>
</p>

<?php
$content = ob_get_clean();

require __DIR__ . '/../layout/base.php';
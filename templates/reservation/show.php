<?php

declare(strict_types=1);

$title = 'Détail de la réservation';

ob_start();
?>

<h1>Détail de la réservation</h1>

<p>
    <strong>ID :</strong>
    <?= e($reservation->id) ?>
</p>

<p>
    <strong>Salle :</strong>
    <?= e($reservation->salle_id) ?>
</p>

<p>
    <strong>Responsable :</strong>
    <?= e($reservation->responsable) ?>
</p>

<p>
    <strong>Email :</strong>
    <?= e($reservation->email) ?>
</p>

<p>
    <strong>Motif :</strong>
    <?= e($reservation->motif) ?>
</p>

<p>
    <strong>Date de début :</strong>
    <?= e($reservation->date_debut) ?>
</p>

<p>
    <strong>Date de fin :</strong>
    <?= e($reservation->date_fin) ?>
</p>

<p>
    <strong>Statut :</strong>
    <?= e($reservation->statut) ?>
</p>

<?php if ($reservation->statut !== 'annulée'): ?>

    <form
        method="POST"
        action="/reservations/<?= e($reservation->id) ?>/cancel"
    >
        <button type="submit">
            Annuler la réservation
        </button>
    </form>

<?php endif; ?>

<p>
    <a href="/reservations">
        Retour aux réservations
    </a>
</p>

<?php
$content = ob_get_clean();

require __DIR__ . '/../layout/base.php';
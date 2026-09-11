<?php

declare(strict_types=1);

$title = 'Liste des réservations';

ob_start();
?>

<h1>Liste des réservations</h1>

<p>
    <a href="/reservations/create">
        Nouvelle réservation
    </a>
</p>

<table>

    <thead>
        <tr>
            <th>ID</th>
            <th>Salle</th>
            <th>Responsable</th>
            <th>Motif</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach ($reservations as $reservation): ?>

        <tr>

            <td>
                <?= e($reservation->id) ?>
            </td>

            <td>
                <?= e($reservation->salle->nom) ?>
            </td>

            <td>
                <?= e($reservation->responsable) ?>
            </td>

            <td>
                <?= e($reservation->motif) ?>
            </td>

            <td>
                <?= e($reservation->date_debut) ?>
            </td>

            <td>
                <?= e($reservation->date_fin) ?>
            </td>

            <td>
                <?= e($reservation->statut) ?>
            </td>

            <td>
                <a href="/reservations/<?= e($reservation->id) ?>">
                    Voir
                </a>
            </td>

        </tr>

    <?php endforeach; ?>

    </tbody>

</table>

<div>

    <?php foreach ($pagination['pages'] as $page): ?>

        <?php if ($page['current']): ?>

            <strong>
                <?= e($page['number']) ?>
            </strong>

        <?php else: ?>

            <a href="<?= e($page['url']) ?>">
                <?= e($page['number']) ?>
            </a>

        <?php endif; ?>

    <?php endforeach; ?>

</div>

<?php
$content = ob_get_clean();

require __DIR__ . '/../layout/base.php';
<?php

declare(strict_types=1);

$title = 'Nouvelle réservation';

$responsable = $old['responsable'] ?? '';
$email = $old['email'] ?? '';
$motif = $old['motif'] ?? '';
$salleId = $old['salle_id'] ?? '';
$dateDebut = $old['date_debut'] ?? '';
$dateFin = $old['date_fin'] ?? '';

ob_start();
?>

<h1>Nouvelle réservation</h1>

<form method="POST" action="/reservations">

    <div class="form-group">

        <label for="salle_id">
            Salle
        </label>

        <select id="salle_id" name="salle_id">

            <option value="">
                -- Choisir une salle --
            </option>

            <?php foreach ($salles as $salle): ?>

                <option
                    value="<?= e($salle->id) ?>"
                    <?= (string) $salleId === (string) $salle->id
                        ? 'selected'
                        : '' ?>
                >
                    <?= e($salle->nom) ?>
                    -
                    <?= e($salle->batiment) ?>
                    (<?= e($salle->capacite) ?> places)
                </option>

            <?php endforeach; ?>

        </select>

        <?php if (!empty($errors['salle_id'])): ?>
            <div class="error">
                <?= e($errors['salle_id']) ?>
            </div>
        <?php endif; ?>

    </div>


    <div class="form-group">

        <label for="responsable">
            Responsable
        </label>

        <input
            type="text"
            id="responsable"
            name="responsable"
            value="<?= e($responsable) ?>"
        >

        <?php if (!empty($errors['responsable'])): ?>
            <div class="error">
                <?= e($errors['responsable']) ?>
            </div>
        <?php endif; ?>

    </div>


    <div class="form-group">

        <label for="email">
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="<?= e($email) ?>"
        >

        <?php if (!empty($errors['email'])): ?>
            <div class="error">
                <?= e($errors['email']) ?>
            </div>
        <?php endif; ?>

    </div>


    <div class="form-group">

        <label for="motif">
            Motif
        </label>

        <input
            type="text"
            id="motif"
            name="motif"
            value="<?= e($motif) ?>"
        >

        <?php if (!empty($errors['motif'])): ?>
            <div class="error">
                <?= e($errors['motif']) ?>
            </div>
        <?php endif; ?>

    </div>


    <div class="form-group">

        <label for="date_debut">
            Date de début
        </label>

        <input
            type="datetime-local"
            id="date_debut"
            name="date_debut"
            value="<?= e($dateDebut) ?>"
        >

        <?php if (!empty($errors['date_debut'])): ?>
            <div class="error">
                <?= e($errors['date_debut']) ?>
            </div>
        <?php endif; ?>

    </div>


    <div class="form-group">

        <label for="date_fin">
            Date de fin
        </label>

        <input
            type="datetime-local"
            id="date_fin"
            name="date_fin"
            value="<?= e($dateFin) ?>"
        >

        <?php if (!empty($errors['date_fin'])): ?>
            <div class="error">
                <?= e($errors['date_fin']) ?>
            </div>
        <?php endif; ?>

    </div>


    <button type="submit">
        Réserver
    </button>

</form>

<p>
    <a href="/reservations">
        Retour aux réservations
    </a>
</p>

<?php
$content = ob_get_clean();

require __DIR__ . '/../layout/base.php';
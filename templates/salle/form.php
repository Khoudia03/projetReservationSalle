<?php

declare(strict_types=1);

$title = isset($salle)
    ? 'Modifier une salle'
    : 'Créer une salle';

$action = isset($salle)
    ? '/salles/' . $salle->id . '/edit'
    : '/salles';

$nom = $salle->nom ?? '';
$batiment = $salle->batiment ?? '';
$capacite = $salle->capacite ?? '';
$type = $salle->type ?? '';
$active = $salle->active ?? true;

ob_start();
?>

<h1><?= e($title) ?></h1>

<form method="POST" action="<?= e($action) ?>">

    <div class="form-group">
        <label for="nom">Nom</label>

        <input
            type="text"
            id="nom"
            name="nom"
            value="<?= e($nom) ?>"
        >

        <?php if (!empty($errors['nom'])): ?>
            <div class="error">
                <?= e($errors['nom']) ?>
            </div>
        <?php endif; ?>
    </div>


    <div class="form-group">
        <label for="batiment">Bâtiment</label>

        <input
            type="text"
            id="batiment"
            name="batiment"
            value="<?= e($batiment) ?>"
        >

        <?php if (!empty($errors['batiment'])): ?>
            <div class="error">
                <?= e($errors['batiment']) ?>
            </div>
        <?php endif; ?>
    </div>


    <div class="form-group">
        <label for="capacite">Capacité</label>

        <input
            type="number"
            id="capacite"
            name="capacite"
            value="<?= e($capacite) ?>"
        >

        <?php if (!empty($errors['capacite'])): ?>
            <div class="error">
                <?= e($errors['capacite']) ?>
            </div>
        <?php endif; ?>
    </div>


    <div class="form-group">
        <label for="type">Type</label>

        <select id="type" name="type">

            <option value="">-- Choisir --</option>

            <option
                value="amphitheatre"
                <?= $type === 'amphitheatre' ? 'selected' : '' ?>
            >
                Amphithéâtre
            </option>

            <option
                value="cours"
                <?= $type === 'cours' ? 'selected' : '' ?>
            >
                Cours
            </option>

            <option
                value="laboratoire"
                <?= $type === 'laboratoire' ? 'selected' : '' ?>
            >
                Laboratoire
            </option>

            <option
                value="informatique"
                <?= $type === 'informatique' ? 'selected' : '' ?>
            >
                Informatique
            </option>

            <option
                value="reunion"
                <?= $type === 'reunion' ? 'selected' : '' ?>
            >
                Réunion
            </option>

        </select>

        <?php if (!empty($errors['type'])): ?>
            <div class="error">
                <?= e($errors['type']) ?>
            </div>
        <?php endif; ?>
    </div>


    <?php if (isset($salle)): ?>

        <div class="form-group">

            <label>
                <input
                    type="checkbox"
                    name="active"
                    value="1"
                    <?= $active ? 'checked' : '' ?>
                >

                Salle active
            </label>

        </div>

    <?php endif; ?>


    <button type="submit">
        <?= isset($salle) ? 'Modifier' : 'Créer' ?>
    </button>

</form>

<?php
$content = ob_get_clean();

require __DIR__ . '/../layout/base.php';
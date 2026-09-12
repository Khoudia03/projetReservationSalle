<?php

declare(strict_types=1);

$title = 'Liste des salles';

ob_start();
?>

<h1>Liste des salles</h1>

<p>
    <a href="/salles/create">Ajouter une salle</a>
</p>

<form method="GET" action="/salles">

    <div>
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?= $filters['nom'] ?? '' ?>" placeholder="Nom de la salle">
    </div>

    <div>
        <label for="batiment">Bâtiment</label>
        <input type="text" id="batiment" name="batiment" value="<?= $filters['batiment'] ?? '' ?>"
            placeholder="Bâtiment">
    </div>

    <div>
        <label for="type">Type</label>
        <input type="text" id="type" name="type" value="<?= $filters['type'] ?? '' ?>" placeholder="Type">
    </div>

    <button type="submit">
        Rechercher
    </button>

</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Bâtiment</th>
            <th>Capacité</th>
            <th>Type</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($salles as $salle): ?>

            <tr>
                <td><?= e($salle->id) ?></td>

                <td><?= e($salle->nom) ?></td>

                <td><?= e($salle->batiment) ?></td>

                <td><?= e($salle->capacite) ?></td>

                <td><?= e($salle->type) ?></td>

                <td>
                    <?= $salle->active ? 'Oui' : 'Non' ?>
                </td>

                <td>
                    <a href="/salles/<?= e($salle->id) ?>">
                        Voir
                    </a>

                    |

                    <a href="/salles/<?= e($salle->id) ?>/edit">
                        Modifier
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>
<div class="pagination">

    <?php if ($pagination['previousPageUrl']): ?>

        <a href="<?= $pagination['previousPageUrl'] ?>">
            ← Précédent
        </a>

    <?php endif; ?>


    <?php foreach ($pagination['pages'] as $page): ?>

        <?php if ($page['current']): ?>

            <strong>
                <?= $page['number'] ?>
            </strong>

        <?php else: ?>

            <a href="<?= $page['url'] ?>">
                <?= $page['number'] ?>
            </a>

        <?php endif; ?>

    <?php endforeach; ?>


    <?php if ($pagination['nextPageUrl']): ?>

        <a href="<?= $pagination['nextPageUrl'] ?>">
            Suivant →
        </a>

    <?php endif; ?>

</div>

<?php
$content = ob_get_clean();

require __DIR__ . '/../layout/base.php';
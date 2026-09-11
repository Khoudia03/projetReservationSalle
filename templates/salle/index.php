<?php

declare(strict_types=1);

$title = 'Liste des salles';

ob_start();
?>

<h1>Liste des salles</h1>

<p>
    <a href="/salles/create">Ajouter une salle</a>
</p>

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
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


<div class="filter-form">

    <h2>Rechercher une réservation</h2>

    <form method="GET" action="/reservations">

        <div class="filters">

            <!-- RESPONSABLE -->

            <div class="form-group">

                <label for="responsable">
                    Responsable
                </label>

                <input
                    type="text"
                    id="responsable"
                    name="responsable"
                    value="<?= $filters['responsable'] ?? '' ?>"
                    placeholder="Nom du responsable"
                >

            </div>


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= $filters['email'] ?? '' ?>"
                    placeholder="Email"
                >

            </div>


            <!-- SALLE -->

            <div class="form-group">

                <label for="salle_id">
                    ID de la salle
                </label>

                <input
                    type="number"
                    id="salle_id"
                    name="salle_id"
                    value="<?= $filters['salle_id'] ?? '' ?>"
                    placeholder="Ex : 1"
                    min="1"
                >

            </div>


            <!-- STATUT -->

            <div class="form-group">

                <label for="statut">
                    Statut
                </label>

                <select
                    id="statut"
                    name="statut"
                >

                    <option value="">
                        Tous les statuts
                    </option>

                    <option
                        value="confirmée"
                        <?= ($filters['statut'] ?? '') === 'confirmée'
                            ? 'selected'
                            : '' ?>
                    >
                        Confirmée
                    </option>

                    <option
                        value="annulée"
                        <?= ($filters['statut'] ?? '') === 'annulée'
                            ? 'selected'
                            : '' ?>
                    >
                        Annulée
                    </option>

                </select>

            </div>


            <!-- DATE DEBUT -->

            <div class="form-group">

                <label for="date_debut">
                    Date de début
                </label>

                <input
                    type="date"
                    id="date_debut"
                    name="date_debut"
                    value="<?= $filters['date_debut'] ?? '' ?>"
                >

            </div>


            <!-- DATE FIN -->

            <div class="form-group">

                <label for="date_fin">
                    Date de fin
                </label>

                <input
                    type="date"
                    id="date_fin"
                    name="date_fin"
                    value="<?= $filters['date_fin'] ?? '' ?>"
                >

            </div>

        </div>


        <!-- BOUTONS -->

        <div class="buttons">

            <button
                type="submit"
                class="btn-search"
            >
                Rechercher
            </button>

            <a
                href="/reservations"
                class="btn-reset"
            >
                Réinitialiser
            </a>

        </div>

    </form>

</div>


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

        <?php if ($reservations->count() > 0): ?>

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

        <?php else: ?>

            <tr>

                <td colspan="8">
                    Aucune réservation ne correspond à votre recherche.
                </td>

            </tr>

        <?php endif; ?>

    </tbody>

</table>


<?php if ($pagination['lastPage'] > 1): ?>

    <div class="pagination">

        <!-- PRÉCÉDENT -->

        <?php if ($pagination['previousPageUrl']): ?>

            <a href="<?= $pagination['previousPageUrl'] ?>">
                ← Précédent
            </a>

        <?php endif; ?>


        <!-- NUMÉROS DES PAGES -->

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


        <!-- SUIVANT -->

        <?php if ($pagination['nextPageUrl']): ?>

            <a href="<?= $pagination['nextPageUrl'] ?>">
                Suivant →
            </a>

        <?php endif; ?>

    </div>

<?php endif; ?>


<?php

$content = ob_get_clean();

require __DIR__ . '/../layout/base.php';
<?php

declare(strict_types=1);

$title = 'Page non trouvée';

ob_start();
?>

<h1>404 - Page non trouvée</h1>

<p>
    La page que vous recherchez n'existe pas.
</p>

<p>
    <a href="/salles">
        Retour à l'accueil
    </a>
</p>

<?php
$content = ob_get_clean();

require __DIR__ . '/../layout/base.php';
<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once dirname(__DIR__) . '/config/database.php';

use App\Application;

$application = new Application();

$application->run();
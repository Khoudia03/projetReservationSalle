<?php
require_once dirname(__DIR__)."/vendor/autoload.php";

use App\Application;

$application = new Application();
$application->run();
<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Application;
use Config\ContainerFactory;
use Illuminate\Database\Capsule\Manager;

$container = ContainerFactory::create();

$container->get(Manager::class);

$application = $container->get(Application::class);

$application->run();
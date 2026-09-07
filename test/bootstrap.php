<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager;

require dirname(__DIR__) . '/vendor/autoload.php';

$capsule = new Manager();

$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => ':memory:',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
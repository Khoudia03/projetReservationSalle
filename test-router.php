<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function (RouteCollector $r) {

    $r->addRoute('GET', '/salles', 'listeSalles');

    $r->addRoute('POST', '/salles', 'creerSalle');

    $r->addRoute('GET', '/salles/{id}', 'voirSalle');
});

// On simule une requête
$method = 'GET';
$uri = '/salles';

$routeInfo = $dispatcher->dispatch($method, $uri);

var_dump($routeInfo);
<?php

declare(strict_types=1);

namespace App;

use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repositorie\EloquentReservationRepository;
use App\Repositorie\EloquentSalleRepository;
use App\Repositorie\ReservationRepositoryInterface;
use App\Repositorie\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use DI\Container;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

final class Application
{
    public function run(): void
    {
        // 1. Création du conteneur
        $container = $this->createContainer();

        // 2. Création du dispatcher
        $dispatcher = $this->createRouter();

        // 3. Récupération du chemin sans query string
        $path = parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );

        $method = $_SERVER['REQUEST_METHOD'];

        // 4. Dispatch de la requête
        $routeInfo = $dispatcher->dispatch(
            $method,
            $path
        );

        // 5. Gestion du résultat
        switch ($routeInfo[0]) {

            case Dispatcher::NOT_FOUND:

                http_response_code(404);

                require dirname(__DIR__)
                    . '/templates/error/404.php';

                break;


            case Dispatcher::METHOD_NOT_ALLOWED:

                http_response_code(405);

                $allowedMethods = $routeInfo[1];

                header(
                    'Allow: ' . implode(', ', $allowedMethods)
                );

                require dirname(__DIR__)
                    . '/templates/error/405.php';

                break;


            case Dispatcher::FOUND:

                // Handler
                $handler = $routeInfo[1];

                // Paramètres dynamiques
                $vars = $routeInfo[2];

                // Récupération du contrôleur par le conteneur
                $controller = $container->get(
                    $handler[0]
                );

                // Conversion des paramètres numériques
                $parameters = array_map(
                    static function ($value) {

                        if (ctype_digit((string) $value)) {
                            return (int) $value;
                        }

                        return $value;
                    },
                    array_values($vars)
                );

                // Exécution de l'action
                $controller->{$handler[1]}(
                    ...$parameters
                );

                break;
        }
    }


    private function createRouter(): Dispatcher
    {
        return simpleDispatcher(
            function ($router): void {

                // Chargement des routes
                $routes = require dirname(__DIR__)
                    . '/routes/web.php';

                // Déclaration des routes
                $routes($router);
            }
        );
    }


    private function createContainer(): Container
    {
        $container = new Container();

        // SalleRepositoryInterface
        $container->set(
            SalleRepositoryInterface::class,
            \DI\autowire(
                EloquentSalleRepository::class
            )
        );

        // ReservationRepositoryInterface
        $container->set(
            ReservationRepositoryInterface::class,
            \DI\autowire(
                EloquentReservationRepository::class
            )
        );

        // Services
        $container->set(
            CreerReservationService::class,
            \DI\autowire(
                CreerReservationService::class
            )
        );

        $container->set(
            AnnulerReservationService::class,
            \DI\autowire(
                AnnulerReservationService::class
            )
        );

        // Controllers
        $container->set(
            SalleController::class,
            \DI\autowire(
                SalleController::class
            )
        );

        $container->set(
            ReservationController::class,
            \DI\autowire(
                ReservationController::class
            )
        );

        return $container;
    }
}
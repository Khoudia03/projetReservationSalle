<?php

declare(strict_types=1);

use App\Application;
use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Http\HtmlResponseStrategy;
use App\Http\JsonResponseStrategy;
use App\Http\ResponseStrategyInterface;
use App\Repositorie\EloquentReservationRepository;
use App\Repositorie\EloquentSalleRepository;
use App\Repositorie\ReservationRepositoryInterface;
use App\Repositorie\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Service\ModifierSalleService;
use App\Service\ReservationService;
use App\Service\SalleService;
use App\Service\CreerSalleService;
use App\Validation\ReservationInterfaceValidation;
use App\Validation\SalleInterfaceValidation;
use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Illuminate\Pagination\Paginator;
use function DI\autowire;
use function DI\factory;
use function FastRoute\simpleDispatcher;

return [

    Manager::class => factory(function (): Manager {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $capsule = new Manager();

        $capsule->addConnection([
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        Paginator::currentPageResolver(
            function (): int {
                return max(
                    1,
                    (int) ($_GET['page'] ?? 1)
                );
            }
        );

        return $capsule;
    }),


    ResponseStrategyInterface::class =>
        factory(function (ContainerInterface $c): ResponseStrategyInterface {

            $format = $_GET['format'] ?? null;

            $accept = $_SERVER['HTTP_ACCEPT'] ?? '';

            $veutDuJson = $format === 'json'
                || str_contains($accept, 'application/json');

            return $veutDuJson
                ? $c->get(JsonResponseStrategy::class)
                : $c->get(HtmlResponseStrategy::class);
        }),



    SalleRepositoryInterface::class =>
        autowire(EloquentSalleRepository::class),

    ReservationRepositoryInterface::class =>
        autowire(EloquentReservationRepository::class),


    SalleInterfaceValidation::class =>
        autowire(SalleValidator::class),

    ReservationInterfaceValidation::class =>
        autowire(ReservationValidator::class),




    CreerReservationService::class =>
        autowire(CreerReservationService::class),

    AnnulerReservationService::class =>
        autowire(AnnulerReservationService::class),

    SalleService::class =>
        autowire(SalleService::class),

    CreerSalleService::class =>
        autowire(CreerSalleService::class),

    ReservationService::class =>
        autowire(ReservationService::class),

    ModifierSalleService::class =>
        autowire(ModifierSalleService::class),



    SalleController::class =>
        autowire(SalleController::class),

    ReservationController::class =>
        autowire(ReservationController::class),



    Dispatcher::class => factory(function (): Dispatcher {

        return simpleDispatcher(
            function ($router): void {

                $routes = require dirname(__DIR__)
                    . '/routes/web.php';

                $routes($router);
            }
        );
    }),



    Application::class =>
        autowire(Application::class),
];
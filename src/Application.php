<?php

declare(strict_types=1);

namespace App;

use DI\Container;
use FastRoute\Dispatcher;

final class Application
{
    public function __construct(
        private Dispatcher $dispatcher,
        private Container $container
    ) {
    }

    public function run(): void
    {
    
        $path = parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );

        $method = $_SERVER['REQUEST_METHOD'];

        
        $routeInfo = $this->dispatcher->dispatch(
            $method,
            $path
        );

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

               
                $handler = $routeInfo[1];

                
                $vars = $routeInfo[2];

               
                $controller = $this->container->get(
                    $handler[0]
                );

              
                $parameters = array_map(
                    static function ($value) {

                        if (ctype_digit((string) $value)) {
                            return (int) $value;
                        }

                        return $value;
                    },
                    array_values($vars)
                );

                
                $controller->{$handler[1]}(
                    ...$parameters
                );

                break;
        }
    }
}
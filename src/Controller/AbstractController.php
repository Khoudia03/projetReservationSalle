<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\ResponseStrategyInterface;

abstract class AbstractController
{
    public function __construct(
        private ResponseStrategyInterface $response
    ) {
    }
    protected function render(string $view, array $data = []): void
    {
        $this->response->render($view, $data);
    }

    protected function redirect(string $url): void
    {
        $this->response->redirect($url);
    }

    protected function notFound(): void
    {
        $this->response->notFound();
    }
}
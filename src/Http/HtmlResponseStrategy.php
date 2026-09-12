<?php

declare(strict_types=1);

namespace App\Http;

final class HtmlResponseStrategy implements ResponseStrategyInterface
{
    private const TEMPLATES_PATH = __DIR__ . '/../../templates/';

    public function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require self::TEMPLATES_PATH . $view . '.php';
    }

    public function redirect(string $url): void
    {
        header('Location: ' . $url);
    }

    public function notFound(): void
    {
        http_response_code(404);

        $this->render('error/404');
    }

    public function methodNotAllowed(array $allowedMethods): void
    {
        http_response_code(405);

        header('Allow: ' . implode(', ', $allowedMethods));

        $this->render('error/405');
    }
}
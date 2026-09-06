<?php

declare(strict_types=1);

namespace App;

final class Application
{
    public function run(): void
    {
        echo "L'application démarre (étape 1 : autoload OK).";
    }
}
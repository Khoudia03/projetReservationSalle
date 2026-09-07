<?php

declare(strict_types=1);

namespace App\Validation;

class ValidationResult
{
    public function __construct(
        private bool $valid,
        private array $errors = [],
        private array $acceptedData = []
    ) {
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getAcceptedData(): array
    {
        return $this->acceptedData;
    }
}
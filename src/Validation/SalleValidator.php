<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as v;

class SalleValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        if (!v::stringType()->length(2, 100)->validate($data['nom'] ?? null)) {
            $errors['nom'] = 'Le nom doit contenir entre 2 et 100 caractères.';
        }

        if (!v::stringType()->length(2, 100)->validate($data['batiment'] ?? null)) {
            $errors['batiment'] = 'Le bâtiment doit contenir entre 2 et 100 caractères.';
        }

        if (!v::intType()->between(1, 1000)->validate($data['capacite'] ?? null)) {
            $errors['capacite'] = 'La capacité doit être un entier entre 1 et 1000.';
        }

        if (!v::in([
            'cours',
            'informatique',
            'laboratoire',
            'amphitheatre',
            'reunion',
        ])->validate($data['type'] ?? null)) {
            $errors['type'] = 'Le type de salle est invalide.';
        }

        if (!v::boolType()->validate($data['active'] ?? null)) {
            $errors['active'] = 'Le champ active doit être un booléen.';
        }

        if (!empty($errors)) {
            return new ValidationResult(
                false,
                $errors
            );
        }

        return new ValidationResult(
            true,
            [],
            $data
        );
    }
}
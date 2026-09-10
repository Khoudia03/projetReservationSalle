<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as v;

class SalleValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $rules = [
            'nom' => [
                v::stringType()->length(2, 100),
                'Le nom doit contenir entre 2 et 100 caractères.'
            ],

            'batiment' => [
                v::stringType()->length(2, 100),
                'Le bâtiment doit contenir entre 2 et 100 caractères.'
            ],

            'capacite' => [
                v::intType()->between(1, 1000),
                'La capacité doit être un entier entre 1 et 1000.'
            ],

            'type' => [
                v::in([
                    'cours',
                    'informatique',
                    'laboratoire',
                    'amphitheatre',
                    'reunion',
                ]),
                'Le type de salle est invalide.'
            ],

            'active' => [
                v::boolType(),
                'Le champ active doit être un booléen.'
            ],
        ];

        foreach ($rules as $field => [$validator, $message]) {
            if (!$validator->validate($data[$field] ?? null)) {
                $errors[$field] = $message;
            }
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
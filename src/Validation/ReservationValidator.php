<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as v;

class ReservationValidator implements ReservationInterfaceValidation
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $rules = [
            'salle_id' => [
                v::intType()->positive(),
                'La salle est invalide.'
            ],

            'responsable' => [
                v::stringType()->length(2, 120),
                'Le responsable doit contenir entre 2 et 120 caractères.'
            ],

            'email' => [
                v::email(),
                'L’adresse email est invalide.'
            ],

            'motif' => [
                v::stringType()->length(5, 255),
                'Le motif doit contenir entre 5 et 255 caractères.'
            ],

            'date_debut' => [
                v::dateTime('Y-m-d\TH:i'),
                'La date de début est invalide.'
            ],

            'date_fin' => [
                v::dateTime('Y-m-d\TH:i'),
                'La date de fin est invalide.'
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
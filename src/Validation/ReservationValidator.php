<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as v;

class ReservationValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        if (!v::intType()->positive()->validate($data['salle_id'] ?? null)) {
            $errors['salle_id'] = 'La salle est invalide.';
        }

        if (!v::stringType()->length(2, 120)->validate($data['responsable'] ?? null)) {
            $errors['responsable'] = 'Le responsable doit contenir entre 2 et 120 caractères.';
        }

        if (!v::email()->validate($data['email'] ?? null)) {
            $errors['email'] = 'L’adresse email est invalide.';
        }

        if (!v::stringType()->length(5, 255)->validate($data['motif'] ?? null)) {
            $errors['motif'] = 'Le motif doit contenir entre 5 et 255 caractères.';
        }

        if (!v::dateTime('Y-m-d H:i:s')->validate($data['date_debut'] ?? null)) {
            $errors['date_debut'] = 'La date de début est invalide.';
        }

        if (!v::dateTime('Y-m-d H:i:s')->validate($data['date_fin'] ?? null)) {
            $errors['date_fin'] = 'La date de fin est invalide.';
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
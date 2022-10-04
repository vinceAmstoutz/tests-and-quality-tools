<?php

declare(strict_types=1);

namespace App\Services\Checker;

/**
 * Very simple email checker (without POO to be quite simple first)
 */
final class Email
{
    /**
     * Return quickly if an email is valid (without object to simplify)
     *
     * @param string $email
     * @return boolean
     */
    public function ensureIsValidEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
}

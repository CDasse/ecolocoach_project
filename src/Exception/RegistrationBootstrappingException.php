<?php

namespace App\Exception;

use RuntimeException;

/**
 * Thrown when the registration process cannot bootstrap a new user account
 * due to missing foundational pathway structural entities in the database.
 */
final class RegistrationBootstrappingException extends RuntimeException
{
    public static function missingDefaultPath(): self
    {
        return new self('Inability to bootstrap registration: Default Path is missing from the database. Did you forget to load fixtures or run migrations?');
    }

    public static function missingInitialStructure(): self
    {
        return new self('Inability to bootstrap registration: The default level (sequence 1) or initial event (sequence 1) is missing from the database.');
    }
}

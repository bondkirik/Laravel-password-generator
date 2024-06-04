<?php

namespace App\Services;

use App\Contracts\PasswordGeneratorInterface;
use Illuminate\Support\Facades\Session;

class PasswordService
{
    private readonly PasswordGeneratorInterface $passwordGenerator;

    public function __construct(PasswordGeneratorInterface $passwordGenerator)
    {
        $this->passwordGenerator = $passwordGenerator;
    }

    /**
     * Generate a unique password by avoiding any previously generated passwords.
     */
    public function generateUniquePassword(
        int $length,
        bool $useDigits,
        bool $useUppercase,
        bool $useLowercase): string
    {
        // Retrieve the array of previously generated passwords from the session, or initialize it if not present
        $sessionKey = 'generated_passwords';
        $generatedPasswords = Session::get($sessionKey, []);

        $password = '';
        do {
            $password = $this->passwordGenerator->generate(
                $length,
                $useDigits,
                $useUppercase,
                $useLowercase
            );
        } while (in_array($password, $generatedPasswords));

        // Add the new unique password to the session-stored list
        $generatedPasswords[] = $password;
        Session::put($sessionKey, $generatedPasswords);

        return $password;
    }
}

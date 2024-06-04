<?php

namespace App\Services;

use App\Contracts\PasswordGeneratorInterface;

class SimplePasswordGenerator implements PasswordGeneratorInterface
{
    /**
     * Build the character pool based on input flags.
     */
    private string  $digits = '0123456789';
    private string  $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private string  $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    protected function buildCharacters(bool $useDigits, bool $useUppercase, bool $useLowercase): string
    {
        $characters = '';
        if ($useDigits) {
            $characters .= $this->digits;
        }
        if ($useUppercase) {
            $characters .= $this->uppercase;
        }
        if ($useLowercase) {
            $characters .= $this->lowercase;
        }
        return $characters;
    }

    /**
     * The password meets the criteria by including at least one character from each required set.
     */
    protected function getLeastOneCharacter(int $length, string $characters, bool $useDigits, bool $useUppercase, bool $useLowercase): string
    {
        $password = '';
        if ($useDigits) {
            $password .= $this->digits[rand(0, strlen($this->digits) - 1)];
        }
        if ($useUppercase) {
            $password .= $this->uppercase[rand(0, strlen($this->uppercase) - 1)];
        }
        if ($useLowercase) {
            $password .= $this->lowercase[rand(0, strlen($this->lowercase) - 1)];
        }

        $remainingLength = $length - strlen($password);
        for ($i = 0; $i < $remainingLength; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }

    /**
     * Generate a password based on the specified length and character use flags.
     */
    public function generate(int $length, bool $useDigits, bool $useUppercase, bool $useLowercase): string
    {
        $characterPool = $this->buildCharacters($useDigits, $useUppercase, $useLowercase);
        $password = $this->getLeastOneCharacter($length, $characterPool, $useDigits, $useUppercase, $useLowercase);
        return str_shuffle($password);
    }

}

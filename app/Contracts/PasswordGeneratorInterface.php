<?php

namespace App\Contracts;

interface PasswordGeneratorInterface
{
    public function generate(int $length, bool $useDigits, bool $useUppercase, bool $useLowercase): string;
}

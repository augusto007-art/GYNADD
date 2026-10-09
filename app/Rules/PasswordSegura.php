<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class PasswordSegura implements ValidationRule
{
    private const COMMON_PASSWORDS = [
        '123456789012345',
        '1234567890123456',
        '111111111111111',
        'password',
        'password123',
        'password12345678',
        'passwordpassword',
        'contrasena',
        'contrasena123456',
        'contraseña',
        'qwerty',
        'qwerty123456789',
        'letmein',
        'iloveyou',
        'admin',
    ];

    public function validate(string $_attribute, mixed $value, Closure $fail): void
    {
        if (Str::length($value) < 15) {
            $fail('La contraseña debe tener al menos 15 caracteres.');
            return;
        }

        if (\in_array(Str::lower($value), self::COMMON_PASSWORDS, true)) {
            $fail('Elige una contraseña que no sea común o fácil de adivinar.');
        }
    }
}
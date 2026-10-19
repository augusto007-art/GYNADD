<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class PasswordSegura implements ValidationRule
{
    private const ALLOWED_CHARACTERS = '/\A[A-Za-z0-9!@#$%&*_.-]+\z/';

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

    private const COMMON_PATTERNS = [
        'password',
        'contrasena',
        'contraseña',
        'qwerty',
        'letmein',
        'iloveyou',
        'admin',
        '123456',
        'abcdef',
        'asdfgh',
    ];

    public function validate(string $_attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            $fail('La contraseña no tiene un formato válido.');

            return;
        }

        $length = Str::length($value);
        if ($length < 8 || $length > 12) {
            $fail('La contraseña debe tener entre 8 y 12 caracteres.');
        }

        if (preg_match(self::ALLOWED_CHARACTERS, $value) !== 1) {
            $fail('La contraseña solo puede contener letras sin acentos, números y estos símbolos: ! @ # $ % & * _ - .');

            return;
        }

        if (
            preg_match('/[A-Z]/', $value) !== 1
            || preg_match('/[a-z]/', $value) !== 1
            || preg_match('/[0-9]/', $value) !== 1
            || preg_match('/[!@#$%&*_.-]/', $value) !== 1
        ) {
            $fail('Incluye al menos una mayúscula, una minúscula, un número y un símbolo permitido.');
        }

        $lowerValue = Str::lower($value);
        $containsCommonPattern = false;
        foreach (self::COMMON_PATTERNS as $pattern) {
            if (str_contains($lowerValue, $pattern)) {
                $containsCommonPattern = true;
                break;
            }
        }

        if (
            \in_array($lowerValue, self::COMMON_PASSWORDS, true)
            || $containsCommonPattern
            || preg_match('/(.)\1{4,}/', $value) === 1
        ) {
            $fail('Elige una contraseña que no sea común o fácil de adivinar.');
        }
    }
}

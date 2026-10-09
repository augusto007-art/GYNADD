<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_form_shows_strength_checklist_and_password_visibility_controls(): void
    {
        $this->get('/registro')
            ->assertOk()
            ->assertSee('Seguridad: escribe una contraseña')
            ->assertSee('Al menos 15 caracteres')
            ->assertSee('data-password-toggle', false);
    }

    public function test_registration_accepts_a_long_passphrase_without_character_composition_rules(): void
    {
        $response = $this->post('/registro', [
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.test',
            'password' => 'una frase larga y segura',
            'password_confirmation' => 'una frase larga y segura',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', ['email' => 'ada@example.test']);
    }

    public function test_registration_rejects_short_and_common_passwords(): void
    {
        foreach (['corta123', 'password12345678'] as $password) {
            $this->post('/registro', [
                'name' => 'Ada Lovelace',
                'email' => 'ada@example.test',
                'password' => $password,
                'password_confirmation' => $password,
            ])->assertSessionHasErrors('password');
        }
    }

    public function test_login_blocks_after_three_failures_for_one_minute(): void
    {
        User::factory()->create([
            'email' => 'ada@example.test',
            'password' => Hash::make('una frase larga y segura'),
        ]);

        for ($attempt = 1; $attempt <= 3; $attempt++) {
            $response = $this->from('/login')->post('/login', [
                'email' => 'ada@example.test',
                'password' => 'incorrecta',
            ]);

            $response->assertRedirect('/login')->assertSessionHasErrors('email');
        }

        $this->from('/login')->post('/login', [
            'email' => 'ada@example.test',
            'password' => 'una frase larga y segura',
        ])->assertRedirect('/login')->assertSessionHasErrors('email');

        $this->travel(61)->seconds();

        $this->post('/login', [
            'email' => 'ada@example.test',
            'password' => 'una frase larga y segura',
        ])->assertRedirect(route('home'));
    }
}

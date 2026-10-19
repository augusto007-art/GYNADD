<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use App\Notifications\VerifyEmailNotification;
use Tests\TestCase;

class AuthSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_form_shows_strength_checklist_and_password_visibility_controls(): void
    {
        $this->get('/registro')
            ->assertOk()
            ->assertSee('Seguridad: escribe una contraseña')
            ->assertSee('Entre 8 y 12 caracteres')
            ->assertSee('Una mayúscula, una minúscula, un número y un símbolo permitido')
            ->assertSee('novalidate', false)
            ->assertSee('email-status', false)
            ->assertSee('password-confirmation-error', false)
            ->assertSee('data-password-toggle', false);
    }

    public function test_registration_email_availability_check_reports_format_and_duplicate_errors(): void
    {
        User::factory()->create(['email' => 'taken@example.test']);

        $this->getJson(route('registro.email', ['email' => 'new@example.test']))
            ->assertOk()
            ->assertJson([
                'available' => true,
                'message' => 'El correo está disponible.',
            ]);

        $this->getJson(route('registro.email', ['email' => 'taken@example.test']))
            ->assertOk()
            ->assertJson([
                'available' => false,
                'message' => 'Ya existe una cuenta registrada con este correo.',
            ]);

        $this->getJson(route('registro.email', ['email' => 'correo invalido']))
            ->assertUnprocessable()
            ->assertJson([
                'available' => false,
                'message' => 'El correo no puede contener espacios y debe tener un formato válido.',
            ]);
    }

    public function test_registration_accepts_a_strong_password_with_allowed_characters(): void
    {
        Notification::fake();
        $password = 'V3rde!20';
        $response = $this->post('/registro', [
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.test',
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status', 'Cuenta creada. Te enviamos un enlace de verificación; confirma tu correo antes de iniciar sesión.');
        $this->assertDatabaseHas('users', ['email' => 'ada@example.test']);
        Notification::assertSentTo(User::where('email', 'ada@example.test')->first(), VerifyEmailNotification::class);
    }

    public function test_registration_accepts_passwords_at_both_length_boundaries(): void
    {
        foreach (['V3rde!20', 'Montana!2026'] as $index => $password) {
            $email = 'ada'.$index.'@example.test';
            $this->post('/registro', [
                'name' => 'Ada Lovelace',
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password,
            ])->assertRedirect(route('login'));

            $this->assertDatabaseHas('users', ['email' => $email]);
        }
    }

    public function test_registration_rejects_passwords_that_are_short_weak_or_use_disallowed_characters(): void
    {
        foreach ([
            'Ab!2xyz',
            'Ab!2xyzABCDEFGHI',
            'password12345678',
            'V3rde! 20',
            'V3rde!/20',
            'Verde!AA',
            'Password!1',
        ] as $password) {
            $this->post('/registro', [
                'name' => 'Ada Lovelace',
                'email' => 'ada@example.test',
                'password' => $password,
                'password_confirmation' => $password,
            ])->assertSessionHasErrors('password');
        }
    }

    public function test_registration_rejects_email_addresses_with_whitespace(): void
    {
        foreach ([' ada@example.test', 'ada @example.test', "ada@example.test\t"] as $email) {
            $this->post('/registro', [
                'name' => 'Ada Lovelace',
                'email' => $email,
                'password' => 'V3rde!20',
                'password_confirmation' => 'V3rde!20',
            ])->assertSessionHasErrors('email');
        }

        $this->assertDatabaseMissing('users', ['email' => 'ada@example.test']);
    }

    public function test_registration_displays_each_validation_error_beside_its_field(): void
    {
        $this->from('/registro')->followingRedirects()->post('/registro', [
            'name' => '',
            'email' => 'correo invalido',
            'password' => 'V3rde!/20',
            'password_confirmation' => 'V3rde!/20',
        ])
            ->assertOk()
            ->assertSee('Escribe tu nombre para crear la cuenta.')
            ->assertSee('El correo no puede contener espacios y debe tener un formato válido.')
            ->assertSee('aria-describedby="name-error"', false)
            ->assertSee('aria-describedby="email-error email-status"', false);
    }

    public function test_password_reset_rejects_disallowed_characters(): void
    {
        $this->post('/reset-password', [
            'token' => 'invalid-token',
            'email' => 'ada@example.test',
            'password' => 'V3rde!/20',
            'password_confirmation' => 'V3rde!/20',
        ])->assertSessionHasErrors('password');
    }

    public function test_login_form_checks_remember_me_and_login_uses_persistent_authentication(): void
    {
        $user = User::factory()->create([
            'email' => 'ada@example.test',
            'password' => Hash::make('una frase larga y segura'),
            'remember_token' => null,
        ]);

        $this->get('/login')
            ->assertOk()
            ->assertSee('name="recordar" style="width:auto;" checked', false);

        $this->post('/login', [
            'email' => 'ada@example.test',
            'password' => 'una frase larga y segura',
            'recordar' => '1',
        ])->assertRedirect(route('home'));

        $this->assertNotNull($user->fresh()->remember_token);
    }

    public function test_unverified_user_is_redirected_to_email_verification_and_cannot_access_home(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'unverified@example.test',
            'password' => Hash::make('V3rde!20'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'V3rde!20',
        ])->assertRedirect(route('verification.notice'));

        $this->get('/email/verify')
            ->assertOk()
            ->assertSee('Verifica tu correo')
            ->assertSee($user->email);

        $this->get('/home')->assertRedirect(route('verification.notice'));
    }

    public function test_user_can_resend_and_complete_email_verification(): void
    {
        Notification::fake();
        $user = User::factory()->unverified()->create([
            'email' => 'unverified@example.test',
            'password' => Hash::make('V3rde!20'),
        ]);

        $this->actingAs($user)->post(route('verification.send'))
            ->assertRedirect()
            ->assertSessionHas('status', 'Te enviamos un nuevo enlace de verificación.');
        Notification::assertSentTo($user, VerifyEmailNotification::class);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->post(route('logout'))->assertRedirect(route('login'));

        $this->get($verificationUrl)
            ->assertRedirect(route('login'))
            ->assertSessionHas('status', 'Correo verificado correctamente. Ya puedes iniciar sesión.');

        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'V3rde!20',
        ])->assertRedirect();
        $this->get('/home')->assertOk();
    }

    public function test_verification_email_is_rendered_in_spanish_with_a_detailed_message(): void
    {
        $user = User::factory()->unverified()->create([
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.test',
        ]);
        $mail = (new VerifyEmailNotification())->toMail($user);
        $html = $mail->render();

        $this->assertStringContainsString('lang="es"', $html);
        $this->assertStringContainsString('Hola, <strong>Ada Lovelace</strong>', $html);
        $this->assertStringContainsString('Verificar mi correo', $html);
        $this->assertStringContainsString('caduca en 60 minutos', $html);
        $this->assertStringContainsString('¿No creaste esta cuenta?', $html);
        $this->assertStringContainsString('ada@example.test', $html);
        $this->assertStringStartsWith('http://localhost/email/verify/', $mail->viewData['verificationUrl']);
    }

    public function test_signed_verification_link_rejects_a_hash_that_does_not_match_the_user_email(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'ada@example.test',
        ]);
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('different@example.test')]
        );

        $this->get($verificationUrl)->assertForbidden();

        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_login_explains_whether_the_email_is_unregistered_or_password_is_incorrect(): void
    {
        $this->from('/login')->followingRedirects()->post('/login', [
            'email' => 'missing@example.test',
            'password' => 'un intento',
        ])
            ->assertOk()
            ->assertSee('Este correo no está registrado.')
            ->assertSee('id="email-error"', false);

        User::factory()->create([
            'email' => 'registered@example.test',
            'password' => Hash::make('una frase larga y segura'),
        ]);

        $this->from('/login')->followingRedirects()->post('/login', [
            'email' => 'registered@example.test',
            'password' => 'incorrecta',
        ])
            ->assertOk()
            ->assertSee('La contraseña es incorrecta.')
            ->assertSee('id="email-error"', false);
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

<?php

namespace App\Http\Controllers;

use App\Rules\PasswordSegura;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

public function register(Request $request)
{
    $datos = $request->validate([
    'name'     => ['required', 'string', 'max:255'],
    'email'    => $this->emailRules(),
    'password' => ['required', 'string', 'confirmed', new PasswordSegura()],
], [
    'name.required' => 'Escribe tu nombre para crear la cuenta.',
    'email.required' => 'Escribe tu correo electrónico.',
    'email.email' => 'Escribe un correo electrónico válido.',
    'email.max' => 'El correo no puede superar los 255 caracteres.',
    'email.unique' => 'Ya existe una cuenta registrada con este correo.',
    'email.regex' => 'El correo no puede contener espacios y debe tener un formato válido.',
    'password.required' => 'Escribe una contraseña.',
    'password.confirmed' => 'La confirmación no coincide con la contraseña.',
]);

    $user = User::create([
        'name'     => $datos['name'],
        'email'    => $datos['email'],
        'password' => Hash::make($datos['password']),
    ]);

    $user->sendEmailVerificationNotification();

    return redirect()->route('login')
        ->with('status', 'Cuenta creada. Te enviamos un enlace de verificación; confirma tu correo antes de iniciar sesión.');
}

    public function checkRegistrationEmail(Request $request)
    {
        $validator = Validator::make(
            $request->only('email'),
            ['email' => $this->emailFormatRules()],
            [
                'email.required' => 'Escribe tu correo electrónico.',
                'email.email' => 'Escribe un correo electrónico válido.',
                'email.max' => 'El correo no puede superar los 255 caracteres.',
                'email.unique' => 'Ya existe una cuenta registrada con este correo.',
                'email.regex' => 'El correo no puede contener espacios y debe tener un formato válido.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'available' => false,
                'message' => $validator->errors()->first('email'),
            ], 422);
        }

        $available = ! User::where('email', $request->input('email'))->exists();

        return response()->json([
            'available' => $available,
            'message' => $available
                ? 'El correo está disponible.'
                : 'Ya existe una cuenta registrada con este correo.',
        ]);
    }

    private function emailRules(): array
    {
        return [...$this->emailFormatRules(), 'unique:users'];
    }

    private function emailFormatRules(): array
    {
        return [
            'required',
            'string',
            'regex:/\A[^\s]+\z/u',
            'email:rfc',
            'max:255',
            'regex:/^[^@\s]+@[^@\s]+\.[a-zA-Z]{2,}$/',
        ];
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Escribe el correo de tu cuenta.',
            'email.email' => 'Escribe un correo electrónico válido.',
            'password.required' => 'Escribe tu contraseña.',
        ]);

        $limiterKey = hash('sha256', Str::lower($credenciales['email']).'|'.$request->ip());
        $attemptsKey = 'login:attempts:'.$limiterKey;
        $lockKey = 'login:lock:'.$limiterKey;

        if (RateLimiter::tooManyAttempts($lockKey, 1)) {
            $segundos = RateLimiter::availableIn($lockKey);

            return back()->withErrors([
                'email' => "Demasiados intentos fallidos. Vuelve a intentarlo en {$segundos} segundos.",
            ])->onlyInput('email');
        }

        if (Auth::attempt($credenciales, $request->boolean('recordar'))) {
            RateLimiter::clear($attemptsKey);
            RateLimiter::clear($lockKey);
            $request->session()->regenerate();

            if (! $request->user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')
                    ->with('status', 'Debes verificar tu correo antes de acceder.');
            }

            return redirect()->intended(route('home'));
        }

        $accountExists = User::where('email', $credenciales['email'])->exists();
        RateLimiter::hit($attemptsKey, 60);
        $intentosRestantes = 3 - RateLimiter::attempts($attemptsKey);

        if ($intentosRestantes <= 0) {
            RateLimiter::clear($attemptsKey);
            RateLimiter::hit($lockKey, 60);
        }

        return back()->withErrors([
            'email' => $intentosRestantes > 0
                ? ($accountExists
                    ? "La contraseña es incorrecta. Te quedan {$intentosRestantes} intentos."
                    : "Este correo no está registrado. Verifica que lo escribiste correctamente. Te quedan {$intentosRestantes} intentos.")
                : ($accountExists
                    ? 'La contraseña es incorrecta. Has agotado los 3 intentos; el acceso se bloqueó por 1 minuto.'
                    : 'Este correo no está registrado. Has agotado los 3 intentos; el acceso se bloqueó por 1 minuto.'),
        ])->onlyInput('email');
    }

    public function verificationNotice()
    {
        if (request()->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        return view('auth.verify-email');
    }

    public function verifyEmail(int $id, string $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('status', 'Este correo ya está verificado. Inicia sesión para continuar.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->route('login')
            ->with('status', 'Correo verificado correctamente. Ya puedes iniciar sesión.');
    }

    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Te enviamos un nuevo enlace de verificación.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function home()
    {
        return view('home');
    }

    // --- Recuperación de contraseña ---

    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Escribe el correo asociado a tu cuenta.',
            'email.email' => 'Escribe un correo electrónico válido.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Te enviamos el enlace de recuperación a tu correo.')
            : back()->withErrors(['email' => 'No encontramos ese correo.']);
    }

    public function showReset(string $token, Request $request)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => ['required', 'string', 'confirmed', new PasswordSegura()],
        ], [
            'token.required' => 'El enlace de recuperación está incompleto. Solicita uno nuevo.',
            'email.required' => 'No se recibió el correo asociado al enlace.',
            'email.email' => 'El correo asociado al enlace no es válido.',
            'password.required' => 'Escribe una contraseña nueva.',
            'password.confirmed' => 'La confirmación no coincide con la contraseña.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Contraseña actualizada, ya puedes iniciar sesión.')
            : back()->withErrors(['email' => 'El enlace no es válido o expiró.']);
    }
    public function redirectGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function callbackGoogle()
{
    $provider = Socialite::driver('google');

    if (method_exists($provider, 'stateless')) {
        $googleUser = $provider->stateless()->user();
    } else {
        $googleUser = $provider->user();
    }

    $googleEmailVerified = ($googleUser->getRaw()['verified_email'] ?? false) === true;
    $user = User::where('email', $googleUser->getEmail())->first();
    $sendVerification = false;

    if (!$user) {
        // No existía: lo registramos automáticamente
        $user = User::create([
            'name'      => $googleUser->getName(),
            'email'     => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'password'  => null,
            'email_verified_at' => $googleEmailVerified ? now() : null,
        ]);
        $sendVerification = ! $googleEmailVerified;
    } elseif (!$user->google_id) {
        // Ya existía con correo/contraseña normal: solo lo vinculamos a Google
        $user->update([
            'google_id' => $googleUser->getId(),
            'email_verified_at' => $googleEmailVerified ? now() : $user->email_verified_at,
        ]);
        $sendVerification = ! $googleEmailVerified && ! $user->hasVerifiedEmail();
    } elseif ($googleEmailVerified && ! $user->hasVerifiedEmail()) {
        $user->forceFill(['email_verified_at' => now()])->save();
    }

    if ($sendVerification) {
        $user->sendEmailVerificationNotification();
    }

    Auth::login($user);

    return $user->hasVerifiedEmail()
        ? redirect()->route('home')
        : redirect()->route('verification.notice')
            ->with('status', 'Debes verificar tu correo antes de acceder.');
}
}
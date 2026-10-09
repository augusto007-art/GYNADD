<?php

namespace App\Http\Controllers;

use App\Rules\PasswordSegura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
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
    'email'    => [
        'required',
        'string',
        'email:rfc',
        'max:255',
        'unique:users',
        'regex:/^[^@\s]+@[^@\s]+\.[a-zA-Z]{2,}$/',
    ],
    'password' => ['required', 'confirmed', new PasswordSegura()],
]);

    User::create([
        'name'     => $datos['name'],
        'email'    => $datos['email'],
        'password' => Hash::make($datos['password']),
    ]);

    return redirect()->route('login')
        ->with('status', '¡Registro exitoso! Ahora inicia sesión con tu correo y contraseña.');
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
            return redirect()->intended(route('home'));
        }

        RateLimiter::hit($attemptsKey, 60);
        $intentosRestantes = 3 - RateLimiter::attempts($attemptsKey);

        if ($intentosRestantes <= 0) {
            RateLimiter::clear($attemptsKey);
            RateLimiter::hit($lockKey, 60);
        }

        return back()->withErrors([
            'email' => $intentosRestantes > 0
                ? "Usuario o contraseña incorrectos. Te quedan {$intentosRestantes} intentos."
                : 'Usuario o contraseña incorrectos. Has agotado los 3 intentos; el acceso se bloqueó por 1 minuto.',
        ])->onlyInput('email');
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
        $request->validate(['email' => 'required|email']);

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
            'password' => ['required', 'confirmed', new PasswordSegura()],
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

    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        // No existía: lo registramos automáticamente
        $user = User::create([
            'name'      => $googleUser->getName(),
            'email'     => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'password'  => null,
        ]);
    } elseif (!$user->google_id) {
        // Ya existía con correo/contraseña normal: solo lo vinculamos a Google
        $user->update(['google_id' => $googleUser->getId()]);
    }

    Auth::login($user);

    return redirect()->route('home');
}
}
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/login');
});

// Registro
Route::get('/registro', [AuthController::class, 'showRegister'])->name('registro');
Route::get('/registro/verificar-correo', [AuthController::class, 'checkRegistrationEmail'])
    ->middleware('throttle:60,1')
    ->name('registro.email');
Route::post('/registro', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Verificación de correo
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [AuthController::class, 'verificationNotice'])->name('verification.notice');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// Recuperación de contraseña
Route::get('/olvide-password', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('/olvide-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showReset'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Home (protegida)
Route::middleware(['auth', 'verified'])->get('/home', [AuthController::class, 'home'])->name('home');

Route::get('/auth/google', [AuthController::class, 'redirectGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'callbackGoogle'])->name('google.callback');
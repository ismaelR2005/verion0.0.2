<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('empleados.index')
        : redirect()->route('login');
});

// Rutas agregadas para iniciar y cerrar sesion.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/registrarse', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registrarse', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    // Vista adaptada desde la carpeta "detector qr".
    Route::view('/detector-qr', 'qr.detector')->name('detector-qr');

    // Rutas CRUD para administrar empleados.
    Route::resource('empleados', EmpleadoController::class);
});

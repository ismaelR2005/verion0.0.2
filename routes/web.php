<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Si ya hay sesion, entra al panel; si no, manda al login.
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return redirect()->route('empleados.index');
});

// Rutas agregadas para iniciar y cerrar sesion.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::get('/registrarse', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registrarse', [AuthController::class, 'register'])->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    // Todo lo de este grupo requiere usuario autenticado.
    Route::view('/detector-qr', 'qr.detector')->name('detector-qr');

    // Rutas CRUD para administrar vehiculos, conservando el nombre interno empleados.
    Route::get('empleados/carga-masiva', [EmpleadoController::class, 'cargaMasiva'])
        ->name('empleados.carga-masiva');
    Route::post('empleados/carga-masiva', [EmpleadoController::class, 'guardarCargaMasiva'])
        ->name('empleados.carga-masiva.store');
    Route::get('empleados/importar-csv', [EmpleadoController::class, 'importarCsv'])
        ->name('empleados.importar-csv');
    Route::post('empleados/importar-csv', [EmpleadoController::class, 'guardarImportacionCsv'])
        ->name('empleados.importar-csv.store');
    Route::get('empleados/importar-csv/plantilla', [EmpleadoController::class, 'descargarPlantillaCsv'])
        ->name('empleados.importar-csv.plantilla');
    Route::delete('empleados', [EmpleadoController::class, 'destroyAll'])
        ->name('empleados.destroy-all');
    Route::resource('empleados', EmpleadoController::class)->except(['show']);
    Route::get('empleados/{empleado}/pdf/{tipo}', [EmpleadoController::class, 'verPdf'])
        ->name('empleados.pdf');
    Route::get('empleados/{empleado}', [EmpleadoController::class, 'show'])
        ->name('empleados.show');
});

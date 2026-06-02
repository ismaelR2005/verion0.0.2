<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas CRUD para administrar empleados.
Route::resource('empleados', EmpleadoController::class);

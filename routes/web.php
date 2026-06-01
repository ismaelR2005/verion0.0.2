<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/empleados', [EmpleadoController::class, 'index']);

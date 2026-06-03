<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\EmpleadoApiController;

// Se nombran como api.empleados.* para no chocar con las rutas web empleados.*.
Route::apiResource('empleados', EmpleadoApiController::class)
    ->middleware('auth:sanctum')
    ->names('api.empleados');

// Si deseas exponer las rutas sin autenticación (solo para pruebas), usa:
// Route::apiResource('empleados', EmpleadoApiController::class);

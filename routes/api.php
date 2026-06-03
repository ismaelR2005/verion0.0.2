<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API resource routes for Empleado (CRUD)
use App\Http\Controllers\Api\EmpleadoApiController;

Route::apiResource('empleados', EmpleadoApiController::class)->middleware('auth:sanctum');

// Si deseas exponer las rutas sin autenticación (solo para pruebas), usa:
// Route::apiResource('empleados', EmpleadoApiController::class);

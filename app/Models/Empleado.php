<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

    // Campos que se pueden asignar de forma masiva desde formularios.
    protected $fillable = [
        'nombre',
        'puesto',
        'correo',
        'telefono',
        'activo',
    ];

    // Convierte el campo activo a verdadero o falso al usar el modelo.
    protected $casts = [
        'activo' => 'boolean',
    ];
}

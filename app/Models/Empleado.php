<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

    protected $fillable = [
        'nombre',
        'puesto',
        'correo',
    ];
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empleado;


class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();

        return view('Empleados.index', compact('empleados'));
    }
}

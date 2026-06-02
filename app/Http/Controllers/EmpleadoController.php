<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    // Muestra el listado de empleados.
    public function index()
    {
        $empleados = Empleado::latest()->get();

        return view('empleados.index', compact('empleados'));
    }

    // Muestra el formulario para crear un empleado.
    public function create()
    {
        return view('empleados.create');
    }

    // Guarda un nuevo empleado en la base de datos.
    public function store(Request $request)
    {
        Empleado::create($this->validarEmpleado($request));

        return redirect()
            ->route('empleados.index')
            ->with('success', 'Empleado creado correctamente.');
    }

    // Muestra el detalle de un empleado.
    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    // Muestra el formulario para editar un empleado.
    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    // Actualiza la informacion de un empleado.
    public function update(Request $request, Empleado $empleado)
    {
        $empleado->update($this->validarEmpleado($request));

        return redirect()
            ->route('empleados.index')
            ->with('success', 'Empleado actualizado correctamente.');
    }

    // Elimina un empleado de la base de datos.
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect()
            ->route('empleados.index')
            ->with('success', 'Empleado eliminado correctamente.');
    }

    // Valida los datos que llegan desde crear y editar.
    private function validarEmpleado(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'puesto' => ['nullable', 'string', 'max:255'],
            'correo' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            // Activo es booleano, pero no se exige para permitir usar el valor default de la base.
            'activo' => ['boolean'],
        ]);
    }
}

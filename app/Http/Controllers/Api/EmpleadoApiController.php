<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmpleadoApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/empleados
    public function index()
    {
        $empleados = Empleado::latest()->get();
        return response()->json(['data' => $empleados]);
    }

    // POST /api/empleados
    public function store(Request $request)
    {
        $data = $this->validateEmpleado($request);
        $empleado = Empleado::create($data);

        return response()->json(['data' => $empleado], 201);
    }

    // GET /api/empleados/{empleado}
    public function show(Empleado $empleado)
    {
        return response()->json(['data' => $empleado]);
    }

    // PUT/PATCH /api/empleados/{empleado}
    public function update(Request $request, Empleado $empleado)
    {
        $data = $this->validateEmpleado($request);
        $empleado->update($data);

        return response()->json(['data' => $empleado]);
    }

    // DELETE /api/empleados/{empleado}
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return response()->json(null, 204);
    }

    private function validateEmpleado(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'puesto' => ['nullable', 'string', 'max:255'],
            'correo' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'activo' => ['boolean'],
        ]);
    }
}

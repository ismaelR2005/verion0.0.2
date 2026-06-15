<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;

class EmpleadoApiController extends Controller
{
    public function __construct()
    {
        // Protege todos los endpoints de esta API con tokens Sanctum.
        $this->middleware('auth:sanctum');
    }

    // GET /api/empleados
    public function index()
    {
        // Devuelve todos los vehiculos en formato JSON.
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
        // La API recibe activo/disponible como booleanos separados.
        $data = $request->validate([
            'placa' => ['required', 'string', 'max:50'],
            'tipo' => ['nullable', 'string', 'max:100'],
            'modelo' => ['nullable', 'string', 'max:100'],
            'anio' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'numero_serie' => ['nullable', 'string', 'max:100'],
            'numero_serie_adicional' => ['nullable', 'string', 'max:100'],
            'motor' => ['nullable', 'string', 'max:100'],
            'proveedor' => ['nullable', 'string', 'max:255'],
            'personal_asignado' => ['nullable', 'string', 'max:255'],
            'estatus_operativo' => ['nullable', 'string', 'max:100'],
            'ultimo_comentario_mantenimiento' => ['nullable', 'string'],
            'descripcion' => ['nullable', 'string'],
            'tarjeta_circulacion' => ['nullable', 'string', 'max:255'],
            'poliza_seguro' => ['nullable', 'string', 'max:255'],
            'activo' => ['required_without:disponible', 'boolean'],
            'disponible' => ['required_without:activo', 'boolean'],
        ]);

        $activo = filter_var($data['activo'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $disponible = filter_var($data['disponible'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Debe existir un solo estado verdadero: activo o disponible.
        if ($activo === $disponible) {
            throw ValidationException::withMessages([
                'estado' => 'Debes elegir activo o disponible, pero no ambos.',
            ]);
        }

        $data['activo'] = $activo;
        $data['disponible'] = $disponible;

        return $data;
    }
}

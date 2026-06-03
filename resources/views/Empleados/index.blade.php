@extends('layouts.app')

@section('title','Empleados')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Empleados</h1>
        <a class="btn btn-success" href="{{ route('empleados.create') }}">Crear empleado</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Puesto</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->id }}</td>
                        <td>{{ $empleado->nombre }}</td>
                        <td>{{ $empleado->puesto }}</td>
                        <td>{{ $empleado->correo }}</td>
                        <td>{{ $empleado->telefono }}</td>
                        <td>{{ $empleado->activo ? 'Si' : 'No' }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('empleados.show', $empleado) }}">Ver</a>
                            <a class="btn btn-sm btn-secondary" href="{{ route('empleados.edit', $empleado) }}">Editar</a>

                            <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deseas eliminar este empleado?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay empleados registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

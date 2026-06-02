<h1>Empleados</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<p>
    <a href="{{ route('empleados.create') }}">Crear empleado</a>
</p>

<table border="1" cellpadding="8">
    <thead>
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
                    <a href="{{ route('empleados.show', $empleado) }}">Ver</a>
                    <a href="{{ route('empleados.edit', $empleado) }}">Editar</a>

                    <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Deseas eliminar este empleado?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No hay empleados registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>

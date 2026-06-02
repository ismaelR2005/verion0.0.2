<h1>Detalle del empleado</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<p><strong>ID:</strong> {{ $empleado->id }}</p>
<p><strong>Nombre:</strong> {{ $empleado->nombre }}</p>
<p><strong>Puesto:</strong> {{ $empleado->puesto }}</p>
<p><strong>Correo:</strong> {{ $empleado->correo }}</p>
<p><strong>Telefono:</strong> {{ $empleado->telefono }}</p>
<p><strong>Activo:</strong> {{ $empleado->activo ? 'Si' : 'No' }}</p>

<p>
    <a href="{{ route('empleados.edit', $empleado) }}">Editar</a>
    <a href="{{ route('empleados.index') }}">Volver</a>
</p>

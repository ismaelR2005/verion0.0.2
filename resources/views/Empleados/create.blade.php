<h1>Crear empleado</h1>

@if($errors->any())
    <div>
        <p>Revisa los datos del formulario:</p>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('empleados.store') }}" method="POST">
    @csrf

    <p>
        <label for="nombre">Nombre</label><br>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}">
    </p>

    <p>
        <label for="puesto">Puesto</label><br>
        <input type="text" id="puesto" name="puesto" value="{{ old('puesto') }}">
    </p>

    <p>
        <label for="correo">Correo</label><br>
        <input type="email" id="correo" name="correo" value="{{ old('correo') }}">
    </p>

    <p>
        <label for="telefono">Telefono</label><br>
        <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}">
    </p>

    <p>
        <input type="hidden" name="activo" value="0">
        <label>
            <input type="checkbox" name="activo" value="1" @checked(old('activo', true))>
            Activo
        </label>
    </p>

    <button type="submit">Guardar</button>
    <a href="{{ route('empleados.index') }}">Volver</a>
</form>

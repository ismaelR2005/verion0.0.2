@extends('layouts.app')

@section('title','Editar empleado')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h5">Editar empleado</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    <p class="mb-1">Revisa los datos del formulario:</p>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('empleados.update', $empleado) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre) }}">
                </div>

                <div class="mb-3">
                    <label for="puesto" class="form-label">Puesto</label>
                    <input type="text" class="form-control" id="puesto" name="puesto" value="{{ old('puesto', $empleado->puesto) }}">
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $empleado->correo) }}">
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $empleado->telefono) }}">
                </div>

                <div class="form-check mb-3">
                    <input type="hidden" name="activo" value="0">
                    <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo" @checked(old('activo', $empleado->activo))>
                    <label class="form-check-label" for="activo">Activo</label>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
@endsection

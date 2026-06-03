@extends('layouts.app')

@section('title','Detalle del empleado')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h5">Detalle del empleado</h1>

            <div class="row g-2 mt-3">
                <div class="col-12 col-md-6"><strong>ID:</strong> {{ $empleado->id }}</div>
                <div class="col-12 col-md-6"><strong>Nombre:</strong> {{ $empleado->nombre }}</div>
                <div class="col-12 col-md-6"><strong>Puesto:</strong> {{ $empleado->puesto }}</div>
                <div class="col-12 col-md-6"><strong>Correo:</strong> {{ $empleado->correo }}</div>
                <div class="col-12 col-md-6"><strong>Telefono:</strong> {{ $empleado->telefono }}</div>
                <div class="col-12 col-md-6"><strong>Activo:</strong> {{ $empleado->activo ? 'Si' : 'No' }}</div>
            </div>

            <div class="mt-3">
                <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-secondary">Editar</a>
                <a href="{{ route('empleados.index') }}" class="btn btn-light">Volver</a>
            </div>
        </div>
    </div>
@endsection

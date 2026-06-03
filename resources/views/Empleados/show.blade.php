@extends('layouts.app')

@section('title','Detalle del empleado')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h5">Detalle del empleado</h1>

            <div class="row g-2 mt-3">
                <div class="col-12 col-md-8">
                    <div class="row g-2">
                        <div class="col-12 col-md-6"><strong>ID:</strong> {{ $empleado->id }}</div>
                        <div class="col-12 col-md-6"><strong>Nombre:</strong> {{ $empleado->nombre }}</div>
                        <div class="col-12 col-md-6"><strong>Puesto:</strong> {{ $empleado->puesto }}</div>
                        <div class="col-12 col-md-6"><strong>Correo:</strong> {{ $empleado->correo }}</div>
                        <div class="col-12 col-md-6"><strong>Telefono:</strong> {{ $empleado->telefono }}</div>
                        <div class="col-12 col-md-6"><strong>Activo:</strong> {{ $empleado->activo ? 'Si' : 'No' }}</div>
                    </div>
                </div>

                <div class="col-12 col-md-4 text-md-center">
                    <strong class="d-block mb-2">Codigo QR</strong>
                    {{-- QR generado automaticamente para este empleado. --}}
                    <img src="{{ $empleado->qrImagenUrl(220) }}" alt="QR de {{ $empleado->nombre }}" class="img-fluid border rounded p-2" width="220" height="220">
                    <p class="small text-muted mt-2 mb-0">Al escanearlo abre este detalle.</p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-secondary">Editar</a>
                <a href="{{ route('empleados.index') }}" class="btn btn-light">Volver</a>
            </div>
        </div>
    </div>
@endsection

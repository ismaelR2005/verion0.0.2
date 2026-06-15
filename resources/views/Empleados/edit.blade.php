@extends('layouts.app')

@section('title','Editar equipo')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h5">Editar equipo</h1>

            {{-- Lista los errores si algun dato del formulario no pasa la validacion. --}}
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

            <form action="{{ route('empleados.update', $empleado) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('Empleados._form', ['empleado' => $empleado])

                <div class="mt-3 d-grid d-sm-flex gap-2">
                    {{-- Botones finales del formulario. --}}
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
@endsection

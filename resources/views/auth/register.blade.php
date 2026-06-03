@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="h5 mb-3">Registrarse</h1>

                    {{-- Muestra errores al crear la cuenta. --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contrasena</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar contrasena</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
                    </form>

                    <p class="small text-muted mt-3 mb-0">
                        Ya tienes cuenta?
                        <a href="{{ route('login') }}">Inicia sesion</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

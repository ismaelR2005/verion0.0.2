@extends('layouts.app')

@section('title', 'Iniciar sesion')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="h5 mb-3">Iniciar sesion</h1>

                    {{-- Muestra errores de autenticacion o validacion. --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contrasena</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                            <label class="form-check-label" for="remember">Recordarme</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>

                    <p class="small text-muted mt-3 mb-0">
                        Usuario de prueba: test@example.com / password
                    </p>

                    <p class="small text-muted mt-2 mb-0">
                        No tienes cuenta?
                        <a href="{{ route('register') }}">Registrate</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

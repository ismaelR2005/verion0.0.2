<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aplicación')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-" crossorigin="anonymous">
    <style>
        body { padding-top: 56px; }
    </style>
    {{-- Permite que vistas especificas carguen sus estilos sin afectar todo el layout. --}}
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Mi App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('empleados.index') }}">Empleados</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('detector-qr') }}">Detector QR</a></li>
                        <li class="nav-item">
                            {{-- Boton para cerrar la sesion actual. --}}
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Salir</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-" crossorigin="anonymous"></script>
    {{-- Permite que vistas especificas carguen scripts propios al final del body. --}}
    @stack('scripts')
</body>
</html>

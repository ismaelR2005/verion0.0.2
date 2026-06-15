<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aplicación')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-" crossorigin="anonymous">
    <style>
        body { padding-top: 56px; }
        .navbar-light-green { background-color: #299c44; } /* Cambio: barra superior en verde claro. */
        .navbar-brand-centered {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }

        @media (max-width: 991.98px) {
            /* Cambio responsivo: acomoda la barra en telefono y tablet sin tocar escritorio. */
            .navbar .container {
                display: grid;
                grid-template-columns: 48px 1fr 48px;
                align-items: center;
                gap: 0.5rem;
            }

            .navbar-brand-centered {
                grid-column: 2;
                position: static;
                transform: none;
                justify-self: center;
                margin: 0;
                max-width: 100%;
                text-align: center;
                white-space: normal;
                line-height: 1.15;
                font-size: 1rem;
            }

            .navbar-toggler {
                grid-column: 3;
                justify-self: end;
            }

            .navbar-collapse {
                grid-column: 1 / -1;
                width: 100%;
                padding-top: 0.75rem;
            }

            main.container {
                max-width: 100%;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .card,
            .table-responsive,
            .alert {
                background-color: rgba(255, 255, 255, 0.96);
            }

            .card,
            .alert,
            .form-control,
            .table {
                overflow-wrap: anywhere;
            }
        }

        @media (max-width: 767.98px) {
            /* Cambio responsivo: en telefono la tabla se lee como tarjetas. */
            .card-body {
                padding: 1rem;
            }

            .login-image {
                height: 170px !important;
            }

            .responsive-card-table {
                border-collapse: separate;
                border-spacing: 0 0.75rem;
            }

            .responsive-card-table thead {
                display: none;
            }

            .responsive-card-table,
            .responsive-card-table tbody,
            .responsive-card-table tr,
            .responsive-card-table td {
                display: block;
                width: 100%;
            }

            .responsive-card-table tr {
                background: #ffffff;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                box-shadow: 0 4px 14px rgba(33, 37, 41, 0.08);
                padding: 0.5rem 0;
            }

            .responsive-card-table td {
                border: 0;
                padding: 0.45rem 0.85rem;
            }

            .responsive-card-table td::before {
                content: attr(data-label);
                display: block;
                color: #6c757d;
                font-size: 0.78rem;
                font-weight: 700;
                text-transform: uppercase;
            }

            .mobile-actions {
                display: grid !important;
                gap: 0.5rem;
            }

            .mobile-actions .btn,
            .mobile-actions form,
            .mobile-actions button {
                width: 100%;
            }
        }
    </style>
    {{-- Permite que vistas especificas carguen sus estilos sin afectar todo el layout. --}}
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-light-green fixed-top">
        <div class="container position-relative">
            <a class="navbar-brand navbar-brand-centered" href="{{ url('/') }}">Concreto Lanzado Fresnillo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(auth()->user()->isAdministrador())
                            <li class="nav-item"><a class="nav-link" href="{{ route('empleados.index') }}">Equipos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('empleados.importar-csv') }}">Importar CSV</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('empleados.carga-masiva') }}">Carga masiva</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ route('detector-qr') }}">Detector QR</a></li>
                        @if(auth()->user()->isSuperadministrador())
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Usuarios</a></li>
                        @endif
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

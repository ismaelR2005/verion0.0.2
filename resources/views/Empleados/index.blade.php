@extends('layouts.app')

@section('title','Equipos')

@section('content')
    {{-- Encabezado del modulo y boton para registrar un equipo nuevo. --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-2 mb-3">
        <h1 class="h3 mb-0">Equipos</h1>
        <div class="d-grid d-sm-flex gap-2">
            <a class="btn btn-outline-primary" href="{{ route('empleados.importar-csv') }}">Importar CSV</a>
            <a class="btn btn-outline-primary" href="{{ route('empleados.carga-masiva') }}">Carga masiva</a>
            <a class="btn btn-success" href="{{ route('empleados.create') }}">Crear equipo</a>
            @if(auth()->user()->isSuperadministrador())
                <form action="{{ route('empleados.destroy-all') }}" method="POST" class="d-grid">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="btn btn-danger"
                        onclick="return confirm('Deseas eliminar todos los equipos? Esta accion no se puede deshacer.')"
                    >
                        Borrar todos
                    </button>
                </form>
            @endif
        </div>
    </div>

    @php
        $columnas = [
            ['clave', 'Clave'],
            ['nombre_equipo', 'Nombre de equipo'],
            ['fecha_alta', 'Fecha alta', 'date'],
            ['marca_modelo', 'Marca/modelo'],
            ['modelo', 'Modelo'],
            ['placas', 'Placas'],
            ['numero_serie', 'Numero de serie'],
            ['numero_serie_eq_adicional', 'Serie eq. adicional'],
            ['tenencia', 'Tenencia'],
            ['tarjeta_circulacion', 'Tarjeta de circulacion'],
            ['tipo_motor', 'Tipo motor'],
            ['tipo_filtro', 'Filtros de motor'],
            ['area', 'Area'],
            ['familia', 'Familia'],
            ['fecha_fabricacion', 'Fecha fabricacion', 'date'],
            ['asignado_a', 'Asignado a'],
            ['estado', 'Estado'],
            ['proveedor', 'Proveedor'],
            ['horometro_odometro', 'Horometro/odometro'],
            ['disponibilidad', 'Disponibilidad'],
            ['descripcion', 'Descripcion'],
            ['refacciones', 'Refacciones'],
        ];
    @endphp

    {{-- Tabla responsive con los apartados completos del equipo. --}}
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle responsive-card-table">
            <thead class="table-light">
                <tr>
                    @foreach($columnas as $columna)
                        <th>{{ $columna[1] }}</th>
                    @endforeach
                    <th>Poliza PDF</th>
                    <th>Factura PDF</th>
                    <th>QR</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empleados as $empleado)
                    <tr>
                        @foreach($columnas as $columna)
                            @php
                                $name = $columna[0];
                                $label = $columna[1];
                                $type = $columna[2] ?? 'text';
                                $value = $empleado->{$name};

                                if ($type === 'date' && $value instanceof \Illuminate\Support\Carbon) {
                                    $value = $value->format('Y-m-d');
                                }
                            @endphp
                            <td data-label="{{ $label }}">{{ filled($value) ? $value : 'N/D' }}</td>
                        @endforeach
                        <td data-label="Poliza PDF">
                            @if($empleado->tienePolizaPdf())
                                <a href="{{ route('empleados.pdf', [$empleado, 'poliza']) }}" target="_blank">Ver PDF</a>
                            @else
                                <span class="text-muted">Sin PDF</span>
                            @endif
                        </td>
                        <td data-label="Factura PDF">
                            @if($empleado->tieneFacturaPdf())
                                <a href="{{ route('empleados.pdf', [$empleado, 'factura']) }}" target="_blank">Ver PDF</a>
                            @else
                                <span class="text-muted">Sin PDF</span>
                            @endif
                        </td>
                        <td data-label="QR">
                            {{-- QR automatico para abrir el detalle del equipo. --}}
                            <a href="{{ route('empleados.show', $empleado) }}">
                                <img src="{{ $empleado->qrImagenUrl(80) }}" alt="QR de {{ $empleado->clave }}" width="80">
                            </a>
                        </td>
                        <td data-label="Acciones">
                            {{-- Acciones principales para consultar, modificar o eliminar el equipo. --}}
                            <div class="d-flex flex-column flex-md-row gap-1 mobile-actions">
                                <a class="btn btn-sm btn-primary" href="{{ route('empleados.show', $empleado) }}">Ver</a>
                                @if(auth()->user()->isSuperadministrador())
                                    <a class="btn btn-sm btn-secondary" href="{{ route('empleados.edit', $empleado) }}">Editar</a>

                                    <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deseas eliminar este equipo?')">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        {{-- Mensaje cuando todavia no existe ningun registro. --}}
                        <td colspan="{{ count($columnas) + 4 }}" class="text-center">No hay equipos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

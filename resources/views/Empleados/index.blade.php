@extends('layouts.app')

@section('title','Unidades')

@section('content')
    <section class="brand-hero">
        <div>
            <p class="brand-hero__label">Panel operativo</p>
            <h1 class="h3 mb-1">Unidades</h1>
            <p class="mb-0">Control visual de maquinaria, documentos, fotos y codigos QR.</p>
        </div>
    </section>

    {{-- Encabezado del modulo y boton para registrar una unidad nueva. --}}
    <div class="d-flex flex-column flex-sm-row justify-content-end align-items-stretch align-items-sm-center gap-2 mb-3">
        <div class="d-grid d-sm-flex gap-2">
            <a class="btn btn-outline-primary" href="{{ route('empleados.importar-csv') }}">Importar CSV</a>
            <a class="btn btn-outline-primary" href="{{ route('empleados.carga-masiva') }}">Carga masiva</a>
            <a class="btn btn-outline-primary" href="{{ route('empleados.fotos-masivas') }}">Fotos masivas</a>
            <a class="btn btn-outline-primary" href="{{ route('empleados.catalogo-qr') }}">Catalogo QR</a>
            <a class="btn btn-success" href="{{ route('empleados.create') }}">Crear unidad</a>
            @if(auth()->user()->isSuperadministrador())
                <form action="{{ route('empleados.destroy-all') }}" method="POST" class="d-grid">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="btn btn-danger"
                        onclick="return confirm('Deseas eliminar todas las unidades? Esta accion no se puede deshacer.')"
                    >
                    Borrar todas
                    </button>
                </form>
            @endif
        </div>
    </div>

    @php
        $columnas = [
            ['clave', 'Clave'],
            ['nombre_equipo', 'Nombre de unidad'],
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

    {{-- Tabla responsive con los apartados completos de la unidad. --}}
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle responsive-card-table">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
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
                        <td data-label="Foto">
                            @if($empleado->tieneFoto())
                                <img src="{{ route('empleados.foto', $empleado) }}" alt="Foto de {{ $empleado->clave }}" class="img-thumbnail" style="width: 90px; height: 70px; object-fit: cover;">
                            @else
                                <span class="text-muted">Sin foto</span>
                            @endif
                        </td>
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
                            {{-- QR automatico para abrir el detalle de la unidad. --}}
                            <a href="{{ route('empleados.show', $empleado) }}">
                                <img src="{{ $empleado->qrImagenUrl(80) }}" alt="QR de {{ $empleado->clave }}" width="80">
                            </a>
                        </td>
                        <td data-label="Medicion">
                            @if($empleado->usaHorometro())
                                {{ number_format($empleado->horometroHorasActuales(), 2) }} h
                                @if($empleado->horometro_en_marcha)
                                    <span class="badge text-bg-success">Activo</span>
                                @endif
                            @elseif($empleado->usaOdometro())
                                {{ number_format($empleado->odometroKilometrosCiclo(), 2) }} km
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td data-label="Alerta servicio">
                            @php
                                $alertaHorometro = $empleado->usaHorometro() ? $empleado->alertaHorometroActual() : null;
                                $alertaOdometro = $empleado->usaOdometro() ? $empleado->alertaOdometroActual() : null;
                            @endphp
                            @if($alertaHorometro)
                                <span class="badge text-bg-warning text-wrap">{{ $alertaHorometro['horas'] }} h: {{ $alertaHorometro['mensaje'] }}</span>
                            @elseif($alertaOdometro)
                                <span class="badge text-bg-warning text-wrap">{{ $alertaOdometro['kilometros'] }} km: {{ $alertaOdometro['mensaje'] }}</span>
                            @else
                                <span class="text-muted">Sin alerta</span>
                            @endif
                        </td>
                        <td data-label="Acciones">
                            {{-- Acciones principales para consultar, modificar o eliminar la unidad. --}}
                            <div class="d-flex flex-column flex-md-row gap-1 mobile-actions">
                                <a class="btn btn-sm btn-primary" href="{{ route('empleados.show', $empleado) }}">Ver</a>
                                @if(auth()->user()->isSuperadministrador())
                                    <a class="btn btn-sm btn-secondary" href="{{ route('empleados.edit', $empleado) }}">Editar</a>

                                    <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deseas eliminar esta unidad?')">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        {{-- Mensaje cuando todavia no existe ningun registro. --}}
                        <td colspan="{{ count($columnas) + 7 }}" class="text-center">No hay unidades registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

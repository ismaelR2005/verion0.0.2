@extends('layouts.app')

@section('title','Detalle del equipo')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h5">Detalle del equipo</h1>

            {{-- Datos completos del equipo seleccionado. --}}
            <div class="row g-3 mt-2">
                <div class="col-12 col-lg-8">
                    <div class="row g-2">
                        @foreach([
                            'Clave' => $empleado->clave,
                            'Nombre de equipo' => $empleado->nombre_equipo,
                            'Fecha alta' => $empleado->fecha_alta?->format('Y-m-d'),
                            'Marca/modelo' => $empleado->marca_modelo,
                            'Modelo' => $empleado->modelo,
                            'Numero de serie' => $empleado->numero_serie,
                            'Numero de serie eq. adicional' => $empleado->numero_serie_eq_adicional,
                            'Tenencia' => $empleado->tenencia,
                            'Tarjeta de circulacion' => $empleado->tarjeta_circulacion,
                            'Tipo motor' => $empleado->tipo_motor,
                            'Filtros de motor' => $empleado->tipo_filtro,
                            'Familia' => $empleado->familia,
                            'Fecha de fabricacion' => $empleado->fecha_fabricacion?->format('Y-m-d'),
                            'Estado' => $empleado->estado,
                            'Proveedor' => $empleado->proveedor,
                            'Horometro/odometro' => $empleado->horometro_odometro,
                        ] as $label => $value)
                            <div class="col-12 col-md-6"><strong>{{ $label }}:</strong> {{ $value }}</div>
                        @endforeach

                        <div class="col-12"><strong>Descripcion:</strong> {{ $empleado->descripcion }}</div>
                        <div class="col-12"><strong>Refacciones:</strong> {{ $empleado->refacciones }}</div>

                        <div class="col-12">
                            <strong>Documentos anexados:</strong>
                            {{-- PDFs generados por clave o cargados manualmente. --}}
                            <div class="d-flex flex-column flex-sm-row gap-2 mt-1">
                                @if($empleado->tienePolizaPdf())
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('empleados.pdf', [$empleado, 'poliza']) }}" target="_blank">Ver poliza</a>
                                @endif
                                @if($empleado->tieneFacturaPdf())
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('empleados.pdf', [$empleado, 'factura']) }}" target="_blank">Ver factura</a>
                                @endif
                                @if(! $empleado->tienePolizaPdf() && ! $empleado->tieneFacturaPdf())
                                    <span class="text-muted">Sin documentos anexados.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4 text-center">
                    <strong class="d-block mb-2">Codigo QR</strong>
                    {{-- QR generado automaticamente para este equipo. --}}
                    <img src="{{ $empleado->qrImagenUrl(220) }}" alt="QR de {{ $empleado->clave }}" class="img-fluid border rounded p-2" width="220">
                    <p class="small text-muted mb-0">Al escanearlo abre este detalle.</p>
                </div>
            </div>

            @if(auth()->user()->isAdministrador())
                <div class="mt-3 d-grid d-sm-flex gap-2">
                    {{-- Acciones para modificar el registro o regresar al listado. --}}
                    <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-secondary">Editar</a>
                    <a href="{{ route('empleados.index') }}" class="btn btn-light">Volver</a>
                </div>
            @else
                <div class="mt-3">
                    <a href="{{ route('detector-qr') }}" class="btn btn-light">Volver al detector</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@php
    $empleado = $empleado ?? null;
    $fields = [
        ['clave', 'Clave', 'text', false],
        ['nombre_equipo', 'Nombre de equipo', 'text', false],
        ['fecha_alta', 'Fecha alta', 'date', false],
        ['marca_modelo', 'Marca/modelo', 'text', false],
        ['modelo', 'Modelo', 'text', false],
        ['placas', 'Placas', 'text', false],
        ['numero_serie', 'Numero de serie', 'text', false],
        ['numero_serie_eq_adicional', 'Numero de serie eq. adicional', 'text', false],
        ['tenencia', 'Tenencia', 'text', false],
        ['tarjeta_circulacion', 'Tarjeta de circulacion', 'text', false],
        ['tipo_motor', 'Tipo motor', 'text', false],
        ['tipo_filtro', 'Filtros de motor', 'text', false],
        ['familia', 'Familia', 'text', false],
        ['fecha_fabricacion', 'Fecha de fabricacion', 'date', false],
        ['proveedor', 'Proveedor', 'text', false],
    ];

    $estadoValue = old('estado', $empleado?->estado ?? 'Activo');
    $estadoValue = ucfirst(strtolower((string) $estadoValue));
    $medidorValue = old('horometro_odometro', $empleado?->horometro_odometro);
    $medidorValue = ucfirst(strtolower((string) $medidorValue));
@endphp

<div class="row g-3">
    @foreach($fields as [$name, $label, $type, $required])
        @php
            $value = old($name, $empleado?->{$name});
            if ($value instanceof \Illuminate\Support\Carbon) {
                $value = $value->format('Y-m-d');
            }
        @endphp

        <div class="col-12 col-md-6 col-xl-4">
            <label for="{{ $name }}" class="form-label">{{ $label }}</label>
            <input
                type="{{ $type }}"
                class="form-control @error($name) is-invalid @enderror"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ $value }}"
                @required($required)
            >
            @error($name)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endforeach

    <div class="col-12 col-md-6">
        <label class="form-label d-block">Estado</label>
        <div class="btn-group" role="group" aria-label="Estado del equipo">
            @foreach(['Activo', 'Inactivo'] as $option)
                <input
                    type="radio"
                    class="btn-check @error('estado') is-invalid @enderror"
                    name="estado"
                    id="estado_{{ strtolower($option) }}"
                    value="{{ $option }}"
                    autocomplete="off"
                    @checked($estadoValue === $option)
                >
                <label class="btn btn-outline-primary" for="estado_{{ strtolower($option) }}">{{ $option }}</label>
            @endforeach
        </div>
        @error('estado')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label class="form-label d-block">Horometro/odometro</label>
        <div class="btn-group" role="group" aria-label="Tipo de medicion">
            @foreach(['Horometro', 'Odometro'] as $option)
                <input
                    type="radio"
                    class="btn-check @error('horometro_odometro') is-invalid @enderror"
                    name="horometro_odometro"
                    id="medidor_{{ strtolower($option) }}"
                    value="{{ $option }}"
                    autocomplete="off"
                    @checked($medidorValue === $option)
                >
                <label class="btn btn-outline-primary" for="medidor_{{ strtolower($option) }}">{{ $option }}</label>
            @endforeach
        </div>
        @error('horometro_odometro')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="descripcion" class="form-label">Descripcion</label>
        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $empleado?->descripcion) }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="refacciones" class="form-label">Refacciones</label>
        <textarea class="form-control @error('refacciones') is-invalid @enderror" id="refacciones" name="refacciones" rows="3">{{ old('refacciones', $empleado?->refacciones) }}</textarea>
        @error('refacciones')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="poliza_pdf" class="form-label">Anexar poliza en PDF</label>
        <input type="file" class="form-control @error('poliza_pdf') is-invalid @enderror" id="poliza_pdf" name="poliza_pdf" accept="application/pdf">
        {{-- Si no se sube archivo, Laravel busca por clave en CONCRETO2/Polizas. --}}
        @if($empleado?->tienePolizaPdf())
            <a class="small d-inline-block mt-1" href="{{ route('empleados.pdf', [$empleado, 'poliza']) }}" target="_blank">Ver poliza actual</a>
        @endif
        @error('poliza_pdf')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="factura_pdf" class="form-label">Anexar factura en PDF</label>
        <input type="file" class="form-control @error('factura_pdf') is-invalid @enderror" id="factura_pdf" name="factura_pdf" accept="application/pdf">
        {{-- Al subir una factura nueva se elimina la anterior guardada. --}}
        @if($empleado?->tieneFacturaPdf())
            <a class="small d-inline-block mt-1" href="{{ route('empleados.pdf', [$empleado, 'factura']) }}" target="_blank">Ver factura actual</a>
        @endif
        @error('factura_pdf')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

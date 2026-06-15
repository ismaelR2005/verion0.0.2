<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Empleado extends Model
{
    // Campos del vehiculo que Laravel permite guardar desde formularios o API.
    protected $fillable = [
        'clave',
        'nombre_equipo',
        'fecha_alta',
        'marca_modelo',
        'modelo',
        'poliza',
        'numero_serie',
        'numero_serie_eq_adicional',
        'placas',
        'tenencia',
        'tarjeta_circulacion',
        'tipo_motor',
        'area',
        'familia',
        'fecha_fabricacion',
        'asignado_a',
        'estado',
        'proveedor',
        'descripcion',
        'horometro_odometro',
        'disponibilidad',
        'refacciones',
        'factura',
        'tipo_filtro',
        'poliza_pdf_path',
        'factura_pdf_path',
        'placa',
        'tipo',
        'anio',
        'numero_serie_adicional',
        'motor',
        'personal_asignado',
        'estatus_operativo',
        'ultimo_comentario_mantenimiento',
        'poliza_seguro',
        'activo',
        'disponible',
    ];

    // Convierte fechas y estados booleanos al usar el modelo.
    protected $casts = [
        'fecha_alta' => 'date',
        'fecha_fabricacion' => 'date',
        'activo' => 'boolean',
        'disponible' => 'boolean',
    ];

    // Texto que se guarda dentro del QR: abre el detalle del vehiculo con su clave.
    public function qrContenido(): string
    {
        return route('empleados.show', [
            'empleado' => $this->clave,
        ]);
    }

    // Imagen QR generada automaticamente desde el contenido del vehiculo.
    public function qrImagenUrl(int $size = 160): string
    {
        $fontSize = max(10, (int) round($size * 0.09));

        return 'https://quickchart.io/qr?' . http_build_query([
            'text' => $this->qrContenido(),
            'size' => $size,
            'margin' => 2,
            'caption' => $this->clave,
            'captionFontFamily' => 'mono',
            'captionFontSize' => $fontSize,
        ]);
    }

    public function tienePolizaPdf(): bool
    {
        return filled($this->poliza_pdf_path) && Storage::disk('local')->exists($this->poliza_pdf_path);
    }

    public function tieneFacturaPdf(): bool
    {
        return filled($this->factura_pdf_path) && Storage::disk('local')->exists($this->factura_pdf_path);
    }
}

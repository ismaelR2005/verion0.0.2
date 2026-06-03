<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

    // Campos que se pueden asignar de forma masiva desde formularios.
    protected $fillable = [
        'nombre',
        'puesto',
        'correo',
        'telefono',
        'activo',
    ];

    // Convierte el campo activo a verdadero o falso al usar el modelo.
    protected $casts = [
        'activo' => 'boolean',
    ];

    // Texto que se guarda dentro del QR: abre el detalle del empleado.
    public function qrContenido(): string
    {
        return route('empleados.show', $this);
    }

    // Imagen QR generada automaticamente desde el contenido del empleado.
    public function qrImagenUrl(int $size = 160): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size='
            . $size . 'x' . $size
            . '&data=' . rawurlencode($this->qrContenido());
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model
{
    use HasFactory;

    // Tabla MySQL asociada en tu base de datos
    protected $table = 'empleados';

    // Atributos asignables de forma masiva (Protección del sistema)
    protected $fillable = [
        'cedula',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'telefono',
        'correo',
        'direccion',
        'tipo_personal',
        'cargo',
        'fecha_ingreso',
        'estatus'
    ];

    // Casts de fecha para que Laravel las trate automáticamente como objetos Carbon
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date'
    ];

    /**
     * Scope local para buscar empleados de forma rápida en el sistema del CEI.
     */
    public function scopeBuscar($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where('cedula', 'LIKE', "%{$search}%")
                     ->orWhere('nombres', 'LIKE', "%{$search}%")
                     ->orWhere('apellidos', 'LIKE', "%{$search}%")
                     ->orWhere('cargo', 'LIKE', "%{$search}%");
    }
}
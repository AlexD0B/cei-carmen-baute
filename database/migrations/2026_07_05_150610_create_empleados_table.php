<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     * Recreación del esquema MySQL para el control del personal del CEI Carmen Baute.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            
            // Cédula de Identidad Única (con formato V-XXXX o E-XXXX)
            $table->string('cedula', 15)->unique();
            
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->date('fecha_nacimiento');
            $table->string('telefono', 20);
            $table->string('correo', 100)->nullable();
            $table->text('direccion');
            
            // Clasificación del Empleado (Docente, Administrativo, Operativo)
            $table->enum('tipo_personal', ['Docente', 'Administrativo', 'Operativo']);
            
            $table->string('cargo', 100); // Cargo detallado (Ej: Docente de aula, Vigilante, Cocinera)
            $table->date('fecha_ingreso');
            
            // Control de Estatus
            $table->enum('estatus', ['Activo', 'Inactivo', 'Comisión de Servicio'])->default('Activo');
            
            $table->timestamps();
            
            // Índice de optimización para búsquedas en el sistema del CEI
            $table->index(['cedula', 'tipo_personal', 'estatus']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
}
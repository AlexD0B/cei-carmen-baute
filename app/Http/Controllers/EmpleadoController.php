<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmpleadoController extends Controller
{
    /**
     * Desplegar la vista principal y listado con filtros para el CEI Carmen Baute.
     */
    public function index(Request $request)
    {
        $query = Empleado::query();

        // Aplicar filtros de tipo de personal (Docente, Administrativo, Operativo)
        if ($request->filled('tipo_personal')) {
            $query->where('tipo_personal', $request->tipo_personal);
        }

        // Aplicar filtros de estatus (Activo, Inactivo, Comisión de Servicio)
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        // Aplicar el buscador unificado (por cédula, nombre, apellido o cargo)
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        // Obtener listado ordenado alfabéticamente por apellido con paginación
        $empleados = $query->orderBy('apellidos', 'asc')->paginate(15);

        return view('empleados.index', compact('empleados'));
    }

    /**
     * Almacenar un nuevo empleado en la base de datos MySQL con sus respectivas validaciones.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cedula' => 'required|string|max:15|unique:empleados,cedula',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string|max:20',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'required|string',
            'tipo_personal' => ['required', Rule::in(['Docente', 'Administrativo', 'Operativo'])],
            'cargo' => 'required|string|max:100',
            'fecha_ingreso' => 'required|date',
            'estatus' => ['required', Rule::in(['Activo', 'Inactivo', 'Comisión de Servicio'])],
        ]);

        Empleado::create($validated);

        return redirect()->route('empleados.index')
            ->with('success', '¡Personal del CEI registrado exitosamente!');
    }

    /**
     * Actualizar los datos del expediente del personal en la base de datos.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            // Valida la cédula ignorando el ID actual para permitir la actualización del mismo registro
            'cedula' => ['required', 'string', 'max:15', Rule::unique('empleados')->ignore($empleado->id)],
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string|max:20',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'required|string',
            'tipo_personal' => ['required', Rule::in(['Docente', 'Administrativo', 'Operativo'])],
            'cargo' => 'required|string|max:100',
            'fecha_ingreso' => 'required|date',
            'estatus' => ['required', Rule::in(['Activo', 'Inactivo', 'Comisión de Servicio'])],
        ]);

        $empleado->update($validated);

        return redirect()->route('empleados.index')
            ->with('success', '¡Expediente de personal actualizado con éxito!');
    }

    /**
     * Eliminar permanentemente el registro de la base de datos MySQL.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'El registro ha sido eliminado del sistema del CEI.');
    }
}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA DE GESTIÓN DE PERSONAL - CEI Carmen Baute</title>
    <!-- Tailwind CSS para Estilos e Inyección de Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Iconos FontAwesome para la Barra Lateral y Tarjetas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- HEADER INSTITUCIONAL (Idéntico a image_45db0c.jpg) -->
    <header class="bg-gradient-to-r from-teal-800 via-blue-900 to-indigo-950 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-white/10 rounded-xl backdrop-blur-sm">
                    <i class="fa-solid fa-building-ranking text-2xl text-teal-300"></i>
                </div>
                <div>
                    <span class="text-[10px] tracking-widest font-bold uppercase text-teal-300 block">SISTEMA DE GESTIÓN DE PERSONAL</span>
                    <h1 class="text-xl md:text-2xl font-black tracking-tight">CEI "Carmen Baute"</h1>
                    <div class="flex items-center space-x-2 text-xs text-slate-300 mt-0.5">
                        <i class="fa-solid fa-location-dot text-rose-400"></i>
                        <span>El Corozo, Municipio Maturín, Estado Monagas</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="hidden sm:inline-block text-xs bg-slate-800/60 text-slate-200 px-3 py-1.5 rounded-full border border-slate-700">
                    Versión Estable 1.0 (Laravel Framework + MySQL)
                </span>
                <div class="flex space-x-1 h-3 w-16 rounded overflow-hidden">
                    <div class="bg-[#FFCC00] w-1/3 h-full"></div>
                    <div class="bg-[#00247D] w-1/3 h-full"></div>
                    <div class="bg-[#CF142B] w-1/3 h-full"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- CUERPO PRINCIPAL CON BARRA LATERAL -->
    <div class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col lg:flex-row gap-6">
        
        <!-- BARRA LATERAL (MENÚ DE OPERACIONES) -->
        <aside class="lg:w-64 flex-shrink-0 bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80 h-fit space-y-1">
            <div class="px-3 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
                Menú de Operaciones
            </div>
            
            <a href="#panel" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold bg-teal-50 text-teal-700 shadow-sm shadow-teal-100/50 transition-all">
                <i class="fa-solid fa-chart-line text-teal-600 text-lg"></i>
                <span>Panel de Control</span>
            </a>

            <a href="#registro-tabla" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all">
                <i class="fa-solid fa-users text-slate-400 text-lg"></i>
                <span>Gestión de Personal</span>
                <span class="ml-auto bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md text-xs font-bold">
                    {{ $empleados->total() }}
                </span>
            </a>

            <div class="pt-4 mt-4 border-t border-slate-100 px-3 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
                Código y Configuración
            </div>

            <div class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-400 cursor-not-allowed">
                <i class="fa-solid fa-database text-lg"></i>
                <span>Arquitectura Laravel</span>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <main id="panel" class="flex-grow bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 space-y-6">
            
            <!-- ALERTAS DE ÉXITO -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl font-semibold text-sm flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- SECCIÓN: ESTADÍSTICAS AUTOMÁTICAS (Cálculos dinámicos desde Laravel) -->
            <div>
                <h2 class="text-xl font-bold text-slate-900">Estadísticas y Control del Plantel</h2>
                <p class="text-sm text-slate-500">Resumen y estado general de la fuerza laboral del CEI "Carmen Baute".</p>
            </div>

            @php
                // Cálculos dinámicos sobre la base de datos para las tarjetas de control
                $totalPersonal = \App\Models\Empleado::count();
                $totalDocentes = \App\Models\Empleado::where('tipo_personal', 'Docente')->count();
                $totalAdmin = \App\Models\Empleado::where('tipo_personal', 'Administrativo')->count();
                $totalOpe = \App\Models\Empleado::where('tipo_personal', 'Operativo')->count();
                
                // Evitar división por cero para los porcentajes de la gráfica
                $porcDocentes = $totalPersonal > 0 ? ($totalDocentes / $totalPersonal) * 100 : 0;
                $porcAdmin = $totalPersonal > 0 ? ($totalAdmin / $totalPersonal) * 100 : 0;
                $porcOpe = $totalPersonal > 0 ? ($totalOpe / $totalPersonal) * 100 : 0;
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100/50 p-5 rounded-2xl border border-indigo-100">
                  <span class="text-xs font-bold text-indigo-500 uppercase tracking-wider">Total Personal</span>
                  <div class="text-3xl font-black text-indigo-900 mt-1">{{ $totalPersonal }}</div>
                  <p class="text-xs text-indigo-700/70 mt-1">Registrados activos</p>
                </div>
                
                <div class="bg-gradient-to-br from-teal-50 to-teal-100/50 p-5 rounded-2xl border border-teal-100">
                  <span class="text-xs font-bold text-teal-500 uppercase tracking-wider">Personal Docente</span>
                  <div class="text-3xl font-black text-teal-900 mt-1">{{ $totalDocentes }}</div>
                  <p class="text-xs text-teal-700/70 mt-1">Aulas y especialistas</p>
                </div>

                <div class="bg-gradient-to-br from-sky-50 to-sky-100/50 p-5 rounded-2xl border border-sky-100">
                  <span class="text-xs font-bold text-sky-500 uppercase tracking-wider">Administrativo</span>
                  <div class="text-3xl font-black text-sky-900 mt-1">{{ $totalAdmin }}</div>
                  <p class="text-xs text-sky-700/70 mt-1">Apoyo y secretaría</p>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 p-5 rounded-2xl border border-amber-100">
                  <span class="text-xs font-bold text-amber-500 uppercase tracking-wider">Operativo</span>
                  <div class="text-3xl font-black text-amber-900 mt-1">{{ $totalOpe }}</div>
                  <p class="text-xs text-amber-700/70 mt-1">Mantenimiento y cocina</p>
                </div>
            </div>

            <!-- SECCIÓN INTERMEDIA: GRÁFICAS Y REGISTRO EXPEDITO -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 pt-2">
                
                <!-- Gráfica de Distribución en CSS Seguro -->
                <div class="md:col-span-7 bg-slate-50 p-5 rounded-2xl border border-slate-200/60 flex flex-col justify-between">
                  <div>
                    <h3 class="text-sm font-bold text-slate-800">Distribución de Roles de Personal</h3>
                    <p class="text-xs text-slate-500">Comparativa porcentual en tiempo real</p>
                  </div>
                  
                  <div class="py-6 flex justify-around items-end h-40">
                    <div class="flex flex-col items-center space-y-2 w-1/3">
                      <div class="text-xs font-bold text-teal-700">{{ number_format($porcDocentes, 0) }}%</div>
                      <div class="bg-teal-500 w-12 rounded-t-lg transition-all shadow-sm" style="height: {{ max($porcDocentes * 1.2, 10) }}px"></div>
                      <span class="text-[10px] font-semibold text-slate-500">Docentes</span>
                    </div>
                    <div class="flex flex-col items-center space-y-2 w-1/3">
                      <div class="text-xs font-bold text-sky-700">{{ number_format($porcAdmin, 0) }}%</div>
                      <div class="bg-sky-500 w-12 rounded-t-lg transition-all shadow-sm" style="height: {{ max($porcAdmin * 1.2, 10) }}px"></div>
                      <span class="text-[10px] font-semibold text-slate-500">Admin</span>
                    </div>
                    <div class="flex flex-col items-center space-y-2 w-1/3">
                      <div class="text-xs font-bold text-amber-700">{{ number_format($porcOpe, 0) }}%</div>
                      <div class="bg-amber-500 w-12 rounded-t-lg transition-all shadow-sm" style="height: {{ max($porcOpe * 1.2, 10) }}px"></div>
                      <span class="text-[10px] font-semibold text-slate-500">Operativos</span>
                    </div>
                  </div>
                </div>

                <!-- Bloque de Registro Rápido (Idéntico a image_45db0c.jpg) -->
                <div class="md:col-span-5 flex flex-col gap-3">
                  <div class="bg-slate-900 text-white p-5 rounded-2xl shadow-md flex-1 flex flex-col justify-between">
                    <div>
                      <h3 class="font-bold text-teal-300 text-sm tracking-wide uppercase">REGISTRO EXPEDITO</h3>
                      <p class="text-xs text-slate-300 mt-1">Automatice la incorporación de expedientes del personal del plantel.</p>
                    </div>
                    <a href="#formulario-anclaje" class="mt-4 w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-2.5 px-4 rounded-xl text-xs flex items-center justify-center space-x-2 transition-all shadow-sm text-center">
                      <i class="fa-solid fa-user-plus"></i>
                      <span>Ir al Formulario</span>
                    </a>
                  </div>

                  <div class="border border-dashed border-slate-300 p-5 rounded-2xl flex-1 flex flex-col justify-between">
                    <div>
                      <h3 class="font-bold text-slate-800 text-sm">Próximos Cumpleaños</h3>
                      <p class="text-xs text-slate-500 mt-0.5">Control de efemérides institucionales.</p>
                    </div>
                    <div class="text-xs text-slate-600 mt-2 space-y-1">
                      <div class="flex justify-between border-b border-slate-100 py-1">
                        <span>María Gómez (Docente)</span>
                        <span class="font-semibold text-teal-600">14 de Mayo</span>
                      </div>
                      <div class="flex justify-between py-1">
                        <span>Juana Marín (Operativo)</span>
                        <span className="font-semibold text-teal-600">08 de Junio</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- SECCIÓN INFERIOR: GESTIÓN DE EXPEDIENTES Y TABLA -->
              <hr class="border-slate-100 my-4" />

              <div id="formulario-anclaje" class="grid grid-cols-1 xl:grid-cols-12 gap-6 pt-2">
                  
                  <!-- FORMULARIO RE-ESTILIZADO -->
                  <div class="xl:col-span-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                      <div>
                          <h3 class="font-bold text-slate-900 text-base">Registrar Nuevo Personal</h3>
                          <p class="text-xs text-slate-400">Ingrese los datos para la base de datos MySQL.</p>
                      </div>

                      <form action="{{ route('empleados.store') }}" method="POST" class="space-y-3 text-xs">
                          @csrf
                          <div>
                              <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">Cédula de Identidad</label>
                              <input type="text" name="cedula" placeholder="V-00000000" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500/35 font-semibold" required>
                          </div>

                          <div class="grid grid-cols-2 gap-2">
                              <div>
                                  <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">Nombres</label>
                                  <input type="text" name="nombres" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none" required>
                              </div>
                              <div>
                                  <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">Apellidos</label>
                                  <input type="text" name="apellidos" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none" required>
                              </div>
                          </div>

                          <div class="grid grid-cols-2 gap-2">
                              <div>
                                  <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">Tipo de Personal</label>
                                  <select name="tipo_personal" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none">
                                      <option value="Docente">Docente</option>
                                      <option value="Administrativo">Administrativo</option>
                                      <option value="Operativo">Operativo</option>
                                  </select>
                              </div>
                              <div>
                                  <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">Estatus</label>
                                  <select name="estatus" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none">
                                      <option value="Activo">Activo</option>
                                      <option value="Inactivo">Inactivo</option>
                                      <option value="Comisión de Servicio">Comisión de Servicio</option>
                                  </select>
                              </div>
                          </div>

                          <div>
                              <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">Cargo / Función</label>
                              <input type="text" name="cargo" placeholder="Ej: Docente de 1er Nivel" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none" required>
                          </div>

                          <div class="grid grid-cols-2 gap-2">
                              <div>
                                  <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">F. Nacimiento</label>
                                  <input type="date" name="fecha_nacimiento" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none" required>
                              </div>
                              <div>
                                  <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">F. Ingreso</label>
                                  <input type="date" name="fecha_ingreso" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none" required>
                              </div>
                          </div>

                          <div class="grid grid-cols-2 gap-2">
                              <div>
                                  <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">Teléfono</label>
                                  <input type="text" name="telefono" placeholder="0414-0000000" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none" required>
                              </div>
                              <div>
                                  <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">Correo</label>
                                  <input type="email" name="correo" placeholder="nombre@gmail.com" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none">
                              </div>
                          </div>

                          <div>
                              <label class="block font-bold text-slate-500 uppercase mb-1 tracking-wider">Dirección de Habitación</label>
                              <textarea name="direccion" rows="2" placeholder="Comunidad de El Corozo, Maturín" class="w-full bg-slate-50/80 p-2.5 rounded-xl border border-slate-200 focus:outline-none resize-none" required></textarea>
                          </div>

                          <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition-colors mt-2 shadow-sm uppercase tracking-wider text-[11px]">
                              <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Guardar en Base de Datos
                          </button>
                      </form>
                  </div>

                  <!-- TABLA DE CONTROL ELEGANTE -->
                  <div id="registro-tabla" class="xl:col-span-8 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                      <div>
                          <h3 class="font-bold text-slate-900 text-base">Nómina Registrada del Plantel</h3>
                          <p class="text-xs text-slate-400">Control de registros persistidos de forma segura en MySQL.</p>
                      </div>

                      <div class="overflow-x-auto rounded-xl border border-slate-200">
                          <table class="min-w-full divide-y divide-slate-200 text-left text-xs">
                              <thead class="bg-slate-50 font-bold text-slate-500 uppercase tracking-wider text-[10px]">
                                  <tr>
                                      <th class="p-3.5">Cédula</th>
                                      <th class="p-3.5">Trabajador</th>
                                      <th class="p-3.5">Personal / Función</th>
                                      <th class="p-3.5 text-center">Estatus</th>
                                      <th class="p-3.5 text-right">Acción</th>
                                  </tr>
                              </thead>
                              <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                  @forelse($empleados as $emp)
                                      <tr class="hover:bg-slate-50/50 transition-colors">
                                          <td class="p-3.5 font-bold text-slate-900 whitespace-nowrap">{{ $emp->cedula }}</td>
                                          <td class="p-3.5 whitespace-nowrap">
                                              <div class="font-semibold text-slate-900">{{ $emp->apellidos }}, {{ $emp->nombres }}</div>
                                              <div class="text-[10px] text-slate-400 font-normal">{{ $emp->telefono }}</div>
                                          </td>
                                          <td class="p-3.5 whitespace-nowrap">
                                              <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase mr-1.5 {{
                                                  $emp->tipo_personal == 'Docente' ? 'bg-teal-100 text-teal-800' :
                                                  ($emp->tipo_personal == 'Administrativo' ? 'bg-sky-100 text-sky-800' : 'bg-amber-100 text-amber-800')
                                              }}">{{ $emp->tipo_personal }}</span>
                                              <span class="text-slate-600 text-[11px]">{{ $emp->cargo }}</span>
                                          </td>
                                          <td class="p-3.5 text-center whitespace-nowrap">
                                              <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide {{ $emp->estatus == 'Activo' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                                  {{ $emp->estatus }}
                                              </span>
                                          </td>
                                          <td class="p-3.5 text-right whitespace-nowrap">
                                              <form action="{{ route('empleados.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este expediente permanentemente de MySQL?')">
                                                  @csrf @method('DELETE')
                                                  <button type="submit" class="text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 p-1.5 rounded-lg transition-all font-bold text-[11px]">
                                                      <i class="fa-solid fa-trash-can"></i>
                                                  </button>
                                              </form>
                                          </td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colSpan="5" class="p-10 text-center text-slate-400 font-normal">
                                              <i class="fa-solid fa-folder-open text-2xl block mb-2 text-slate-300"></i>
                                              No hay ningún personal registrado en la base de datos todavía.
                                          </td>
                                      </tr>
                                  @endforelse
                              </tbody>
                          </table>
                      </div>
                      
                      <!-- Paginación de Laravel Estilizada -->
                      <div class="pt-2">
                          {{ $empleados->links() }}
                      </div>
                  </div>
              </div>

              <!-- Banner de Privacidad e Información del decreto -->
              <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 flex items-center space-x-4">
                <i class="fa-solid fa-shield-halved text-2xl text-teal-600 flex-shrink-0"></i>
                <div class="text-xs text-slate-500 leading-relaxed">
                  <h4 class="font-bold text-slate-800 text-sm mb-0.5">Garantía de Software Libre & Privacidad</h4>
                  Este sistema está concebido para operar localmente en cualquier servidor web GNU/Linux empleando Apache/Nginx, PHP (Laravel) y base de datos relacional MySQL / MariaDB, salvaguardando la confidencialidad de la información del personal del CEI Carmen Baute de El Corozo bajo las normativas nacionales de soberanía informática de Venezuela.
                </div>
              </div>

        </main>
    </div>

    <!-- FOOTER DEL SISTEMA -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 py-6 text-xs mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-center md:text-left space-y-0.5">
                <span class="font-bold text-slate-200 block">CEI Carmen Baute - El Corozo, Monagas</span>
                <span>Desarrollo bajo el Decreto Presidencial N° 3.390 (Uso de Tecnologías Libres en el Estado Venezolano).</span>
            </div>
            <div class="flex space-x-4 font-mono text-[11px]">
                <span>Laravel v11.x</span>
                <span>MySQL 8.x</span>
            </div>
        </div>
    </footer>

</body>
</html>
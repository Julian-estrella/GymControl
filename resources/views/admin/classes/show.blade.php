@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Clases' => route('admin.classes.index'), $class->name => '']" />
<div class="mb-6">
    <a href="{{ route('admin.classes.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold transition-colors duration-200">
        <i class="fa-solid fa-arrow-left mr-1"></i> Volver a Clases
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Card de Detalles de la Clase --}}
    <div class="lg:col-span-1 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 flex flex-col justify-between">
        <div>
            <div class="bg-gradient-to-r from-indigo-600 to-violet-700 px-6 py-8 text-white">
                <span class="bg-indigo-500/30 text-indigo-100 text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full backdrop-blur-sm">
                    Detalles de Clase
                </span>
                <h2 class="text-2xl font-black mt-3 tracking-tight">{{ $class->name }}</h2>
                <p class="text-indigo-200 text-sm mt-2 line-clamp-3">{{ $class->description ?? 'Sin descripción disponible.' }}</p>
            </div>

            <div class="p-6 space-y-6">
                {{-- Entrenador --}}
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                        <i class="fa-solid fa-user-tie text-lg"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Entrenador</span>
                        <span class="text-sm font-bold text-gray-800">{{ $class->trainer ? $class->trainer->name : 'Sin asignar' }}</span>
                    </div>
                </div>

                {{-- Capacidad --}}
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Capacidad y Ocupación</span>
                        <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full border border-indigo-100">
                            {{ $class->clients->count() }} / {{ $class->max_capacity }}
                        </span>
                    </div>
                    @php
                        $percent = $class->max_capacity > 0 ? min(100, ($class->clients->count() / $class->max_capacity) * 100) : 0;
                    @endphp
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden border border-gray-200">
                        <div class="bg-gradient-to-r from-indigo-600 to-violet-600 h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                    </div>
                </div>

                {{-- Horario Semanal --}}
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Horario Programado</span>
                    @if(!empty($class->schedule) && is_array($class->schedule))
                        <div class="space-y-2">
                            @foreach($class->schedule as $slot)
                                <div class="flex items-center justify-between px-3 py-2 bg-gray-50 rounded-xl border border-gray-200 text-xs">
                                    <span class="font-bold text-gray-700">{{ $slot['day'] }}</span>
                                    <span class="text-gray-500 font-semibold flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-indigo-500"></i>
                                        {{ $slot['start'] }} - {{ $slot['end'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-xs text-gray-400">No hay horarios programados</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6 border-t border-gray-100 bg-gray-50 flex gap-2">
            <a href="{{ route('admin.classes.edit', $class->id) }}" class="flex-1 text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold py-2.5 px-4 rounded-xl border border-indigo-100 transition-all duration-200">
                <i class="fa-solid fa-pen mr-1"></i> Editar Clase
            </a>
        </div>
    </div>

    {{-- Panel de Clientes e Inscripción --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Formulario para inscribir --}}
        @if($class->clients->count() < $class->max_capacity)
            <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-indigo-600"></i> Inscribir Cliente
                </h3>
                <form action="{{ route('admin.classes.enroll', $class->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="flex-1">
                        <select name="client_id" required class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">— Selecciona un cliente activo —</option>
                            @foreach($availableClients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email ?? 'Sin correo' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/20 text-sm">
                        <i class="fa-solid fa-check mr-2"></i> Inscribir
                    </button>
                </form>
            </div>
        @else
            <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl flex items-center gap-3 text-amber-700 text-sm font-semibold">
                <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                La clase ha alcanzado su cupo máximo. No es posible inscribir nuevos clientes por el momento.
            </div>
        @endif

        {{-- Tabla de Clientes Inscritos --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fa-solid fa-users mr-2 text-indigo-600"></i> Clientes Inscritos
                </h3>
                <span class="bg-indigo-100 text-indigo-800 text-xs font-extrabold px-3 py-1 rounded-full">
                    {{ $class->clients->count() }} inscritos
                </span>
            </div>

            <div class="divide-y divide-gray-100">
                @if($class->clients->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Contacto</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($class->clients as $client)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="h-9 w-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.clients.show', $client->id) }}" class="text-sm font-bold text-gray-800 hover:text-indigo-600 hover:underline">
                                                        {{ $client->name }}
                                                    </a>
                                                    <span class="block text-xs text-gray-400">Registrado el {{ $client->created_at->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="text-gray-700 font-semibold">{{ $client->email ?? 'No registrado' }}</div>
                                            <div class="text-xs text-gray-400">{{ $client->phone ?? 'Sin teléfono' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <form action="{{ route('admin.classes.unenroll', [$class->id, $client->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 p-2 rounded-xl border border-red-100 transition-all duration-200" title="Dar de baja de esta clase" onclick="return confirm('¿Estás seguro de que deseas dar de baja a este cliente de la clase?')">
                                                    <i class="fa-solid fa-user-minus"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-gray-400 py-12">
                        <i class="fa-solid fa-users text-4xl mb-3 text-gray-300 block"></i>
                        <p class="text-sm font-medium">No hay clientes inscritos en esta clase todavía.</p>
                        @if($class->clients->count() < $class->max_capacity)
                            <p class="text-xs text-gray-400 mt-1">Usa el formulario superior para inscribir al primer cliente.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

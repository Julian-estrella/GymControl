@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Entrenadores' => route('admin.trainers.index'), 'Detalles' => '']" />
<div class="mb-6">
    <a href="{{ route('admin.trainers.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
        <i class="fa-solid fa-arrow-left mr-1"></i> Volver a Entrenadores
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Perfil del entrenador --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="text-center mb-4">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-100 mb-3">
                <i class="fa-solid fa-person-running text-indigo-600 text-3xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">{{ $trainer->name }}</h2>
            @if($trainer->is_active)
                <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Activo</span>
            @else
                <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Inactivo</span>
            @endif
        </div>

        <div class="space-y-3 text-sm">
            <div class="flex items-center text-gray-600">
                <i class="fa-solid fa-envelope w-5 text-indigo-500 mr-2"></i>
                {{ $trainer->email }}
            </div>
            <div class="flex items-center text-gray-600">
                <i class="fa-solid fa-phone w-5 text-indigo-500 mr-2"></i>
                {{ $trainer->phone ?? 'No registrado' }}
            </div>
            <div class="flex items-center text-gray-600">
                <i class="fa-solid fa-star w-5 text-indigo-500 mr-2"></i>
                {{ $trainer->specialty ?? 'Sin especialidad' }}
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-2">
            <a href="{{ route('admin.trainers.edit', $trainer->id) }}"
                class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Editar
            </a>

            <form action="{{ route('admin.trainers.toggle', $trainer->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full {{ $trainer->is_active ? 'bg-yellow-400 hover:bg-yellow-500 text-yellow-900' : 'bg-green-500 hover:bg-green-600 text-white' }} font-bold py-2 px-4 rounded">
                    <i class="fa-solid {{ $trainer->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2"></i>
                    {{ $trainer->is_active ? 'Desactivar' : 'Activar' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Clases impartidas --}}
    <div class="lg:col-span-2 bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fa-solid fa-calendar-check text-indigo-500 mr-2"></i>
            Clases Impartidas ({{ $trainer->gymClasses->count() }})
        </h3>

        @if($trainer->gymClasses->isEmpty())
            <div class="text-center py-8 text-gray-400">
                <i class="fa-solid fa-calendar-xmark text-4xl mb-2"></i>
                <p>Este entrenador no tiene clases asignadas.</p>
                <a href="{{ route('admin.classes.create') }}" class="mt-3 inline-block text-indigo-600 hover:underline">
                    Crear nueva clase
                </a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($trainer->gymClasses as $class)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $class->name }}</p>
                        @if(is_array($class->schedule) && count($class->schedule))
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach($class->schedule as $slot)
                                <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded">
                                    {{ $slot['day'] }} {{ $slot['start'] }}–{{ $slot['end'] }}
                                </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-500"><i class="fa-solid fa-clock mr-1"></i>Sin horario</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-600">
                            <i class="fa-solid fa-users mr-1"></i>{{ $class->max_capacity }} cupos
                        </span>
                        @if($class->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Activa</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Inactiva</span>
                        @endif
                        <a href="{{ route('admin.classes.edit', $class->id) }}" class="text-blue-500 hover:text-blue-800">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

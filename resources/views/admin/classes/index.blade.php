@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Clases' => '']" />
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Gestión de Clases</h1>
    <a href="{{ route('admin.classes.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
        <i class="fa-solid fa-plus mr-2"></i> Nueva Clase
    </a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Clase
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Entrenador
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Horario
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Cupo Máx.
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Estado
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $class)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-900 font-semibold">{{ $class->name }}</p>
                    @if($class->description)
                        <p class="text-gray-500 text-xs mt-1 truncate max-w-xs">{{ $class->description }}</p>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    @if($class->trainer)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                                <i class="fa-solid fa-person-running text-indigo-600 text-xs"></i>
                            </div>
                            <a href="{{ route('admin.trainers.show', $class->trainer->id) }}" class="text-indigo-600 hover:underline font-medium">
                                {{ $class->trainer->name }}
                            </a>
                        </div>
                    @else
                        <span class="text-gray-400 italic">Sin asignar</span>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    @if(is_array($class->schedule) && count($class->schedule))
                        <div class="space-y-1">
                            @foreach($class->schedule as $slot)
                            <div class="flex items-center gap-2 text-xs">
                                <span class="inline-block w-20 font-semibold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">
                                    {{ $slot['day'] }}
                                </span>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-clock text-gray-300 mr-1"></i>
                                    {{ $slot['start'] }} – {{ $slot['end'] }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-gray-400 italic text-xs">Sin horario</span>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold">
                        {{ $class->max_capacity }}
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                    @if($class->is_active)
                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                            <span class="relative">Activa</span>
                        </span>
                    @else
                        <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                            <span class="relative">Inactiva</span>
                        </span>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                    <a href="{{ route('admin.classes.show', $class->id) }}" class="text-indigo-600 hover:text-indigo-950 mr-3 text-base" title="Inscribir / Ver Alumnos">
                        <i class="fa-solid fa-users text-lg"></i>
                    </a>
                    <a href="{{ route('admin.classes.edit', $class->id) }}" class="text-blue-500 hover:text-blue-800 mr-3 text-base" title="Editar">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="text-red-500 hover:text-red-800 btn-delete text-base" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($classes->isEmpty())
            <tr>
                <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                    No hay clases registradas.
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('form');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "La clase será eliminada.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection

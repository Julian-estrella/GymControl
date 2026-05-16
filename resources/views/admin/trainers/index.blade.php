@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Entrenadores' => '']" />
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Gestión de Entrenadores</h1>
    <a href="{{ route('admin.trainers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
        <i class="fa-solid fa-plus mr-2"></i> Nuevo Entrenador
    </a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Nombre
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Contacto
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Especialidad
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Clases
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
            @foreach($trainers as $trainer)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $trainer->name }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ $trainer->email }}</p>
                    <p class="text-gray-500 whitespace-no-wrap">{{ $trainer->phone ?? 'N/A' }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-700">{{ $trainer->specialty ?? '—' }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold text-sm">
                        {{ $trainer->gym_classes_count }}
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                    @if($trainer->is_active)
                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                            <span class="relative">Activo</span>
                        </span>
                    @else
                        <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                            <span class="relative">Inactivo</span>
                        </span>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                    <a href="{{ route('admin.trainers.show', $trainer->id) }}" class="text-green-500 hover:text-green-800 mr-3" title="Ver perfil">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="text-blue-500 hover:text-blue-800 mr-3" title="Editar">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <form action="{{ route('admin.trainers.toggle', $trainer->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="{{ $trainer->is_active ? 'text-yellow-500 hover:text-yellow-800' : 'text-green-500 hover:text-green-800' }} mr-3"
                            title="{{ $trainer->is_active ? 'Desactivar' : 'Activar' }}">
                            <i class="fa-solid {{ $trainer->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                        </button>
                    </form>

                    <form action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="text-red-500 hover:text-red-800 btn-delete" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($trainers->isEmpty())
            <tr>
                <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                    No hay entrenadores registrados.
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
                    text: "El entrenador será eliminado.",
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
                })
            });
        });
    });
</script>
@endsection

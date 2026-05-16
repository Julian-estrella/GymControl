@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Planes de Membresía' => '']" />
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Planes de Membresía</h1>
    <a href="{{ route('admin.membership-plans.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
        <i class="fa-solid fa-plus mr-2"></i> Nuevo Plan
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($plans as $plan)
    <div class="bg-white rounded-lg shadow-md overflow-hidden border {{ $plan->is_active ? 'border-indigo-200' : 'border-gray-200 opacity-75' }}">
        <div class="p-5">
            <div class="flex justify-between items-start mb-3">
                <h2 class="text-lg font-bold text-gray-800">{{ $plan->name }}</h2>
                @if($plan->is_active)
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Activo</span>
                @else
                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Inactivo</span>
                @endif
            </div>

            @if($plan->description)
            <p class="text-gray-500 text-sm mb-4">{{ $plan->description }}</p>
            @endif

            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-3xl font-bold text-indigo-600">${{ number_format($plan->price, 2) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Duración</p>
                    <p class="font-semibold text-gray-700">{{ $plan->duration_days }} días</p>
                </div>
            </div>

            <div class="flex items-center text-xs text-gray-500 mb-4">
                <i class="fa-solid fa-users mr-1"></i>
                {{ $plan->client_memberships_count }} membresía(s) asignada(s)
            </div>

            <div class="flex gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('admin.membership-plans.edit', $plan->id) }}"
                    class="flex-1 text-center bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-2 rounded text-sm">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Editar
                </a>

                <form action="{{ route('admin.membership-plans.toggle', $plan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="px-3 py-2 {{ $plan->is_active ? 'bg-yellow-50 hover:bg-yellow-100 text-yellow-700' : 'bg-green-50 hover:bg-green-100 text-green-700' }} rounded text-sm font-semibold"
                        title="{{ $plan->is_active ? 'Desactivar' : 'Activar' }}">
                        <i class="fa-solid {{ $plan->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                    </button>
                </form>

                <form action="{{ route('admin.membership-plans.destroy', $plan->id) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded text-sm font-semibold btn-delete"
                        title="Eliminar">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @if($plans->isEmpty())
    <div class="col-span-3 text-center py-12 text-gray-400">
        <i class="fa-solid fa-credit-card text-5xl mb-3"></i>
        <p class="text-lg">No hay planes de membresía registrados.</p>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('form');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "El plan de membresía será eliminado.",
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

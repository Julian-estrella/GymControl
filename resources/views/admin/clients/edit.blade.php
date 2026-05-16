@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Clientes' => route('admin.clients.index'), 'Editar' => '']" />
<div class="mb-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Editar Cliente: {{ $client->name }}</h1>
        <a href="{{ route('admin.clients.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver a la lista
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl">
    <form action="{{ route('admin.clients.update', $client->id) }}" method="POST" class="p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Teléfono -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Vincular Usuario -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Vincular con Usuario del Sistema</label>
                <select name="user_id" id="user_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Ninguno</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $client->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Estado de Membresía -->
            <div>
                <label for="membership_status" class="block text-sm font-medium text-gray-700">Estado de Membresía *</label>
                <select name="membership_status" id="membership_status" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="sin_membresia" {{ old('membership_status', $client->membership_status) == 'sin_membresia' ? 'selected' : '' }}>Sin Membresía</option>
                    <option value="activo" {{ old('membership_status', $client->membership_status) == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="vencido" {{ old('membership_status', $client->membership_status) == 'vencido' ? 'selected' : '' }}>Vencido</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Si cambia el estado, se registrará en el historial de pagos.</p>
            </div>

            <!-- Observaciones (Historial) -->
            <div>
                <label for="observations" class="block text-sm font-medium text-gray-700">Observaciones del cambio de estado</label>
                <input type="text" name="observations" id="observations" value="{{ old('observations') }}" placeholder="Ej. Pago por 1 mes, Cancelado a petición, etc."
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow">
                <i class="fa-solid fa-save mr-2"></i> Actualizar Cliente
            </button>
        </div>
    </form>
</div>
@endsection

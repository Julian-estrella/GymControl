@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Usuarios' => route('admin.users.index'), 'Registrar' => '']" />
<div class="mb-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Crear Nuevo Usuario</h1>
        <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver a la lista
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl">
    <form action="{{ route('admin.users.store') }}" method="POST" class="p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono (Opcional)</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rol -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rol del Sistema</label>
                <select name="role" id="role" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('role') border-red-500 @enderror">
                    <option value="" disabled selected>Seleccione un rol</option>
                    @foreach($roles as $value => $label)
                        <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow">
                <i class="fa-solid fa-save mr-2"></i> Guardar Usuario
            </button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Entrenadores' => route('admin.trainers.index'), 'Editar' => '']" />
<div class="mb-6">
    <a href="{{ route('admin.trainers.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
        <i class="fa-solid fa-arrow-left mr-1"></i> Volver a Entrenadores
    </a>
</div>

<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Entrenador</h1>

    <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $trainer->name) }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email', $trainer->email) }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $trainer->phone) }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4">
            <label for="specialty" class="block text-sm font-medium text-gray-700 mb-1">Especialidad</label>
            <input type="text" id="specialty" name="specialty" value="{{ old('specialty', $trainer->specialty) }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $trainer->is_active) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-700">Entrenador activo</span>
            </label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.trainers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                Cancelar
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa-solid fa-save mr-2"></i> Actualizar
            </button>
        </div>
    </form>
</div>
@endsection

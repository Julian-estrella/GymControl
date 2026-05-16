@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Planes de Membresía' => route('admin.membership-plans.index'), 'Editar' => '']" />
<div class="mb-6">
    <a href="{{ route('admin.membership-plans.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
        <i class="fa-solid fa-arrow-left mr-1"></i> Volver a Planes
    </a>
</div>

<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Plan de Membresía</h1>

    <form action="{{ route('admin.membership-plans.update', $membershipPlan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Plan <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $membershipPlan->name) }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea id="description" name="description" rows="3"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $membershipPlan->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-1">Duración (días) <span class="text-red-500">*</span></label>
                <input type="number" id="duration_days" name="duration_days" value="{{ old('duration_days', $membershipPlan->duration_days) }}" min="1"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('duration_days') border-red-500 @enderror">
                @error('duration_days') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Precio ($) <span class="text-red-500">*</span></label>
                <input type="number" id="price" name="price" value="{{ old('price', $membershipPlan->price) }}" min="0" step="0.01"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror">
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $membershipPlan->is_active) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-700">Plan activo</span>
            </label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.membership-plans.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                Cancelar
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa-solid fa-save mr-2"></i> Actualizar
            </button>
        </div>
    </form>
</div>
@endsection

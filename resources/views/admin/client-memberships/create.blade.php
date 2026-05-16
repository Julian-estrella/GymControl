@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Clientes' => route('admin.clients.index'), 'Asignar Membresía' => '']" />
<div class="mb-6">
    <a href="{{ route('admin.clients.show', $client->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
        <i class="fa-solid fa-arrow-left mr-1"></i> Volver al perfil de {{ $client->name }}
    </a>
</div>

<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Asignar Membresía</h1>
    <p class="text-gray-500 text-sm mb-6">Cliente: <span class="font-semibold text-gray-700">{{ $client->name }}</span></p>

    <form action="{{ route('admin.client-memberships.store', $client->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="membership_plan_id" class="block text-sm font-medium text-gray-700 mb-1">Plan de Membresía <span class="text-red-500">*</span></label>
            <select id="membership_plan_id" name="membership_plan_id"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('membership_plan_id') border-red-500 @enderror"
                onchange="calcularFechaFin(this)">
                <option value="">— Seleccionar plan —</option>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" data-days="{{ $plan->duration_days }}"
                        {{ old('membership_plan_id') == $plan->id ? 'selected' : '' }}>
                        {{ $plan->name }} — ${{ number_format($plan->price, 2) }} ({{ $plan->duration_days }} días)
                    </option>
                @endforeach
            </select>
            @error('membership_plan_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio <span class="text-red-500">*</span></label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('start_date') border-red-500 @enderror"
                    onchange="calcularFechaFin()">
                @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento <span class="text-red-500">*</span></label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('end_date') border-red-500 @enderror">
                @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notas (opcional)</label>
            <textarea id="notes" name="notes" rows="2"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Observaciones sobre esta membresía...">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.clients.show', $client->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                Cancelar
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa-solid fa-check mr-2"></i> Asignar Membresía
            </button>
        </div>
    </form>
</div>

<script>
function calcularFechaFin() {
    const planSelect = document.getElementById('membership_plan_id');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    const selectedOption = planSelect.options[planSelect.selectedIndex];
    const days = parseInt(selectedOption.dataset.days);
    const startDate = new Date(startDateInput.value);

    if (!isNaN(days) && !isNaN(startDate.getTime())) {
        const endDate = new Date(startDate);
        endDate.setDate(endDate.getDate() + days - 1);
        endDateInput.value = endDate.toISOString().split('T')[0];
    }
}

// Run on page load if values are pre-selected
document.addEventListener('DOMContentLoaded', function() {
    const plan = document.getElementById('membership_plan_id');
    if (plan.value && !document.getElementById('end_date').value) {
        calcularFechaFin();
    }
});
</script>
@endsection

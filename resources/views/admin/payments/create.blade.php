@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Pagos' => route('admin.payments.index'), 'Registrar' => '']" />
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-800">Registrar Pago</h1>
    <a href="{{ route('admin.payments.index') }}" class="text-indigo-600 hover:text-indigo-800">
        <i class="fa-solid fa-arrow-left mr-1"></i> Volver al historial
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-3xl mx-auto">
    <form action="{{ route('admin.payments.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Cliente <span class="text-red-500">*</span></label>
            <select name="client_id" id="client_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Seleccione un cliente</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ (old('client_id') ?? optional($selectedClient)->id) == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
            @error('client_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="membership_plan_id" class="block text-sm font-medium text-gray-700 mb-1">Plan de Membresía <span class="text-red-500">*</span></label>
            <select name="membership_plan_id" id="membership_plan_id" required onchange="updateAmount()" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="" data-price="0">Seleccione un plan</option>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" data-price="{{ $plan->price }}" {{ old('membership_plan_id') == $plan->id ? 'selected' : '' }}>
                        {{ $plan->name }} - ${{ number_format($plan->price, 2) }}
                    </option>
                @endforeach
            </select>
            @error('membership_plan_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Monto a Pagar <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required class="pl-7 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Método de Pago <span class="text-red-500">*</span></label>
                <select name="payment_method" id="payment_method" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Efectivo</option>
                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transferencia</option>
                    <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('payment_method') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado del Pago <span class="text-red-500">*</span></label>
            <select name="status" id="status" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Pagado</option>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
            </select>
            @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notas u Observaciones</label>
            <textarea name="notes" id="notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('notes') }}</textarea>
            @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.payments.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded shadow">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fa-solid fa-save mr-2"></i> Guardar Pago
            </button>
        </div>
    </form>
</div>

<script>
function updateAmount() {
    const planSelect = document.getElementById('membership_plan_id');
    const selectedOption = planSelect.options[planSelect.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    const amountInput = document.getElementById('amount');
    
    if (price && !amountInput.value) {
        amountInput.value = price;
    } else if (price && amountInput.value) {
        // Only update if user hasn't typed a custom amount manually or we want to overwrite
        amountInput.value = price;
    }
}
</script>
@endsection

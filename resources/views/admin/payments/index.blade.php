@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Pagos' => '']" />
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-800">Gestión de Pagos</h1>
    <a href="{{ route('admin.payments.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
        <i class="fa-solid fa-plus mr-2"></i> Registrar Pago
    </a>
</div>

<!-- Filtros -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form action="{{ route('admin.payments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
            <select name="client_id" id="client_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Todos los clientes</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded shadow flex-1">
                <i class="fa-solid fa-filter mr-1"></i> Filtrar
            </button>
            <a href="{{ route('admin.payments.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-3 rounded shadow" title="Limpiar filtros">
                <i class="fa-solid fa-xmark"></i>
            </a>
        </div>
    </form>
</div>

<!-- Tabla de Pagos -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folio / Fecha</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto / Método</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900">{{ $payment->folio }}</div>
                        <div class="text-xs text-gray-500">{{ $payment->created_at->format('d/m/Y H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.clients.show', $payment->client_id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                            {{ $payment->client->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $payment->membershipPlan->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-green-600">${{ number_format($payment->amount, 2) }}</div>
                        <div class="text-xs text-gray-500">
                            @switch($payment->payment_method)
                                @case('cash') Efectivo @break
                                @case('card') Tarjeta @break
                                @case('transfer') Transferencia @break
                                @default Otro
                            @endswitch
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($payment->status === 'paid')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Pagado</span>
                        @elseif($payment->status === 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelado</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Ver detalle">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.payments.pdf', $payment->id) }}" class="text-gray-600 hover:text-gray-900 mr-3" title="Descargar PDF">
                            <i class="fa-solid fa-file-pdf"></i>
                        </a>
                        @if($payment->status !== 'cancelled')
                        <form action="{{ route('admin.payments.cancel', $payment->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Cancelar pago" onclick="return confirm('¿Estás seguro de cancelar este pago?');">
                                <i class="fa-solid fa-ban"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                        No se encontraron pagos con los filtros actuales.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="px-6 py-3 border-t border-gray-200">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection

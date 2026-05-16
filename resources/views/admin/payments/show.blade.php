@extends('layouts.admin')

@section('content')
<x-breadcrumb :links="['Pagos' => route('admin.payments.index'), 'Detalles' => '']" />
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Detalle del Pago</h1>
        @if($payment->status === 'paid')
            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Pagado</span>
        @elseif($payment->status === 'pending')
            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
        @else
            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelado</span>
        @endif
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.payments.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded shadow">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver
        </a>
        <a href="{{ route('admin.payments.pdf', $payment->id) }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
            <i class="fa-solid fa-file-pdf mr-1"></i> Descargar PDF
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto">
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información del Pago -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-receipt mr-2 text-indigo-600"></i> Datos del Pago</h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Folio</span>
                        <span class="text-base text-gray-900 font-mono font-bold">{{ $payment->folio }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Fecha de Emisión</span>
                        <span class="text-sm text-gray-900">{{ $payment->created_at->format('d/m/Y h:i A') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Monto</span>
                        <span class="text-xl font-bold text-green-600">${{ number_format($payment->amount, 2) }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Método de Pago</span>
                        <span class="text-sm text-gray-900">
                            @switch($payment->payment_method)
                                @case('cash') Efectivo @break
                                @case('card') Tarjeta @break
                                @case('transfer') Transferencia @break
                                @default Otro
                            @endswitch
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Registrado por</span>
                        <span class="text-sm text-gray-900">{{ $payment->registeredBy->name ?? 'Sistema' }}</span>
                    </div>
                </div>
            </div>

            <!-- Información del Cliente y Plan -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-user mr-2 text-indigo-600"></i> Datos del Cliente</h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Cliente</span>
                        <a href="{{ route('admin.clients.show', $payment->client_id) }}" class="text-indigo-600 hover:underline text-base font-semibold">
                            {{ $payment->client->name }}
                        </a>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Email</span>
                        <span class="text-sm text-gray-900">{{ $payment->client->email ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase">Plan de Membresía Pagado</span>
                        <span class="text-sm text-gray-900 font-medium">{{ $payment->membershipPlan->name }}</span>
                    </div>
                    
                    @if($payment->clientMembership)
                    <div class="bg-gray-50 p-3 rounded border border-gray-200 mt-2">
                        <span class="block text-xs font-semibold text-gray-500 uppercase mb-1">Período de la Membresía</span>
                        <div class="text-sm text-gray-800 flex items-center">
                            <i class="fa-solid fa-calendar mr-2 text-gray-400"></i>
                            {{ $payment->clientMembership->start_date->format('d/m/Y') }} 
                            <span class="mx-2">→</span> 
                            {{ $payment->clientMembership->end_date->format('d/m/Y') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($payment->notes)
        <div class="mt-6 border-t pt-4">
            <h3 class="text-sm font-bold text-gray-800 mb-2">Notas u Observaciones</h3>
            <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">{{ $payment->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection

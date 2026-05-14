@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Perfil del Cliente</h1>
        <a href="{{ route('admin.clients.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fa-solid fa-arrow-left mr-1"></i> Volver a la lista
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Información del Cliente -->
    <div class="bg-white rounded-lg shadow p-6 col-span-1">
        <div class="text-center mb-6">
            <div class="h-24 w-24 rounded-full bg-indigo-100 text-indigo-500 mx-auto flex items-center justify-center text-4xl mb-4">
                <i class="fa-solid fa-user"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">{{ $client->name }}</h2>
            <p class="text-gray-500 text-sm mt-1">
                @if($client->membership_status == 'activo')
                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Membresía Activa</span>
                @elseif($client->membership_status == 'vencido')
                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Membresía Vencida</span>
                @else
                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">Sin Membresía</span>
                @endif
            </p>
        </div>

        <div class="border-t border-gray-200 pt-4 space-y-3">
            <div>
                <span class="block text-xs font-semibold text-gray-500 uppercase">Correo Electrónico</span>
                <span class="text-sm text-gray-800">{{ $client->email ?? 'No registrado' }}</span>
            </div>
            <div>
                <span class="block text-xs font-semibold text-gray-500 uppercase">Teléfono</span>
                <span class="text-sm text-gray-800">{{ $client->phone ?? 'No registrado' }}</span>
            </div>
            <div>
                <span class="block text-xs font-semibold text-gray-500 uppercase">Usuario de Sistema</span>
                @if($client->user)
                    <span class="text-sm text-indigo-600 font-medium">{{ $client->user->name }}</span>
                @else
                    <span class="text-sm text-gray-500">No vinculado</span>
                @endif
            </div>
            <div>
                <span class="block text-xs font-semibold text-gray-500 uppercase">Fecha de Registro</span>
                <span class="text-sm text-gray-800">{{ $client->created_at->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('admin.clients.edit', $client->id) }}" class="inline-block w-full text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold py-2 px-4 border border-indigo-200 rounded shadow-sm">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Editar Perfil
            </a>
        </div>
    </div>

    <!-- Historial de Pagos / Membresía -->
    <div class="bg-white rounded-lg shadow col-span-1 md:col-span-2 overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fa-solid fa-clock-rotate-left mr-2 text-indigo-600"></i> Historial de Membresía / Pagos
            </h3>
        </div>
        
        <div class="p-6 flex-1 overflow-y-auto">
            @if($client->membershipHistories->count() > 0)
                <div class="relative border-l border-gray-200 ml-3 space-y-6">
                    @foreach($client->membershipHistories->sortByDesc('created_at') as $history)
                        <div class="mb-6 ml-6">
                            <!-- Icono status -->
                            <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -left-3 ring-4 ring-white
                                {{ $history->status == 'activo' ? 'bg-green-100 text-green-600' : ($history->status == 'vencido' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600') }}">
                                @if($history->status == 'activo')
                                    <i class="fa-solid fa-check text-xs"></i>
                                @elseif($history->status == 'vencido' || $history->status == 'cancelada')
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                @else
                                    <i class="fa-solid fa-minus text-xs"></i>
                                @endif
                            </span>
                            
                            <h4 class="flex items-center mb-1 text-sm font-semibold text-gray-900">
                                Estado: {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                            </h4>
                            <time class="block mb-2 text-xs font-normal leading-none text-gray-400">
                                {{ $history->created_at->format('d M Y, h:i A') }}
                            </time>
                            <p class="mb-4 text-sm font-normal text-gray-600">
                                {{ $history->observations ?? 'Sin observaciones' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-8">
                    <i class="fa-solid fa-inbox text-4xl mb-3 text-gray-300"></i>
                    <p>No hay registros en el historial de este cliente.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

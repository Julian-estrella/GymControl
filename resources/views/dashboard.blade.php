<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Espacio Gym') }} — GymControl
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Profile Card --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl flex flex-col md:flex-row">
                <div class="bg-indigo-600 p-8 text-white flex flex-col items-center justify-center md:w-1/3">
                    <img class="h-24 w-24 rounded-full object-cover border-4 border-indigo-400 mb-4" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                    <h3 class="text-xl font-bold">{{ auth()->user()->name }}</h3>
                    <p class="text-indigo-200 text-sm">Miembro desde {{ auth()->user()->created_at->format('M Y') }}</p>
                </div>
                <div class="p-8 md:w-2/3">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Estado de mi membresía</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Plan Actual</p>
                            <p class="text-lg font-bold text-indigo-700">Premium Mensual</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Vencimiento</p>
                            <p class="text-lg font-bold text-red-600">30 Jun 2026</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Info Tabs/Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Payment History Placeholder --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Historial de Pagos</h3>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-600">Mayo 2026</span>
                            <span class="text-sm font-bold text-green-600">$50.00</span>
                        </div>
                        <p class="text-xs text-center text-indigo-600 font-medium hover:underline cursor-pointer">Ver todos mis recibos</p>
                    </div>
                </div>

                {{-- Classes Placeholder --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Clases Disponibles</h3>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-indigo-50 rounded-lg border border-indigo-100">
                            <div class="bg-indigo-600 text-white text-[10px] font-bold px-2 py-1 rounded">HOY</div>
                            <span class="text-sm font-medium text-indigo-900">Crossfit — 18:00 hrs</span>
                        </div>
                        <p class="text-xs text-center text-indigo-600 font-medium hover:underline cursor-pointer">Explorar calendario completo</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

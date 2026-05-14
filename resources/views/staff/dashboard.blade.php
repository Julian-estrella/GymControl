<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel Operativo (Staff) — GymControl
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 uppercase tracking-wide">
                Staff
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Banner Staff --}}
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl shadow-lg p-8 text-white">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 rounded-full p-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">¡Hola, {{ auth()->user()->name }}! 👋</h1>
                        <p class="text-blue-100 mt-1">Gestión operativa del gimnasio activa.</p>
                    </div>
                </div>
            </div>

            {{-- Operational Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-blue-500">
                    <p class="text-sm font-medium text-gray-500">Clientes registrados</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'cliente')->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-orange-500">
                    <p class="text-sm font-medium text-gray-500">Membresías por vencer</p>
                    <p class="text-3xl font-bold text-gray-800">0</p>
                </div>
                <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500">Pagos hoy</p>
                    <p class="text-3xl font-bold text-gray-800">$0.00</p>
                </div>
            </div>

            {{-- Staff Actions --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Acciones de Operación</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <button class="flex flex-col items-center justify-center p-6 rounded-xl bg-gray-50 border border-gray-200 hover:bg-blue-50 hover:border-blue-300 transition-all group">
                        <svg class="w-8 h-8 text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Nuevo Cliente</span>
                    </button>

                    <button class="flex flex-col items-center justify-center p-6 rounded-xl bg-gray-50 border border-gray-200 hover:bg-green-50 hover:border-green-300 transition-all group">
                        <svg class="w-8 h-8 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Registrar Pago</span>
                    </button>

                    <button class="flex flex-col items-center justify-center p-6 rounded-xl bg-gray-50 border border-gray-200 hover:bg-purple-50 hover:border-purple-300 transition-all group">
                        <svg class="w-8 h-8 text-purple-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Gestionar Clases</span>
                    </button>

                    <button class="flex flex-col items-center justify-center p-6 rounded-xl bg-gray-50 border border-gray-200 hover:bg-orange-50 hover:border-orange-300 transition-all group">
                        <svg class="w-8 h-8 text-orange-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Reporte Diario</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel de Administración — GymControl
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 uppercase tracking-wide">
                Admin
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Banner Admin --}}
            <div class="bg-gradient-to-r from-gray-900 to-gray-700 rounded-2xl shadow-xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                <div class="relative flex items-center gap-4">
                    <div class="bg-white/10 rounded-full p-4 border border-white/20">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Hola, {{ auth()->user()->name }} 🏋️</h1>
                        <p class="text-gray-300 mt-1">Administrador del sistema · GymControl</p>
                    </div>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-medium text-gray-500">Total Miembros</p>
                        <div class="bg-indigo-100 rounded-lg p-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'member')->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Miembros registrados</p>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-medium text-gray-500">Administradores</p>
                        <div class="bg-red-100 rounded-lg p-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Cuentas de administrador</p>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-medium text-gray-500">Usuarios Totales</p>
                        <div class="bg-green-100 rounded-lg p-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Cuentas en el sistema</p>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-medium text-gray-500">Nuevos (hoy)</p>
                        <div class="bg-yellow-100 rounded-lg p-2">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::whereDate('created_at', today())->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Registros de hoy</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Acciones rápidas</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="{{ route('profile') }}"
                       class="flex items-center gap-3 p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-indigo-400 hover:bg-indigo-50 transition-all group">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-600 group-hover:text-indigo-700">Mi Perfil</span>
                    </a>
                    <div class="flex items-center gap-3 p-4 rounded-xl border-2 border-dashed border-gray-200 text-gray-400 cursor-not-allowed">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm font-medium">Gestión de Miembros <span class="text-xs">(próximamente)</span></span>
                    </div>
                    <div class="flex items-center gap-3 p-4 rounded-xl border-2 border-dashed border-gray-200 text-gray-400 cursor-not-allowed">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-sm font-medium">Reportes <span class="text-xs">(próximamente)</span></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

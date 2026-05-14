<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — GymControl
|--------------------------------------------------------------------------
*/

// Root: redirect to appropriate dashboard if authenticated, else show welcome
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->dashboardRoute());
    }
    return view('welcome');
});

// ─── Protected Routes ────────────────────────────────────────────────────────
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard Router: redirects to correct dashboard based on role
    Route::get('dashboard', function () {
        return redirect()->route(auth()->user()->dashboardRoute());
    })->name('dashboard');

    // 1. Admin Dashboard
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::view('dashboard', 'admin.dashboard')->name('dashboard');
    });

    // 2. Staff Dashboard
    Route::middleware(['role:staff,admin'])->prefix('staff')->name('staff.')->group(function () {
        Route::view('dashboard', 'staff.dashboard')->name('dashboard');
    });

    // 3. Cliente Dashboard
    Route::middleware(['role:cliente,staff,admin'])->group(function () {
        Route::view('mi-gym', 'dashboard')->name('cliente.dashboard');
    });

    // Profile
    Route::get('profile', function () {
        return redirect()->route('profile.show');
    })->name('profile');
});



<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes — GymControl
|--------------------------------------------------------------------------
*/

// Root: show welcome page
Route::get('/', function () {
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

    // 1. Admin Dashboard (Also accessible by staff as per User model `dashboardRoute`)
    Route::middleware(['role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Clients Management (Accessible by both Admin and Staff)
        Route::resource('clients', ClientController::class);
    });

    // 2. Admin Only Routes (Users Management)
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
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

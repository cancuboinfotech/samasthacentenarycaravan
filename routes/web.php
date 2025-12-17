<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CaravanController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [MapController::class, 'index'])->name('map.index');
Route::get('/map', [MapController::class, 'index'])->name('map.index');
Route::get('/map/{caravan}', [MapController::class, 'show'])->name('map.show');

Route::get('/caravans', [CaravanController::class, 'index'])->name('caravans.index');
Route::get('/caravans/{caravan}', [CaravanController::class, 'show'])->name('caravans.show');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('destinations', DestinationController::class);
    Route::get('/destinations/import', [\App\Http\Controllers\Admin\DestinationImportController::class, 'showImportForm'])->name('destinations.import');
    Route::post('/destinations/import', [\App\Http\Controllers\Admin\DestinationImportController::class, 'import'])->name('destinations.import.store');
});


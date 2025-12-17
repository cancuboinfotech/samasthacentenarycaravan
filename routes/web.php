<?php

use App\Http\Controllers\CaravanController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MapController::class, 'index'])->name('map.index');
Route::get('/map', [MapController::class, 'index'])->name('map.index');
Route::get('/map/{caravan}', [MapController::class, 'show'])->name('map.show');

Route::get('/caravans', [CaravanController::class, 'index'])->name('caravans.index');
Route::get('/caravans/{caravan}', [CaravanController::class, 'show'])->name('caravans.show');


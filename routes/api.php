<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RouteController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('/locations', [LocationController::class, 'getAll'])->name('api.locations.all');
    Route::get('/caravans/{caravan}/location', [LocationController::class, 'getLatest'])->name('api.caravan.location');
    Route::get('/caravans/{caravan}/history', [LocationController::class, 'getHistory'])->name('api.caravan.history');
    Route::post('/caravans/{caravan}/location', [LocationController::class, 'update'])->name('api.caravan.location.update');
    
    // Route information endpoints
    Route::get('/caravans/{caravan}/routes', [RouteController::class, 'getCaravanToDestinations'])->name('api.caravan.routes');
    Route::get('/route', [RouteController::class, 'getRouteBetweenPoints'])->name('api.route');
});


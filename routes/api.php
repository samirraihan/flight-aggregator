<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FlightController;
use Illuminate\Support\Facades\Route;

Route::prefix('flights')->group(function () {
    Route::post('/search', FlightController::class);
});

Route::prefix('bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store']);
    Route::get('/{reference}', [BookingController::class, 'show']);
});
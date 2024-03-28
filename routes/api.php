<?php

use App\Http\Controllers\DutyRoster\Api\GetEventController;
use App\Http\Controllers\DutyRoster\Api\StoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('duty-rosters')->group(function () {
    Route::post('/store', StoreController::class);

    Route::get('/event', GetEventController::class);
});



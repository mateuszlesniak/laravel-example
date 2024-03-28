<?php

use App\Http\Controllers\DutyRoster\Api\GetEventController;
use App\Http\Controllers\DutyRoster\Api\GetScheduleController;
use App\Http\Controllers\DutyRoster\Api\PostStoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('duty-rosters')->group(function () {
    Route::post('/store', PostStoreController::class);

    Route::prefix('event')->group(function () {
        Route::get('/', GetEventController::class);
        Route::get('/location/{locationCode}', GetEventController::class);
    });

    Route::prefix('schedule')->group(function () {
        Route::get('/', GetScheduleController::class);
        Route::get('/{activityCode?}', GetScheduleController::class);
    });
});



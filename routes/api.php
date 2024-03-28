<?php

use App\Http\Controllers\DutyRoster\Api\GetEventController;
use App\Http\Controllers\DutyRoster\Api\GetScheduleController;
use App\Http\Controllers\DutyRoster\Api\PostStoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('duty-rosters')->group(function () {
    Route::post('/store', PostStoreController::class);

    Route::get('/event/{locationCode?}', GetEventController::class);
    Route::get('/schedule/{activityCode?}', GetScheduleController::class);
});



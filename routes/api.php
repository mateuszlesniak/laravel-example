<?php

use App\Http\Controllers\DutyRoster\Api\StoreController;
use Illuminate\Support\Facades\Route;

Route::post('/duty-rosters/store', StoreController::class);

<?php

use App\Http\Controllers\Api\BoardIndexController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('board', BoardIndexController::class);
});

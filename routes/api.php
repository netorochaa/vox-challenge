<?php

use App\Http\Controllers\Api\BoardIndexController;
use App\Http\Controllers\Api\CategoryIndexController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('board', BoardIndexController::class);
    Route::get('category', CategoryIndexController::class)->name('category.index');
});

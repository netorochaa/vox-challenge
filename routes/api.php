<?php

use App\Http\Controllers\Api\BoardIndexController;
use App\Http\Controllers\Api\CategoryIndexController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('board', BoardIndexController::class);
    Route::get('category', CategoryIndexController::class)->name('category.index');
    Route::get('category/{categoryId}/task', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('task', [TaskController::class, 'store'])->name('tasks.store');
});

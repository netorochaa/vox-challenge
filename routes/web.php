<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::view('home', 'home')->name('home');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::prefix('board')->group(function () {
        Route::get('create', [BoardController::class, 'create'])->name('board.create');
        Route::post('store', [BoardController::class, 'store'])->name('board.store');
        Route::get('{id}/edit', [BoardController::class, 'edit'])->name('board.edit');
        Route::put('{id}', [BoardController::class, 'update'])->name('board.update');
        Route::get('{id}', [BoardController::class, 'show'])->name('board.view');
        Route::delete('{id}/delete', [BoardController::class, 'delete'])->name('board.delete');

        Route::get('{boardId}/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    });
});

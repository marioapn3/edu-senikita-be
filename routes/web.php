<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Web\AuthenticationController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;


Route::get('/', function () {
    return redirect()->route('login');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    });

    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
});



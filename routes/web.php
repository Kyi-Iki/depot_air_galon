<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Redirect root to dashboard
    Route::get('/', fn() => redirect()->route('dashboard'));

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Resources
    Route::resource('customers', CustomerController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('transactions', TransactionController::class)->except(['edit', 'update']);
});

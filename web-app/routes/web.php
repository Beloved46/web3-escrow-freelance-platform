<?php

use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;
use App\Http\Controllers\Api\UserWalletController;
use App\Http\Controllers\Api\DashboardController;

Route::get('/', function () {
    return view('home');
});

Route::middleware([
    'auth',
    // ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::view('dashboard', 'dashboard.index')->name('dashboard');
    // Dashboard data API endpoints
    Route::get('/api/dashboard-data', [DashboardController::class, 'getDashboardData']);
    Route::post('/api/sync-dashboard', [DashboardController::class, 'syncDashboardData']);
});

// Dashboard API routes
Route::middleware(['auth'])->group(function () {
    Route::get('/api/dashboard/data', [DashboardController::class, 'getCachedData']);
    Route::post('/api/dashboard/sync', [DashboardController::class, 'syncData']);
});

Route::get('/api/user-wallet-address', [UserWalletController::class, 'getWalletByEmail']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/agreement.php';
require __DIR__.'/wallet.php';

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VarietyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/stok', [InventoryController::class, 'publicStok'])->name('stok.index');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('request/success', function () {
    return view('requests.success');
})->name('request.success');
Route::resource('request', RequestController::class)->only(['create', 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('varieties', VarietyController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('report', ReportController::class);
    Route::patch('request/{request}/status', [RequestController::class, 'updateStatus'])->name('request.status');
    Route::resource('request', RequestController::class)->except(['create', 'store', 'edit', 'update', 'destroy'])->names(['index' => 'request.index']);
});

Route::get('storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VarietyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;
use App\Models\Variety;

Route::get('/', function () {
    $varieties = Variety::all();
    return view('landing', compact('varieties'));
})->name('home');

Route::get('/stok', [InventoryController::class, 'publicStok'])->name('stok.index');

Route::get('request/success', function () {
    return view('requests.success');
})->name('request.success');
Route::resource('request', RequestController::class)->only(['create', 'store']);

Route::middleware('auth')->group(function () {
    // Bisa diakses oleh kedua role
    Route::middleware('role:pimpinan,staff')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('request/{request}/download', [RequestController::class, 'download'])->name('request.download');
        Route::resource('request', RequestController::class)->except(['create', 'store', 'edit', 'update', 'destroy'])->names(['index' => 'request.index']);
        Route::resource('report', ReportController::class);
        Route::get('/report-requests', [ReportController::class, 'requestReport'])->name('report.requests');
        Route::get('/report-requests/{month}/download', [ReportController::class, 'downloadRequestReport'])->name('report.requests.download');
    });

    // Hanya bisa diakses oleh staff
    Route::middleware('role:staff')->group(function () {
        Route::resource('varieties', VarietyController::class);
        Route::resource('locations', LocationController::class);
        Route::resource('inventories', InventoryController::class);
        Route::resource('transactions', TransactionController::class);
    });

    // Hanya bisa diakses oleh pimpinan
    Route::middleware('role:pimpinan')->group(function () {
        Route::patch('request/{request}/status', [RequestController::class, 'updateStatus'])->name('request.status');
    });
});

Route::get('storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');

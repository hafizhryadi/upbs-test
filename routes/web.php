<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VarietyController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stocks = \App\Models\Inventory::selectRaw('variety_id, expiry_date, SUM(quantity) as total_quantity')
        ->with('variety')
        ->groupBy('variety_id', 'expiry_date')
        ->orderBy('expiry_date', 'asc')
        ->get();
        
    return view('landing', compact('stocks'));
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('varieties',VarietyController::class);
Route::resource('locations',LocationController::class);
Route::resource('inventories',InventoryController::class);
Route::resource('transactions',TransactionController::class);
Route::resource('report', ReportController::class);

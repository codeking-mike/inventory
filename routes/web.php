<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InverterController;
use App\Http\Controllers\AvrController;
use App\Http\Controllers\SolarPanelController;
use App\Http\Controllers\BatteryController;
use App\Http\Controllers\UpsController;
use App\Http\Controllers\TransactionController;

Route::redirect('/', '/dashboard');

Auth::routes();

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    
    // Transactions
    Route::get('/stock-history', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
    Route::get('/transactions/{reference}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::resource('transactions', TransactionController::class);
    
    // Inverters
    
    Route::get('/inverters-remove', [InverterController::class, 'showRemovalForm'])->name('inverters.remove-form');
    Route::post('/inverters-remove', [InverterController::class, 'storeRemoval'])->name('inverters.store-removal');
    Route::get('/inverters/export', [InverterController::class, 'export'])->name('inverters.export');
    Route::resource('inverters', InverterController::class);
    
    // AVRs
    
    Route::get('/avrs-remove', [AvrController::class, 'showRemovalForm'])->name('avrs.remove-form');
    Route::post('/avrs-remove', [AvrController::class, 'storeRemoval'])->name('avrs.store-removal');
    Route::resource('avrs', AvrController::class);
    
    // Solar Panels
    Route::get('/solar-panels-remove', [SolarPanelController::class, 'showRemovalForm'])->name('solar-panels.remove-form');
    Route::post('/solar-panels-remove', [SolarPanelController::class, 'storeRemoval'])->name('solar-panels.store-removal');
    Route::get('/solar-panels/export', [SolarPanelController::class, 'export'])->name('solar-panels.export');
    Route::resource('solar-panels', SolarPanelController::class);
    
    // Batteries
    Route::get('/batteries-remove', [BatteryController::class, 'showRemovalForm'])->name('batteries.remove-form');
    Route::post('/batteries-remove', [BatteryController::class, 'storeRemoval'])->name('batteries.store-removal');
    Route::get('/batteries/export', [BatteryController::class, 'export'])->name('batteries.export');      
    Route::resource('batteries', BatteryController::class);
    
    // UPS
    Route::get('/ups-remove', [UpsController::class, 'showRemovalForm'])->name('ups.remove-form');
    Route::post('/ups-remove', [UpsController::class, 'storeRemoval'])->name('ups.store-removal');  
    Route::resource('ups', UpsController::class);
});


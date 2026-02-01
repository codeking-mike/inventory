<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InverterController;
use App\Http\Controllers\AvrController;
use App\Http\Controllers\SolarPanelController;
use App\Http\Controllers\BatteryController;
use App\Http\Controllers\UpsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

Route::redirect('/', '/dashboard');

Auth::routes(['register' => false]); // Disable public registration

// Only Admins can access these
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Move the registration logic here   
    // User Management (List and Delete)
    Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');
    Route::get('users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    Route::resource('users', UserController::class);
});

Route::middleware('auth')->group(function () {

    //profile update routes
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'passwordUpdate'])->name('profile.password.update');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/lowstock', [DashboardController::class, 'show'])->name('lowstock');
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


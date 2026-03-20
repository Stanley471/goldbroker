<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\IraController;
use App\Http\Controllers\ReferralController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');

    Route::post('/orders/buy', [OrderController::class, 'buy'])->name('orders.buy')->middleware('throttle:10,1');
    Route::post('/orders/sell', [OrderController::class, 'sell'])->name('orders.sell')->middleware('throttle:10,1');
    Route::get('/ira', [IraController::class, 'index'])->name('ira.index');
Route::get('/ira/create', [IraController::class, 'create'])->name('ira.create');
Route::post('/ira', [IraController::class, 'store'])->name('ira.store');
Route::get('/ira/{iraAccount}', [IraController::class, 'show'])->name('ira.show');
Route::post('/ira/{iraAccount}/transfer', [IraController::class, 'transfer'])->name('ira.transfer');
Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');
Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/orders/buy', [OrderController::class, 'buy'])->name('orders.buy');
    Route::post('/orders/sell', [OrderController::class, 'sell'])->name('orders.sell');
});
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/', function() {
        return redirect()->route('admin.dashboard');
    })->name('admin.home');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
});
require __DIR__.'/auth.php';

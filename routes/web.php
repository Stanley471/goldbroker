<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\IraController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    $goldPrice = app(\App\Services\GoldPriceService::class)->getCurrentPrice();
    return view('welcome', compact('goldPrice'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

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

    //cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    //checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/pending', [CheckoutController::class, 'pending'])->name('checkout.pending');
    
    //throttled routes
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
    Route::patch('/users/{id}/kyc', [AdminController::class, 'updateKyc'])->name('users.kyc');
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});
require __DIR__.'/auth.php';

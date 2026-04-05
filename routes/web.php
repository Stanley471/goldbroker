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
use App\Http\Controllers\Admin\CryptoWalletController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\Admin\KycController as AdminKycController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;

Route::get('/', function () {
    $goldPrice = app(\App\Services\GoldPriceService::class)->getCurrentPrice();
    $featuredProducts = \App\Models\Product::where('is_featured', true)
        ->where('is_active', true)
        ->where('stock', '>', 0)
        ->take(4)
        ->get();
    return view('welcome', compact('goldPrice', 'featuredProducts'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Static Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    // Simple contact form handler - just redirect with success message
    return redirect()->route('contact')->with('success', 'Thank you for your message. We will get back to you soon!');
})->name('contact.submit');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/vault-locations', function () {
    $vaults = \App\Models\Vault::where('is_active', true)->get();
    return view('vault-locations', compact('vaults'));
})->name('vault-locations');

// KYC Gate route - accessible to all authenticated users (without kyc middleware)
Route::middleware(['auth', 'verified'])->get('/kyc-gate', function () {
    return view('kyc.gate', ['user' => auth()->user()]);
})->name('kyc.gate');

Route::middleware(['auth', 'kyc'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'kyc'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/deposit', [WalletController::class, 'processDeposit'])->name('wallet.deposit.process');
    Route::get('/wallet/deposit/crypto', [WalletController::class, 'depositCrypto'])->name('wallet.deposit.crypto');
    Route::get('/wallet/deposit/bank', [WalletController::class, 'depositBank'])->name('wallet.deposit.bank');
    Route::get('/wallet/deposit/pending', [WalletController::class, 'pendingDeposit'])->name('wallet.deposit.pending');
    Route::get('/wallet/locations', [WalletController::class, 'locations'])->name('wallet.locations');
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
    Route::get('/checkout/crypto', [CheckoutController::class, 'cryptoPayment'])->name('checkout.crypto');
    Route::get('/checkout/bank', [CheckoutController::class, 'bankPayment'])->name('checkout.bank');
    Route::post('/checkout/confirm', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm');
    
    //throttled routes
    Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/orders/buy', [OrderController::class, 'buy'])->name('orders.buy');
    Route::post('/orders/sell', [OrderController::class, 'sell'])->name('orders.sell');
    
    });

    // KYC Routes
    Route::get('/kyc', [KycController::class, 'index'])->name('kyc.index');
    Route::get('/kyc/create', [KycController::class, 'create'])->name('kyc.create');
    Route::post('/kyc', [KycController::class, 'store'])->name('kyc.store');
    Route::get('/kyc/{kyc}', [KycController::class, 'show'])->name('kyc.show');
    Route::get('/kyc/{kyc}/document/{type}', [KycController::class, 'document'])->name('kyc.document');
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
    
    // Crypto Wallet Management
    Route::get('/crypto-wallets', [CryptoWalletController::class, 'index'])->name('crypto-wallets.index');
    Route::get('/crypto-wallets/create', [CryptoWalletController::class, 'create'])->name('crypto-wallets.create');
    Route::post('/crypto-wallets', [CryptoWalletController::class, 'store'])->name('crypto-wallets.store');
    Route::get('/crypto-wallets/{cryptoWallet}/edit', [CryptoWalletController::class, 'edit'])->name('crypto-wallets.edit');
    Route::put('/crypto-wallets/{cryptoWallet}', [CryptoWalletController::class, 'update'])->name('crypto-wallets.update');
    Route::delete('/crypto-wallets/{cryptoWallet}', [CryptoWalletController::class, 'destroy'])->name('crypto-wallets.destroy');
    Route::patch('/crypto-wallets/{cryptoWallet}/toggle', [CryptoWalletController::class, 'toggleActive'])->name('crypto-wallets.toggle');
    
    // Bank Account Management
    Route::get('/bank-accounts', [BankAccountController::class, 'index'])->name('bank-accounts.index');
    Route::get('/bank-accounts/create', [BankAccountController::class, 'create'])->name('bank-accounts.create');
    Route::post('/bank-accounts', [BankAccountController::class, 'store'])->name('bank-accounts.store');
    Route::get('/bank-accounts/{bankAccount}/edit', [BankAccountController::class, 'edit'])->name('bank-accounts.edit');
    Route::put('/bank-accounts/{bankAccount}', [BankAccountController::class, 'update'])->name('bank-accounts.update');
    Route::delete('/bank-accounts/{bankAccount}', [BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');
    Route::patch('/bank-accounts/{bankAccount}/toggle', [BankAccountController::class, 'toggleActive'])->name('bank-accounts.toggle');
    
    // KYC Management
    Route::get('/kyc', [AdminKycController::class, 'index'])->name('kyc.index');
    Route::get('/kyc/{kyc}', [AdminKycController::class, 'show'])->name('kyc.show');
    Route::get('/kyc/{kyc}/document/{type}', [AdminKycController::class, 'document'])->name('kyc.document');
    Route::patch('/kyc/{kyc}/approve', [AdminKycController::class, 'approve'])->name('kyc.approve');
    Route::patch('/kyc/{kyc}/reject', [AdminKycController::class, 'reject'])->name('kyc.reject');
    
    // Transaction Management
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [AdminTransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/confirm', [AdminTransactionController::class, 'confirm'])->name('transactions.confirm');
    Route::patch('/transactions/{transaction}/reject', [AdminTransactionController::class, 'reject'])->name('transactions.reject');
});
require __DIR__.'/auth.php';

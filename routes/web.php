<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================

// Landing page (redirect to catalog)
Route::get('/', function () {
    return redirect()->route('customer.catalog');
});

// Customer catalog (public access)
Route::prefix('catalog')->name('customer.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('catalog');

    // Cart routes (uses session, no auth required)
    Route::get('/cart/view', [CustomerController::class, 'cart'])->name('cart');
    Route::post('/cart/add/{id}', [CustomerController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CustomerController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CustomerController::class, 'removeFromCart'])->name('cart.remove');

    // Checkout (no auth required for order placement)
    Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/calculate-shipping', [CustomerController::class, 'calculateShipping'])->name('checkout.shipping');
    Route::post('/checkout/place-order', [CustomerController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/order/success/{id}', [CustomerController::class, 'orderSuccess'])->name('order.success');

    Route::get('/{id}', [CustomerController::class, 'show'])->name('detail');
});

// ==================== AUTHENTICATION ROUTES ====================

// Login routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ==================== ADMIN ROUTES ====================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Karyawan Management
    Route::prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/', [AdminController::class, 'karyawanIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'karyawanCreate'])->name('create');
        Route::post('/', [AdminController::class, 'karyawanStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'karyawanEdit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'karyawanUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'karyawanDestroy'])->name('destroy');
    });

    // Kaos Management
    Route::prefix('kaos')->name('kaos.')->group(function () {
        Route::get('/', [AdminController::class, 'kaosIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'kaosCreate'])->name('create');
        Route::post('/', [AdminController::class, 'kaosStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'kaosEdit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'kaosUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'kaosDestroy'])->name('destroy');
    });

    // Laporan (Financial Reports)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [AdminController::class, 'laporanIndex'])->name('index');
    });
});

// ==================== KASIR ONLINE ROUTES ====================

Route::middleware(['auth', 'role:kasir online'])->prefix('kasir')->name('kasir.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('kasir.transaksi.index');
    })->name('dashboard');

    // Transaction Management
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/{id}', [TransaksiController::class, 'show'])->name('show');
        Route::post('/{id}/confirm', [TransaksiController::class, 'confirm'])->name('confirm');
        Route::post('/{id}/cancel', [TransaksiController::class, 'cancel'])->name('cancel');
        Route::get('/{id}/download-struk', [TransaksiController::class, 'downloadStruk'])->name('download-struk');
    });

    // Transaction History (Kasir's own transactions)
    Route::get('/history', [TransaksiController::class, 'myTransactions'])->name('history');
});

// ==================== KASIR OFFLINE ROUTES ====================
// Note: Kasir offline uses the desktop app, but can view their reports online

Route::middleware(['auth', 'role:kasir offline'])->prefix('kasir-offline')->name('kasir-offline.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');

    // View own transaction history
    Route::get('/history', [TransaksiController::class, 'myTransactions'])->name('history');
});

// ==================== PROFILE ROUTES (All authenticated users) ====================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

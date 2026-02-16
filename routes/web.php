<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama portal
Route::get('/', [FrontController::class, 'index'])->name('home-page');

// Autentikasi
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'index')->name('register');
    Route::post('/register', 'register');
});

// Route untuk customer yang sudah login
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Proses pemesanan
    Route::post('/order/process', [FrontController::class, 'store'])->name('marketplace.order.process');
    
    // Profil customer
    Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    
    // Riwayat pesanan customer
    Route::get('/my-orders', [CustomerController::class, 'orders'])->name('customer.orders');
});

// Route ADMIN - HANYA untuk admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', function () {
        return view('pages.home');
    })->name('dashboard');

    // Manajemen Produk
    Route::resource('product', ProductController::class);
    
    // Manajemen Kategori
    Route::resource('category', CategoryController::class);
    
    // Manajemen Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    
    // Manajemen Stok
    Route::get('/stock', [ProductController::class, 'stockIndex'])->name('stock');
    Route::post('/stock/update/{id}', [ProductController::class, 'updateStock'])->name('stock.update');
});

// Route fallback
Route::fallback(function () {
    return redirect()->route('home-page');
});
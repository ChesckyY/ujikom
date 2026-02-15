<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Route;


Route::get('/', [FrontController::class, 'index'])->name('home-page');


Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'index')->name('register');
    Route::post('/register', 'register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    // Admin Route
    Route::get('/', function () {
        return view('pages.home');
    })->name('admin.dashboard');

    Route::resource('product', ProductController::class);

    //route category
    Route::resource('category', CategoryController::class);

    //route order sisi admin
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');

    //route stock
    Route::get('/stock', [ProductController::class, 'stockIndex'])->name('admin.stock');
    Route::post('/stock/update/{id}', [ProductController::class, 'updateStock'])->name('admin.stock.update');


});

//route simpan pesanan dari front ke database
Route::post('/order/process', [FrontController::class, 'store'])->name('marketplace.order.process');
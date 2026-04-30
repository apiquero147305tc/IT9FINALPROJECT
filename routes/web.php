<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register-process', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');

// Protected Routes (Must be logged in)
Route::middleware(['auth'])->group(function () {
    
    // --- SELLER ROUTES ---
    Route::middleware(['role:seller'])->group(function () {
        // Main Dashboard (Stats and Orders list)
        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dash');
        
        // Product Management (Price, Category, Picture, Stocks)
        Route::resource('products', ProductController::class); 
        
        // View People who ordered
        Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
    });

    // --- BUYER ROUTES ---
Route::middleware(['role:buyer'])->group(function () {
    // Change this line to point to the Controller instead of just a view
    Route::get('/home', [App\Http\Controllers\BuyerController::class, 'index'])->name('buyer.home');
});
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
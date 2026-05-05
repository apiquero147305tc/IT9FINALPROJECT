<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\AdminController; // Added this import
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
    
    // --- ADMIN ROUTES ---
    // This was missing! This is why you got the 404 error in image_2c2ec1.png
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dash');
        Route::post('/admin/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');
        Route::post('/admin/reject/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject');
    });

    // --- SELLER ROUTES ---
    Route::middleware(['role:seller'])->group(function () {
        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dash');
        Route::resource('products', ProductController::class); 
        Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
    });

    // --- BUYER ROUTES ---
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/home', [BuyerController::class, 'index'])->name('buyer.home');
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
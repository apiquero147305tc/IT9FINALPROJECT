<?php
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Protected Dashboards
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
    Route::get('/seller/dashboard', function () { return view('seller.dashboard'); });
    Route::get('/buyer/dashboard', function () { return view('buyer.dashboard'); });
});
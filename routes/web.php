<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerController;

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register-process', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS ONLY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // ========================
    // SELLER ROUTES
    // ========================
    Route::middleware(['role:seller'])->group(function () {

        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])
            ->name('seller.dash');

        Route::resource('products', ProductController::class);

        Route::get('/seller/orders', [SellerController::class, 'orders'])
            ->name('seller.orders');
    });


    // ========================
    // BUYER ROUTES
    // ========================
    Route::middleware(['role:buyer'])->group(function () {

        Route::get('/home', [BuyerController::class, 'index'])
            ->name('buyer.home');
    });


    // ========================
    // ADMIN ROUTES
    // ========================
    Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])->group(function () {

        // =========================
        // ADMIN DASHBOARD
        // =========================
        Route::get('/admin/controlpanel', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        // =========================
        // USER APPROVAL SYSTEM
        // =========================
        Route::post('/admin/approve/{id}', [AdminController::class, 'approveUser'])
            ->name('admin.approve');

        Route::post('/admin/reject/{id}', [AdminController::class, 'rejectUser'])
            ->name('admin.reject');

        // =========================
        // PRODUCT REQUESTS (PENDING)
        // =========================
        Route::get('/admin/products', [AdminController::class, 'products'])
            ->name('admin.products');

        Route::post('/admin/products/{id}/approve', [AdminController::class, 'approveProduct'])
            ->name('admin.products.approve');

        Route::post('/admin/products/{id}/reject', [AdminController::class, 'rejectProduct'])
            ->name('admin.products.reject');

        // =========================
        // PRODUCT MANAGEMENT (CRUD)
        // =========================
        Route::get('/admin/products/manage', [AdminController::class, 'manageProducts'])
            ->name('admin.products.manage');

        Route::get('/admin/products/{id}/edit', [AdminController::class, 'editProduct'])
            ->name('admin.products.edit');

        Route::post('/admin/products/{id}/update', [AdminController::class, 'updateProduct'])
            ->name('admin.products.update');

        Route::post('/admin/products/{id}/delete', [AdminController::class, 'deleteProduct'])
            ->name('admin.products.delete');
    });

});

    // ========================
    // LOGOUT (ALL USERS)
    // ========================
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
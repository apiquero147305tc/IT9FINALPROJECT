<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Landing page (public products preview)
Route::get('/', function () {
    $products = [
        ['name' => 'Rice (5kg)', 'price' => 250, 'image' => '/images/rice.jpg'],
        ['name' => 'Cooking Oil', 'price' => 120, 'image' => '/images/oil.jpg'],
        ['name' => 'Canned Goods', 'price' => 80, 'image' => '/images/canned.jpg'],
        ['name' => 'Laundry Detergent', 'price' => 150, 'image' => '/images/detergent.jpg'],
    ];

    return view('home', compact('products'));
})->name('home');

// Auth pages
Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register-process', [AuthController::class, 'register'])->name('register.post');

Route::get('/chooseRole', function () {
    return view('auth.chooseRole');
})->name('chooseRole');

Route::get('/pending-approval', function () {
    return view('auth.pending');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | MESSAGES
    |--------------------------------------------------------------------------
    */
    Route::get('/messages', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/{userId}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');

    /*
    |--------------------------------------------------------------------------
    | BUYER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');

        Route::get('/cart', function () {
            return view('buyer.cart');
        })->name('cart.index');
    });

    /*
    |--------------------------------------------------------------------------
    | SELLER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:seller'])->group(function () {

        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])
            ->name('seller.dash');

        Route::resource('products', ProductController::class);

        Route::get('/seller/orders', [SellerController::class, 'orders'])
            ->name('seller.orders');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES (MAIN TASK)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        // User approval system
        Route::post('/admin/approve/{id}', [AdminController::class, 'approveUser'])
            ->name('admin.approve');

        Route::post('/admin/reject/{id}', [AdminController::class, 'rejectUser'])
            ->name('admin.reject');
    });
});

/*
|--------------------------------------------------------------------------
| SAFE ROUTES
|--------------------------------------------------------------------------
*/

// Prevent redirect loops
Route::get('/home', function () {
    return redirect()->route('buyer.home');
});

// Shop redirect logic
Route::get('/shop', function () {
    return Auth::check()
        ? redirect()->route('buyer.home')
        : redirect()->route('chooseRole');
})->name('shop');

/*
|--------------------------------------------------------------------------
| STATIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/bestSeller', fn () => view('bestSeller'))->name('bestSeller');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');

/*
|--------------------------------------------------------------------------
| BUYER SIGNUP (optional legacy)
|--------------------------------------------------------------------------
*/

Route::get('/buyer/signup', [AuthController::class, 'showSignup']);
Route::post('/buyer/signup', [AuthController::class, 'signup']);
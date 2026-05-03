<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {

    $products = [
        [
            'name' => 'Rice (5kg)',
            'price' => 250,
            'image' => '/images/rice.jpg'
        ],
        [
            'name' => 'Cooking Oil',
            'price' => 120,
            'image' => '/images/oil.jpg'
        ],
        [
            'name' => 'Canned Goods',
            'price' => 80,
            'image' => '/images/canned.jpg'
        ],
        [
            'name' => 'Laundry Detergent',
            'price' => 150,
            'image' => '/images/detergent.jpg'
        ],
    ];

    return view('home', compact('products'));
})->name('home');


//Authentication
Route::get('/chooseRole', function () {
    return view('auth.chooseRole');
})->name('chooseRole');

/*
|-----------------------------------
| BUYER AUTH
|-----------------------------------
*/
Route::get('/buyer/login', function () {
    return view('auth.buyer.login');
})->name('buyer.login');

Route::get('/buyer/signup', function () {
    return view('auth.buyer.signup');
})->name('buyer.signup');



/*
|-----------------------------------
| SELLER AUTH
|-----------------------------------
*/
Route::get('/seller/login', function () {
    return view('auth.seller.login');
})->name('seller.login');

Route::get('/seller/signup', function () {
    return view('auth.seller.signup');
})->name('seller.signup');


//shop redirect
Route::get('/shop', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('chooseRole');
})->name('shop');


//cuties sa navbar
Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/bestSeller', function () {
    return view('bestSeller');
})->name('bestSeller');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/buyer/signup', [AuthController::class, 'showSignup']);
Route::post('/buyer/signup', [AuthController::class, 'signup']);
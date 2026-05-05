<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $products = [
        ['name' => 'Rice (5kg)', 'price' => 250, 'image' => '/images/rice.jpg'],
        ['name' => 'Cooking Oil', 'price' => 120, 'image' => '/images/oil.jpg'],
        ['name' => 'Canned Goods', 'price' => 80, 'image' => '/images/canned.jpg'],
        ['name' => 'Laundry Detergent', 'price' => 150, 'image' => '/images/detergent.jpg'],
    ];
    return view('home', compact('products'));
})->name('home');

Route::get('/pending-approval', fn() => view('auth.pending'))->name('pending');

// Auth Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('/register-process', [AuthController::class, 'register'])->name('register.post');
    Route::get('/choose-role', fn() => view('auth.chooseRole'))->name('chooseRole');
});

// Static Pages
Route::view('/bestSeller', 'bestSeller')->name('bestSeller');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

/*
|--------------------------------------------------------------------------
| Protected Routes (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 💬 Messages (Shared by all roles)
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageController::class, 'inbox'])->name('messages.inbox');
        Route::get('/{userId}', [MessageController::class, 'chat'])->name('messages.chat');
        Route::post('/send', [MessageController::class, 'send'])->name('messages.send');
    });

    // 🟣 ADMIN ONLY
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dash');
        Route::post('/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');
        Route::post('/reject/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject');
    });

    // 🔴 SELLER ONLY
    Route::middleware(['role:seller'])->prefix('seller')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dash');
        Route::resource('products', ProductController::class);
        Route::get('/orders', [SellerController::class, 'orders'])->name('seller.orders');
    });

    // 🟢 BUYER ONLY
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');
        Route::get('/cart', fn() => view('buyer.cart'))->name('cart.index');
    });

});

/*
|--------------------------------------------------------------------------
| Redirect Logic & Fixes
|--------------------------------------------------------------------------
*/

// Shop entry point
Route::get('/shop', function () {
    return Auth::check() ? redirect()->route('buyer.home') : redirect()->route('chooseRole');
})->name('shop');

// Universal /home redirect to prevent loops
Route::get('/home', function () {
    if (!Auth::check()) return redirect()->route('login');
    
    $user = Auth::user();
    if ($user->role === 'admin') return redirect()->route('admin.dash');
    if ($user->role === 'seller') return redirect()->route('seller.dash');
    return redirect()->route('buyer.home');
});
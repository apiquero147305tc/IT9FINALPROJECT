<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CartController; // Import the CartController
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| 🏠 Public & Static Routes
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

Route::view('/bestSeller', 'bestSeller')->name('bestSeller');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

/*
|--------------------------------------------------------------------------
| 🔐 Auth Pages (Login / Register)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register-process', [AuthController::class, 'register'])->name('register.post');

// Buyer specific signup routes
Route::get('/buyer/signup', [AuthController::class, 'showSignup']);
Route::post('/buyer/signup', [AuthController::class, 'signup']);

Route::get('/choose-role', fn () => view('auth.chooseRole'))->name('chooseRole');
Route::get('/pending-approval', fn () => view('auth.pending'))->name('pending');

/*
|--------------------------------------------------------------------------
| 🛡️ Protected Routes (Must be Logged In)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 💬 Messages
    Route::get('/messages', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/{userId}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');

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
        
        // --- 🛒 Functional Cart Routes ---
        // View the cart
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        
        // Add item (Must be POST)
        Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
        
        // Update quantity (PATCH)
        Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        
        // Remove item (DELETE)
        Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    });

});

/*
|--------------------------------------------------------------------------
| 🔁 Redirect Logic & Fixes
|--------------------------------------------------------------------------
*/

// Shop gatekeeper
Route::get('/shop', function () {
    return Auth::check() ? redirect()->route('buyer.home') : redirect()->route('chooseRole');
})->name('shop');

// Prevent redirect loops and handle the default Laravel /home path
Route::get('/home', function () {
    if (!Auth::check()) return redirect()->route('login');
    
    $user = Auth::user();
    if ($user->role === 'admin') return redirect()->route('admin.dash');
    if ($user->role === 'seller') return redirect()->route('seller.dash');
    return redirect()->route('buyer.home');
});
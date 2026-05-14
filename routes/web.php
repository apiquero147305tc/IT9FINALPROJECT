<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| 🌐 PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Fetching actual best sellers from the DB for the landing page
    $products = Product::latest()->take(4)->get(); 
    return view('home', compact('products'));
})->name('home');

Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');

// Fixed Best Seller: Now fetches actual data to prevent "Undefined Variable" errors
Route::get('/bestSeller', function () {
$products = Product::latest()->get();    return view('bestSeller', compact('products'));
})->name('bestSeller');

Route::get('/products/{product}', [BuyerController::class, 'show'])
    ->name('products.show')
    ->whereNumber('product');

Route::get('/seller/{id}/shop', [BuyerController::class, 'sellerShop'])->name('seller.shop');

/*
|--------------------------------------------------------------------------
| 🔐 AUTHENTICATION SYSTEM
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginPage')->name('login');
    Route::post('/login-process', 'login')->name('login.post');
    Route::get('/register', 'registerPage')->name('register');
    Route::post('/register-process', 'register')->name('register.post');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

Route::get('/choose-role', fn () => view('auth.chooseRole'))->name('chooseRole');
Route::get('/pending-approval', fn () => view('auth.pending'))->name('pending');

/*
|--------------------------------------------------------------------------
| 🛡️ PROTECTED ROUTES (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // --- 💬 UNIFIED MESSAGING SYSTEM ---
    Route::controller(MessageController::class)->group(function () {
        Route::get('/messages', 'inbox')->name('messages.inbox');
        Route::get('/messages/{userId}', 'chat')->name('messages.chat');
        Route::post('/messages/send', 'send')->name('messages.send');
        Route::get('/messages/{userId}/fetch', 'fetchMessages');
    });

    // --- 🛒 BUYER HUB ---
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');
        Route::get('/cart', fn () => view('buyer.cart'))->name('cart.index');
        Route::get('/my-orders', [BuyerController::class, 'orders'])->name('buyer.orders');
    });

    // --- 🏪 SELLER STUDIO ---
    Route::middleware(['role:seller'])->group(function () {
        Route::controller(SellerController::class)->group(function () {
            Route::get('/seller/dashboard', 'dashboard')->name('seller.dash');
            Route::get('/seller/profile', 'profile')->name('seller.profile');
            Route::post('/seller/profile/update', 'updateProfile')->name('seller.profile.update');
            Route::get('/seller/orders', 'orders')->name('seller.orders');
        });

        Route::resource('products', ProductController::class)->except(['show']);
        
        Route::patch('/orders/{id}/status', [SellerController::class, 'updateOrderStatus'])
            ->name('orders.updateStatus');
            
        Route::get('/seller/messages', [MessageController::class, 'sellerInbox'])->name('seller.messages');
    });

    // --- 🟣 ADMIN CONTROL PANEL ---
    Route::middleware(['role:admin'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/admin/dashboard', 'dashboard')->name('admin.dashboard');
            Route::post('/admin/approve/{id}', 'approveUser')->name('admin.approve');
            Route::post('/admin/reject/{id}', 'rejectUser')->name('admin.reject');
        });
    });
});

/*
|--------------------------------------------------------------------------
| 🔁 SYSTEM HELPERS
|--------------------------------------------------------------------------
*/

Route::get('/shop', function () {
    return Auth::check() ? redirect()->route('buyer.home') : redirect()->route('chooseRole');
})->name('shop');

// Global redirect for /home
Route::get('/home', function() {
    if (!Auth::check()) return redirect()->route('home');
    if (Auth::user()->role === 'seller') return redirect()->route('seller.dash');
    if (Auth::user()->role === 'admin') return redirect()->route('admin.dashboard');
    return redirect()->route('buyer.home');
});
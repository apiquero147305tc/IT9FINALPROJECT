<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LendingController; // Added missing import

/*
|--------------------------------------------------------------------------
| 🌍 PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $products = Product::latest()->take(4)->get(); 
    return view('home', compact('products'));
})->name('home');

Route::get('/shop', function () {
    return Auth::check() ? redirect()->route('buyer.home') : redirect()->route('chooseRole');
})->name('shop');

Route::get('/bestSeller', function () {
    $products = Product::latest()->get(); 
    return view('bestSeller', compact('products'));
})->name('bestSeller');

Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');

// Product & Shop Details
Route::get('/products/{product}', [BuyerController::class, 'show'])->name('products.show')->whereNumber('product');
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
    
    Route::get('/choose-role', fn () => view('auth.chooseRole'))->name('chooseRole');
    Route::get('/pending-approval', fn () => view('auth.pending'))->name('pending');
});

/*
|--------------------------------------------------------------------------
| 🛡️ PROTECTED ROUTES (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // --- 🏠 SMART REDIRECTOR ---
    Route::get('/home', function() {
        $role = Auth::user()->role;
        return match($role) {
            'seller' => redirect()->route('seller.dash'),
            'admin'  => redirect()->route('admin.dashboard'),
            default  => redirect()->route('buyer.home'),
        };
    });

    // --- 💬 MESSAGING SYSTEM ---
    Route::controller(MessageController::class)->group(function () {
        Route::get('/messages', 'inbox')->name('messages.inbox');
        Route::get('/messages/{userId}', 'chat')->name('messages.chat');
        Route::post('/messages/send', 'send')->name('messages.send');
        Route::get('/messages/{userId}/fetch', 'fetchMessages');
    });

    // --- 🟢 BUYER HUB ---
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');
        Route::get('/buyer/smartbudgetcontrol', [BuyerController::class, 'smartBudget'])->name('buyer.smartbudgetcontrol');
        Route::get('/my-orders', [BuyerController::class, 'orders'])->name('buyer.orders');

        // 🛒 Cart Actions
        Route::controller(CartController::class)->group(function () {
            Route::get('/cart', 'index')->name('cart.index');
            Route::post('/cart/add/{productId}', 'add')->name('cart.add');
            Route::patch('/cart/update/{id}', 'update')->name('cart.update');
            Route::delete('/cart/remove/{id}', 'destroy')->name('cart.destroy');
        });

        // 💳 Checkout & Orders
        Route::controller(OrderController::class)->group(function () {
            Route::get('/checkout', 'checkout')->name('checkout');
            Route::post('/orders', 'store')->name('orders.store');
            Route::get('/receipt/{order}', 'receipt')->name('receipt');
        });

        // 💡 Lending System
        Route::controller(LendingController::class)->group(function () {
            Route::get('/lending', 'index')->name('lending');
            Route::post('/lending/apply', 'apply')->name('lending.apply');
            Route::post('/lending/repay/{loan}', 'repay')->name('lending.repay');
        });
    });

    // --- 🏪 SELLER STUDIO ---
    Route::middleware(['role:seller'])->group(function () {
        Route::controller(SellerController::class)->group(function () {
            Route::get('/seller/dashboard', 'dashboard')->name('seller.dash');
            Route::get('/seller/profile', 'profile')->name('seller.profile');
            Route::post('/seller/profile/update', 'updateProfile')->name('seller.profile.update');
            Route::get('/seller/orders', 'orders')->name('seller.orders');
            Route::patch('/orders/{id}/status', 'updateOrderStatus')->name('orders.updateStatus');
        });
        Route::resource('products', ProductController::class)->except(['show']);
    });

    // --- 🟣 ADMIN CONTROL PANEL ---
    Route::middleware(['role:admin'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/admin/dashboard', 'dashboard')->name('admin.dashboard');
            Route::get('/admin/users', 'allUsers')->name('admin.users');
            Route::get('/admin/sellers', 'sellers')->name('admin.sellers');
            Route::get('/admin/buyers', 'buyers')->name('admin.buyers');
            Route::post('/admin/approve/{id}', 'approveUser')->name('admin.approve');
            Route::post('/admin/block/{id}', 'block')->name('admin.block');
            Route::delete('/admin/user/{id}/destroy', 'destroyUser')->name('admin.user.destroy');
        });
    });
});
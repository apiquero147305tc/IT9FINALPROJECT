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

/*
|--------------------------------------------------------------------------
| 🌍 PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = Product::latest()->take(4)->get(); 
    return view('home', compact('products'));
})->name('home');

// Simplified Global Shop/Home Redirector
Route::get('/shop', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard.redirect');
    }
    return redirect()->route('chooseRole');
})->name('shop');

Route::get('/best-sellers', function () {
    $products = Product::latest()->get(); 
    return view('bestSeller', compact('products'));
})->name('bestSeller');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// Public Product/Seller Views
Route::get('/products/{product}', [BuyerController::class, 'show'])->name('products.show')->whereNumber('product');
Route::get('/seller/{id}/shop', [BuyerController::class, 'sellerShop'])->name('seller.shop');

/*
|--------------------------------------------------------------------------
| 🔐 AUTHENTICATION & GUEST ACCESS
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/choose-role', [AuthController::class, 'showChooseRole'])->name('chooseRole');

    // Registration Routes
    Route::get('/register/buyer', [AuthController::class, 'showBuyerRegister'])->name('buyer.register');
    Route::post('/register/buyer', [AuthController::class, 'register'])->name('buyer.register.post');
    Route::get('/register/seller', [AuthController::class, 'showSellerRegister'])->name('seller.register');
    Route::post('/register/seller', [AuthController::class, 'register'])->name('seller.register.post');
});

// ✅ FIXED: Added the named "pending" route for unapproved users
Route::get('/pending-approval', [AuthController::class, 'pending'])->name('pending');
Route::get('/blocked', fn() => view('auth.blocked'))->name('blocked');

/*
|--------------------------------------------------------------------------
| 🛡️ PROTECTED ROUTES (Requires Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Smart Home Redirector (Unified)
    Route::get('/home', function() {
        return match(Auth::user()->role) {
            'seller' => redirect()->route('seller.dash'),
            'admin'  => redirect()->route('admin.dashboard'),
            default  => redirect()->route('buyer.home'),
        };
    })->name('dashboard.redirect');

    // Shared Messaging & Orders
    Route::get('/messages/{userId}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/messages/{userId}/fetch', [MessageController::class, 'fetchMessages']);
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    /* --- 🟢 BUYER ROUTES --- */
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');
        Route::get('/cart', fn () => view('buyer.cart'))->name('cart.index');
    });

    /* --- 🔴 SELLER ROUTES --- */
    Route::middleware(['role:seller'])->group(function () {
        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dash');
        Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
        Route::get('/seller/messages', [MessageController::class, 'sellerInbox'])->name('seller.messages');
        
        // Product Management
        Route::resource('products', ProductController::class)->except(['show']);
    });

    /* --- 🟣 ADMIN ROUTES --- */
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // User Management
        Route::get('/admin/users', [AdminController::class, 'allUsers'])->name('admin.users');
        Route::get('/admin/sellers', [AdminController::class, 'sellers'])->name('admin.sellers');
        Route::get('/admin/buyers', [AdminController::class, 'buyers'])->name('admin.buyers');
        Route::get('/admin/blocked', [AdminController::class, 'blockedUsers'])->name('admin.blocked');
        
        // User Actions
        Route::post('/admin/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');
        Route::post('/admin/reject/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject');
        Route::post('/admin/block/{id}', [AdminController::class, 'block'])->name('admin.block');
        Route::post('/admin/unblock/{id}', [AdminController::class, 'unblock'])->name('admin.unblock');
        Route::get('/admin/view-id/{id}', [AdminController::class, 'viewId']);

        // Chat & Email System
        Route::get('/admin/messages', [AdminController::class, 'messages'])->name('admin.messages');
        Route::get('/admin/chat/{id}', [AdminController::class, 'adminChat'])->name('admin.chat');
        Route::get('/admin/email/{id}', [AdminController::class, 'emailPage'])->name('admin.email.page');
        Route::post('/admin/email/{id}', [AdminController::class, 'sendEmail'])->name('admin.email.send');

        // Settings & Maintenance
        Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
        Route::get('/admin/users/delete', [AdminController::class, 'deleteUsersPage'])->name('admin.users.delete.page');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });
});
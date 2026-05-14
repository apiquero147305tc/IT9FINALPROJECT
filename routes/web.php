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
use App\Http\Controllers\LendingController;

/*
|--------------------------------------------------------------------------
| 🌍 PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = Product::latest()->take(4)->get(); 
    return view('home', compact('products'));
})->name('home');

/**
 * FIXED: Added the missing 'shop' route to resolve image_cbd7df.png.
 * This route intelligently redirects based on whether a user is logged in or not.
 */
Route::get('/shop', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        return match($role) {
            'seller' => redirect()->route('seller.dash'),
            'admin'  => redirect()->route('admin.dashboard'),
            default  => redirect()->route('buyer.home'),
        };
    }
    return redirect()->route('chooseRole');
})->name('shop');

Route::get('/best-sellers', function () {
    $products = Product::latest()->get(); 
    return view('bestSeller', compact('products'));
})->name('bestSeller');

Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');

// Product & Shop Details (Publicly viewable)
Route::get('/products/{product}', [BuyerController::class, 'show'])->name('products.show')->whereNumber('product');
Route::get('/seller/{id}/shop', [BuyerController::class, 'sellerShop'])->name('seller.shop');

/*
|--------------------------------------------------------------------------
| 🔐 AUTHENTICATION & REGISTRATION
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginPage')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
  Route::get('/blocked', function () {
    return view('auth.blocked');
})->name('blocked');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');

    Route::get('/choose-role', fn () => view('auth.chooseRole'))->name('chooseRole');

    Route::get('/register', 'registerPage')->name('register');
    Route::post('/register', 'register')->name('register.post');

    // Status Page - Outside specific role middleware to avoid loops
    Route::get('/pending-approval', 'pending')->name('pending');
});

/*
|--------------------------------------------------------------------------
| 🛡️ PROTECTED ROUTES (Requires Login)
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
    })->name('dashboard.redirect');

    // --- 💬 MESSAGING SYSTEM ---
    Route::controller(MessageController::class)->group(function () {
        Route::get('/messages', 'inbox')->name('messages.inbox');
        Route::get('/messages/{userId}', 'chat')->name('messages.chat');
        Route::post('/messages/send', 'send')->name('messages.send');
    });

    // --- 🟢 BUYER HUB ---
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');
        Route::get('/buyer/budget', [BuyerController::class, 'smartBudget'])->name('buyer.smartbudgetcontrol');
        Route::get('/my-orders', [BuyerController::class, 'orders'])->name('buyer.orders');

        Route::resource('cart', CartController::class)->only(['index', 'update', 'destroy']);
        Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');

        Route::controller(OrderController::class)->group(function () {
            Route::get('/checkout', 'checkout')->name('checkout');
            Route::post('/orders', 'store')->name('orders.store');
            Route::get('/receipt/{order}', 'receipt')->name('receipt');
        });

        Route::resource('lending', LendingController::class)->only(['index']);
        Route::post('/lending/apply', [LendingController::class, 'apply'])->name('lending.apply');
    });

    // --- 🏪 SELLER STUDIO ---
    Route::middleware(['role:seller'])->group(function () {
        Route::controller(SellerController::class)->group(function () {
            Route::get('/seller/dashboard', 'dashboard')->name('seller.dash');
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
            Route::post('/admin/approve/{id}', 'approveUser')->name('admin.approve');
            Route::post('/admin/block/{id}', 'block')->name('admin.block');
            Route::get('/admin/view-id/{id}', 'viewId')->name('admin.viewid');
            Route::delete('/admin/user/{id}', 'destroyUser')->name('admin.user.destroy');
        });
    });
    Route::get('/admin/view-id/{id}', [AdminController::class, 'viewId']);
    // pending
    Route::get('/pending-approval', [AuthController::class, 'pending'])
    ->name('pending');
  
    Route::post('/admin/email/{id}', [AdminController::class, 'sendEmail'])
    ->name('admin.email');

    Route::get('/admin/email/{id}', [AdminController::class, 'emailPage'])
    ->name('admin.email.page');

    Route::post('/admin/email/{id}', [AdminController::class, 'sendEmail'])
    ->name('admin.email.send');
});
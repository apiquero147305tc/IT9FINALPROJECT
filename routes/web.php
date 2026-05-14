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
use App\Http\Controllers\CartController;

Route::get('/', function () {
<<<<<<< HEAD
    // Fetches from DB; falls back to empty collection if none exist
    $products = Product::latest()->take(4)->get(); 
=======
    $products = [
        ['name' => 'Rice (5kg)', 'price' => 250, 'image' => '/images/rice.jpg'],
        ['name' => 'Cooking Oil', 'price' => 120, 'image' => '/images/oil.jpg'],
        ['name' => 'Canned Goods', 'price' => 80, 'image' => '/images/canned.jpg'],
        ['name' => 'Laundry Detergent', 'price' => 150, 'image' => '/images/detergent.jpg'],
    ];
>>>>>>> origin/Kino
    return view('home', compact('products'));
})->name('home');

<<<<<<< HEAD
=======
Route::get('/home', function () {
    return redirect()->route('buyer.home');
});

//////////////////////////////////////////////////
// 🛍 PUBLIC SHOP
//////////////////////////////////////////////////

Route::get('/shop', function () {
    return Auth::check() ? redirect()->route('buyer.home') : redirect()->route('chooseRole');
})->name('shop');

//////////////////////////////////////////////////
// 🧾 STATIC PAGES
//////////////////////////////////////////////////

Route::get('/bestSeller', fn () => view('bestSeller'))->name('bestSeller');
>>>>>>> origin/Kino
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');

Route::get('/bestSeller', function () {
    $products = Product::latest()->get(); 
    return view('bestSeller', compact('products'));
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
    
    // Buyer specific signup
    Route::get('/buyer/signup', 'showSignup');
    Route::post('/buyer/signup', 'signup');
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

<<<<<<< HEAD
    // --- 💬 MESSAGING ---
    Route::controller(MessageController::class)->group(function () {
        Route::get('/messages', 'inbox')->name('messages.inbox');
        Route::get('/messages/{userId}', 'chat')->name('messages.chat');
        Route::post('/messages/send', 'send')->name('messages.send');
        Route::get('/messages/{userId}/fetch', 'fetchMessages');
=======
    //////////////////////////////////////////////////
    // 💬 MESSAGES
    //////////////////////////////////////////////////

    Route::get('/messages', [MessageController::class, 'inbox'])
        ->name('messages.inbox');

    Route::get('/messages/{userId}', [MessageController::class, 'chat'])
        ->name('messages.chat');

    Route::post('/messages/send', [MessageController::class, 'send'])
        ->name('messages.send');

    Route::get('/messages/{userId}/fetch', [MessageController::class, 'fetchMessages']);

    //////////////////////////////////////////////////
    // 🛒 ORDERS
    //////////////////////////////////////////////////

    Route::post('/orders', [OrderController::class, 'store'])
        ->name('orders.store');

    //////////////////////////////////////////////////
    // 🟢 BUYER
    //////////////////////////////////////////////////

    Route::middleware(['role:buyer'])->group(function () {

        Route::get('/buyer/home', [BuyerController::class, 'index'])
            ->name('buyer.home');

            // 🛒 CART
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

        // 💳 CHECKOUT
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

        // 🧾 RECEIPT
        Route::get('/receipt/{order}', [OrderController::class, 'receipt'])->name('receipt');

        // 💡 LENDING
        Route::get('/lending', [LendingController::class, 'index'])->name('lending');
        Route::post('/lending/apply', [LendingController::class, 'apply'])->name('lending.apply');
        Route::post('/lending/repay/{loan}', [LendingController::class, 'repay'])->name('lending.repay');
>>>>>>> origin/Kino
    });

    // --- 🛒 BUYER HUB ---
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');
        Route::get('/buyer/smartbudgetcontrol', [BuyerController::class, 'smartBudget'])->name('buyer.smartbudgetcontrol');

        // Cart Actions
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        
        Route::get('/my-orders', [BuyerController::class, 'orders'])->name('buyer.orders');
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
            Route::get('/admin/analytics', 'analytics')->name('admin.analytics');
            
            Route::get('/admin/users', 'allUsers')->name('admin.users');
            Route::get('/admin/sellers', 'sellers')->name('admin.sellers');
            Route::get('/admin/buyers', 'buyers')->name('admin.buyers');
            Route::get('/admin/blocked', 'blockedUsers')->name('admin.blocked');
            
            Route::get('/admin/delete-users', 'deleteUsersPage')->name('admin.users.delete.page');
            Route::delete('/admin/user/{id}/destroy', 'destroyUser')->name('admin.user.destroy');

            Route::post('/admin/approve/{id}', 'approveUser')->name('admin.approve');
            Route::post('/admin/reject/{id}', 'rejectUser')->name('admin.reject');
            Route::post('/admin/block/{id}', 'block')->name('admin.block');
            Route::post('/admin/unblock/{id}', 'unblock')->name('admin.unblock');
            
            Route::get('/admin/settings', 'settings')->name('admin.settings');
            Route::post('/admin/settings/update', 'updateSettings')->name('admin.settings.update');
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

Route::get('/home', function() {
    if (!Auth::check()) return redirect()->route('home');
    
    $role = Auth::user()->role;
    return match($role) {
        'seller' => redirect()->route('seller.dash'),
        'admin'  => redirect()->route('admin.dashboard'),
        default  => redirect()->route('buyer.home'),
    };
});
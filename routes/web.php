<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductRatingController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $products = Product::latest()->take(4)->get();
    return view('home', compact('products'));
})->name('home');

Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');

Route::get('/shop', function () {
    if (Auth::check()) {
        return match(Auth::user()->role) {
            'seller' => redirect()->route('seller.dash'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('buyer.home'),
        };
    }
    return redirect()->route('chooseRole');
})->name('shop');

Route::get('/best-sellers', function () {
    $products = Product::latest()->get();
    return view('bestSeller', compact('products'));
})->name('bestSeller');

Route::get('/products/{id}', [BuyerController::class, 'show'])->name('products.show');
Route::get('/seller/{id}/shop', [BuyerController::class, 'sellerShop'])->name('seller.shop');

/*
|--------------------------------------------------------------------------
| AUTH (GUEST)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/choose-role', fn () => view('auth.chooseRole'))->name('chooseRole');

    Route::get('/register/buyer', [AuthController::class, 'showBuyerRegister'])->name('buyer.register');
    Route::post('/register/buyer', [AuthController::class, 'registerBuyer'])->name('buyer.register.post');

    Route::get('/register/seller', [AuthController::class, 'showSellerRegister'])->name('seller.register');
    Route::post('/register/seller', [AuthController::class, 'registerSeller'])->name('seller.register.post');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/home', function () {
        return match(Auth::user()->role) {
            'seller' => redirect()->route('seller.dash'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('buyer.home'),
        };
    })->name('dashboard.redirect');

    Route::get('/pending', [AuthController::class, 'pending'])->name('auth.pending');

    /*
    |--------------------------------------------------------------------------
    | SELLER APPROVAL FLOW (IMPORTANT FIX)
    |--------------------------------------------------------------------------
    */

    Route::get('/seller/pending', [SellerController::class, 'pending'])->name('seller.pending');

    Route::get('/seller/confirm', [SellerController::class, 'confirm'])->name('seller.confirm');
    Route::patch('/seller/confirm-yes', [SellerController::class, 'confirmYes'])->name('seller.confirm.yes');
    Route::delete('/seller/confirm-no', [SellerController::class, 'confirmNo'])->name('seller.confirm.no');

    /*
    |--------------------------------------------------------------------------
    | MESSAGES
    |--------------------------------------------------------------------------
    */

    Route::controller(MessageController::class)->group(function () {
        Route::get('/messages', 'inbox')->name('messages.inbox');
        Route::get('/messages/{userId}', 'chat')->name('messages.chat');
        Route::post('/messages/send', 'send')->name('messages.send');
        Route::get('/messages/{userId}/fetch', 'fetchMessages');
    });

    /*
    |--------------------------------------------------------------------------
    | REVIEWS / ORDERS
    |--------------------------------------------------------------------------
    */

    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    /*
    |--------------------------------------------------------------------------
    | RECEIPT
    |--------------------------------------------------------------------------
    */

    Route::get('/receipt/{order}', [ReceiptController::class, 'show'])->name('receipt.show');
    Route::get('/receipt/{order}/download', [ReceiptController::class, 'download'])->name('receipt.download');

    /*
    |--------------------------------------------------------------------------
    | LENDING
    |--------------------------------------------------------------------------
    */

    Route::get('/lending', [LendingController::class, 'index'])->name('lending.index');
    Route::get('/lending/create/{product}', [LendingController::class, 'create'])->name('lending.create');
    Route::post('/lending', [LendingController::class, 'store'])->name('lending.store');
      Route::get('/lending/my-requests', [LendingController::class, 'myRequests'])
        ->name('lending.my-requests');

    /*
    |--------------------------------------------------------------------------
    | BUYER
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');
        Route::get('/buyer/smartbudgetcontrol', [BuyerController::class, 'smartBudget'])->name('buyer.smartbudgetcontrol');
        Route::get('/buyer/profile', [BuyerController::class, 'profile'])->name('buyer.profile');
        Route::get('/my-orders', [BuyerController::class, 'orders'])->name('buyer.orders');
    });

    /*
    |--------------------------------------------------------------------------
    | SELLER (ACTIVE ONLY)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:seller'])->group(function () {

        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dash');
        Route::get('/seller/profile', [SellerController::class, 'profile'])->name('seller.profile');

        // ✅ ONLY ONE PRODUCT SYSTEM (FIXED)
        Route::resource('products', ProductController::class);

        Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
        Route::get('/seller/messages', [MessageController::class, 'sellerInbox'])->name('seller.messages');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::post('/admin/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');
        Route::post('/admin/reject/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject');
    });
});

/*
|--------------------------------------------------------------------------
| REPORT
|--------------------------------------------------------------------------
*/

Route::post('/report', [ReportController::class, 'store'])->name('report.store');

/*
|--------------------------------------------------------------------------
| FAVORITES
|--------------------------------------------------------------------------
*/

Route::post('/favorite/{productId}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

Route::get('/blocked', fn () => view('auth.blocked'))->name('blocked');
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

//////////////////////////////////////////////////
// 🏠 HOME
//////////////////////////////////////////////////

Route::get('/', function () {

    $products = [
        ['name' => 'Rice (5kg)', 'price' => 250, 'image' => '/images/rice.jpg'],
        ['name' => 'Cooking Oil', 'price' => 120, 'image' => '/images/oil.jpg'],
        ['name' => 'Canned Goods', 'price' => 80, 'image' => '/images/canned.jpg'],
        ['name' => 'Laundry Detergent', 'price' => 150, 'image' => '/images/detergent.jpg'],
    ];

    return view('home', compact('products'));

})->name('home');

Route::get('/home', function () {
    return redirect()->route('buyer.home');
});

//////////////////////////////////////////////////
// 🛍 PUBLIC SHOP
//////////////////////////////////////////////////

Route::get('/shop', function () {

    if (Auth::check()) {
        return redirect()->route('buyer.home');
    }

    return redirect()->route('chooseRole');

})->name('shop');

//////////////////////////////////////////////////
// 🧾 STATIC PAGES
//////////////////////////////////////////////////

Route::get('/bestSeller', fn () => view('bestSeller'))->name('bestSeller');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');

//////////////////////////////////////////////////
// 🔐 AUTH
//////////////////////////////////////////////////

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register-process', [AuthController::class, 'register'])->name('register.post');

Route::get('/chooseRole', fn () => view('auth.chooseRole'))->name('chooseRole');
Route::get('/choose-role', fn () => view('auth.chooseRole'))->name('chooseRole');

Route::get('/pending', function () {
    return view('auth.pending');
})->name('pending');
//////////////////////////////////////////////////
// 🧾 SIGNUP (BUYER / SELLER)
//////////////////////////////////////////////////

Route::get('/buyer/signup', [AuthController::class, 'showSignup']);
Route::post('/buyer/signup', [AuthController::class, 'signup']);

Route::get('/register/buyer', [AuthController::class, 'showBuyerRegister'])->name('buyer.register');
Route::post('/register/buyer', [AuthController::class, 'registerBuyer'])->name('buyer.register.post');

Route::get('/register/seller', [AuthController::class, 'showSellerRegister'])->name('seller.register');
Route::post('/register/seller', [AuthController::class, 'registerSeller'])->name('seller.register.post');

//////////////////////////////////////////////////
// 🔐 AUTH MIDDLEWARE
//////////////////////////////////////////////////

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

        Route::get('/cart', fn () => view('buyer.cart'))
            ->name('cart.index');
    });

    //////////////////////////////////////////////////
    // 🔴 SELLER
    //////////////////////////////////////////////////

   Route::middleware(['auth', 'role:seller'])->group(function () {

    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])
        ->name('seller.dash');

    Route::resource('products', ProductController::class)->except(['show']);

    Route::get('/seller/orders', [SellerController::class, 'orders'])
        ->name('seller.orders');

    Route::get('/seller/messages', [MessageController::class, 'sellerInbox'])
        ->name('seller.messages');
});

    //////////////////////////////////////////////////
    // 🛍 PRODUCT (EDIT / UPDATE / DELETE)
    //////////////////////////////////////////////////

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    //////////////////////////////////////////////////
    // 🟣 ADMIN
    //////////////////////////////////////////////////

    Route::middleware(['auth', 'role:admin'])->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::get('/admin/users', [AdminController::class, 'allUsers'])
            ->name('admin.users');

        Route::get('/admin/sellers', [AdminController::class, 'sellers'])
            ->name('admin.sellers');

        Route::get('/admin/buyers', [AdminController::class, 'buyers'])
            ->name('admin.buyers');

        Route::get('/admin/blocked', [AdminController::class, 'blockedUsers'])
            ->name('admin.blocked');

        Route::post('/admin/approve/{id}', [AdminController::class, 'approveUser'])
            ->name('admin.approve');

        Route::post('/admin/reject/{id}', [AdminController::class, 'rejectUser'])
            ->name('admin.reject');

        Route::post('/admin/block/{id}', [AdminController::class, 'block'])
            ->name('admin.block');

        Route::post('/admin/unblock/{id}', [AdminController::class, 'unblock'])
            ->name('admin.unblock');

        Route::get('/admin/settings', [AdminController::class, 'settings'])
            ->name('admin.settings');

        Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])
            ->name('admin.settings.update');

        Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');

        Route::get('/admin/users/delete', [AdminController::class, 'deleteUsersPage'])
            ->name('admin.users.delete.page');

        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])
            ->name('admin.users.destroy');
    });

    // pending
    Route::get('/pending-approval', [AuthController::class, 'pending'])->name('pending');
  
    Route::post('/login', [AuthController::class, 'login']);
});
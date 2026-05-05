<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;

//////////////////////////////////////////////////
// 🏠 PUBLIC HOME (your home.blade.php)
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


//////////////////////////////////////////////////
// 🔐 AUTH PAGES
//////////////////////////////////////////////////

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register-process', [AuthController::class, 'register'])->name('register.post');

Route::get('/chooseRole', function () {
    return view('auth.chooseRole');
})->name('chooseRole');

Route::get('/choose-role', fn () => view('auth.chooseRole'))->name('chooseRole');


//////////////////////////////////////////////////
// 🔐 AUTH REQUIRED
//////////////////////////////////////////////////

Route::middleware(['auth'])->group(function () {

    // Logout
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


    //////////////////////////////////////////////////
    // 🟢 BUYER
    //////////////////////////////////////////////////
    Route::middleware(['role:buyer'])->group(function () {

        Route::get('/buyer/home', [BuyerController::class, 'index'])
            ->name('buyer.home');

    });


    //////////////////////////////////////////////////
    // 🔴 SELLER
    //////////////////////////////////////////////////
    Route::middleware(['role:seller'])->group(function () {

        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])
            ->name('seller.dash');

        Route::resource('products', ProductController::class);

        Route::get('/seller/orders', [SellerController::class, 'orders'])
            ->name('seller.orders');

    });


    //////////////////////////////////////////////////
    // 🟣 ADMIN
    //////////////////////////////////////////////////
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

    });

});


//////////////////////////////////////////////////
// 🔁 SAFE /home FIX (prevents redirect loop)
//////////////////////////////////////////////////

Route::get('/home', function () {
    return redirect()->route('buyer.home');
});


//////////////////////////////////////////////////
// 🛍 SHOP (FIXED)
//////////////////////////////////////////////////

Route::get('/shop', function () {

    if (Auth::check()) {
        return redirect()->route('buyer.home');
    }

    return redirect()->route('chooseRole');

})->name('shop');


//////////////////////////////////////////////////
// 📄 STATIC PAGES (UNCHANGED)
//////////////////////////////////////////////////

Route::get('/bestSeller', function () {
    return view('bestSeller');
})->name('bestSeller');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


//////////////////////////////////////////////////
// 🧾 BUYER SIGNUP (UNCHANGED)
//////////////////////////////////////////////////

Route::get('/buyer/signup', [AuthController::class, 'showSignup']);
Route::post('/buyer/signup', [AuthController::class, 'signup']);
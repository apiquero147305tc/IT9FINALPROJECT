<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductRatingController;
use App\Http\Controllers\ProductReviewController; // ⭐ ADDED SAFE

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
| 🔐 Auth Pages
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register-process', [AuthController::class, 'register'])->name('register.post');

Route::get('/buyer/signup', [AuthController::class, 'showSignup']);
Route::post('/buyer/signup', [AuthController::class, 'signup']);

Route::get('/choose-role', fn () => view('auth.chooseRole'))->name('chooseRole');
Route::get('/pending-approval', fn () => view('auth.pending'))->name('pending');

/*
|--------------------------------------------------------------------------
| 🛡️ Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/messages', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/{userId}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');

    /*
    |--------------------------------------------------------------------------
    | 🟣 ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dash');
        Route::post('/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');
        Route::post('/reject/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject');
    });

    /*
    |--------------------------------------------------------------------------
    | 🔴 SELLER
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:seller'])->prefix('seller')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dash');
        Route::resource('products', ProductController::class);
        Route::get('/orders', [SellerController::class, 'orders'])->name('seller.orders');
    });

    /*
    |--------------------------------------------------------------------------
    | 🟢 BUYER
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:buyer'])->group(function () {

        Route::get('/buyer/home', [BuyerController::class, 'index'])
            ->name('buyer.home');

        Route::get('/buyer/smartbudgetcontrol', [BuyerController::class, 'smartBudget'])
            ->name('buyer.smartbudgetcontrol');

        Route::get('/buyer/profile', [BuyerController::class, 'profile'])
            ->name('buyer.profile');

        Route::get('/buyer/favorites', function () {
            $user = auth()->user();

            return view('buyer.favorites', [
                'favorites' => $user->favoriteProducts ?? collect()
            ]);
        })->name('buyer.favorites');

        // 🛒 CART
        Route::get('/cart', [CartController::class, 'index'])
            ->name('cart.index');

        Route::post('/cart/add/{productId}', [CartController::class, 'add'])
            ->name('cart.add');

        Route::patch('/cart/update/{id}', [CartController::class, 'update'])
            ->name('cart.update');

        Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])
            ->name('cart.destroy');

        // ⭐ PRODUCT RATING
        Route::post('/product/{product}/rate', [ProductRatingController::class, 'rate'])
            ->name('product.rate');

        // 💬 PRODUCT REVIEWS (NEW SAFE ADDITION)
        Route::post('/product/{product}/review', [ProductReviewController::class, 'store'])
            ->name('product.review.store');
    });
});

/*
|--------------------------------------------------------------------------
| 🔁 Redirect Logic
|--------------------------------------------------------------------------
*/

Route::get('/shop', function () {
    return Auth::check()
        ? redirect()->route('buyer.home')
        : redirect()->route('chooseRole');
})->name('shop');

Route::get('/home', function () {
    if (!Auth::check()) return redirect()->route('login');

    $user = Auth::user();
    if ($user->role === 'admin') return redirect()->route('admin.dash');
    if ($user->role === 'seller') return redirect()->route('seller.dash');
    return redirect()->route('buyer.home');
});

/*
|--------------------------------------------------------------------------
| ❤️ FAVORITES ACTION
|--------------------------------------------------------------------------
*/

Route::post('/favorite/{productId}', [FavoriteController::class, 'toggle'])
    ->name('favorite.toggle');
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

<<<<<<< HEAD
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
=======
Route::get('/home', function () {
    return redirect()->route('buyer.home');
});

//////////////////////////////////////////////////
// 🛍 PUBLIC SHOP
//////////////////////////////////////////////////

>>>>>>> origin/almostfinal
Route::get('/shop', function () {
    return Auth::check() ? redirect()->route('buyer.home') : redirect()->route('chooseRole');
})->name('shop');

<<<<<<< HEAD
// Prevent redirect loops and handle the default Laravel /home path
Route::get('/home', function () {
    if (!Auth::check()) return redirect()->route('login');
    
    $user = Auth::user();
    if ($user->role === 'admin') return redirect()->route('admin.dash');
    if ($user->role === 'seller') return redirect()->route('seller.dash');
    return redirect()->route('buyer.home');
=======
//////////////////////////////////////////////////
// 🧾 STATIC PAGES
//////////////////////////////////////////////////

Route::get('/bestSeller', fn () => view('bestSeller'))->name('bestSeller');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');

//////////////////////////////////////////////////
// 🔐 AUTH
//////////////////////////////////////////////////

  Route::get('/blocked', function () {
    return view('auth.blocked');
})->name('blocked');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');

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

    //////////////////////////////////////////////////
    // DASHBOARD
    //////////////////////////////////////////////////
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    //////////////////////////////////////////////////
    // USERS
    //////////////////////////////////////////////////
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

    //////////////////////////////////////////////////
    // CHAT / MESSAGES (FIXED)
    //////////////////////////////////////////////////

    // inbox page (list users/messages)
    Route::get('/admin/messages', [AdminController::class, 'messages'])
    ->name('admin.messages');

Route::get('/admin/chat/{id}', [AdminController::class, 'adminChat'])
    ->name('admin.chat');

    //////////////////////////////////////////////////
    // EMAIL SYSTEM (FIXED)
    //////////////////////////////////////////////////

    Route::get('/admin/email/{id}', [AdminController::class, 'emailPage'])
        ->name('admin.email.page');

    Route::post('/admin/email/{id}', [AdminController::class, 'sendEmail'])
        ->name('admin.email.send');

    //////////////////////////////////////////////////
    // EXTRA
    //////////////////////////////////////////////////

    Route::get('/admin/view-id/{id}', [AdminController::class, 'viewId']);

    Route::get('/admin/settings', [AdminController::class, 'settings'])
        ->name('admin.settings');

    Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])
        ->name('admin.settings.update');

    Route::get('/admin/analytics', [AdminController::class, 'analytics'])
        ->name('admin.analytics');

    Route::get('/admin/users/delete', [AdminController::class, 'deleteUsersPage'])
        ->name('admin.users.delete.page');

    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])
        ->name('admin.users.destroy');
});
>>>>>>> origin/almostfinal
});
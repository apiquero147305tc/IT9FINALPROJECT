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
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Models\Product;
use App\Http\Controllers\ReportController;

Route::post('/report/store', [ReportController::class, 'store'])
    ->name('report.store');

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

// Public Product/Seller Views
Route::get('/products/{id}', [BuyerController::class, 'show'])
    ->name('products.show');
Route::get('/seller/{id}/shop', [BuyerController::class, 'sellerShop'])->name('seller.shop');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/choose-role', fn () => view('auth.chooseRole'))->name('chooseRole');
    Route::get('/pending', [AuthController::class, 'pending'])->name('auth.pending');

    // Registration Routes
    Route::get('/register/buyer', [AuthController::class, 'showBuyerRegister'])->name('buyer.register');
    Route::post('/register/buyer', [AuthController::class, 'registerBuyer'])->name('buyer.register.post');

    Route::get('/register/seller', [AuthController::class, 'showSellerRegister'])->name('seller.register');
    Route::post('/register/seller', [AuthController::class, 'registerSeller'])->name('seller.register.post');
});

Route::get('/blocked', fn () => view('auth.blocked'))->name('blocked');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Requires Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Smart Home Redirector
    Route::get('/home', function() {
        return match(Auth::user()->role) {
            'seller' => redirect()->route('seller.dash'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('buyer.home'),
        };
    })->name('dashboard.redirect');

    // --- UNIFIED MESSAGING SYSTEM ---
    Route::controller(MessageController::class)->group(function () {
        Route::get('/messages', 'inbox')->name('messages.inbox');
        Route::get('/messages/{userId}', 'chat')->name('messages.chat');
        Route::post('/messages/send', 'send')->name('messages.send');
        Route::get('/messages/{userId}/fetch', 'fetchMessages');
    });

    // --- REVIEWS ---
    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // --- ORDERS ---
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // --- CART SYSTEM ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // --- RECEIPT SYSTEM ---
    Route::get('/receipt/{order}', [ReceiptController::class, 'show'])->name('receipt.show');
    Route::get('/receipt/{order}/download', [ReceiptController::class, 'download'])->name('receipt.download');

    // --- LENDING SYSTEM ---
    Route::get('/lending', [LendingController::class, 'index'])->name('lending.index');
    Route::get('/lending/create/{product}', [LendingController::class, 'create'])->name('lending.create');
    Route::post('/lending', [LendingController::class, 'store'])->name('lending.store');
    Route::get('/lending/my-requests', [LendingController::class, 'myRequests'])->name('lending.my-requests');
    Route::get('/lending/{id}', [LendingController::class, 'show'])->name('lending.show');
    Route::get('/seller/lendings', [LendingController::class, 'sellerLendings'])->name('lending.seller');
    Route::patch('/lending/{id}/status', [LendingController::class, 'updateStatus'])->name('lending.update-status');
    Route::patch('/products/{product}/toggle-lendable', [LendingController::class, 'toggleLendable'])->name('products.toggle-lendable');

    // --- BUYER ROUTES ---
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');
        Route::get('/buyer/smartbudgetcontrol', [BuyerController::class, 'smartBudget'])->name('buyer.smartbudgetcontrol');
        Route::get('/buyer/profile', [BuyerController::class, 'profile'])->name('buyer.profile');
        Route::get('/buyer/favorites', function () {
            $user = Auth::user();
            return view('buyer.favorites', [
                'favorites' => $user->favoriteProducts ?? collect()
            ]);
        })->name('buyer.favorites');
        Route::get('/my-orders', [BuyerController::class, 'orders'])->name('buyer.orders');
    });

    // --- SELLER ROUTES (ALL - pending, approved, active) ---
    Route::middleware(['role:seller'])->group(function () {

        // Pending approval page
        Route::get('/seller/pending', [SellerController::class, 'pending'])->name('seller.pending');

        // Confirmation page (after admin approval)
        Route::get('/seller/confirm', [SellerController::class, 'confirm'])->name('seller.confirm');

        // Confirm YES - activate seller account
        Route::patch('/seller/confirm-yes', [SellerController::class, 'confirmYes'])->name('seller.confirm.yes');

        // Confirm NO - delete account
        Route::delete('/seller/confirm-no', [SellerController::class, 'confirmNo'])->name('seller.confirm.no');

        // Active seller routes (status checks handled in controller)
        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dash');
        Route::get('/seller/profile', [SellerController::class, 'profile'])->name('seller.profile');
        Route::post('/seller/profile/update', [SellerController::class, 'updateProfile'])->name('seller.profile.update');
        Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
        Route::get('/seller/messages', [MessageController::class, 'sellerInbox'])->name('seller.messages');

        // Product Management
        Route::resource('products', ProductController::class)->except(['show']);

        Route::patch('/orders/{id}/status', [SellerController::class, 'updateOrderStatus'])
            ->name('orders.updateStatus');

        // Product Edit/Update/Delete
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');
    });

    // --- ADMIN ROUTES ---
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // CONTACT MESSAGES
        Route::get('/admin/contacts', [AdminController::class, 'contacts'])->name('admin.contacts');
        Route::post('/admin/contacts/{id}/read', [AdminController::class, 'markAsRead'])->name('admin.contacts.read');

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

// --- FAVORITES (Outside auth for toggle) ---
Route::post('/favorite/{productId}', [FavoriteController::class, 'toggle'])
    ->name('favorite.toggle');
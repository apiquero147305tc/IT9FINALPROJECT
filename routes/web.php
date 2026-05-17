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
use App\Http\Controllers\ContactController;

//////////////////////////////////////////////////
// 🏠 HOME / PUBLIC
//////////////////////////////////////////////////

Route::get('/', function () {
    $products = \App\Models\Product::with(['images', 'user'])
        ->whereHas('user', function ($q) {
            $q->where('status', 'approved')->where('is_blocked', false);
        })
        ->where('stock', '>', 0)
        ->latest()
        ->take(8)
        ->get();

    return view('home', compact('products'));
})->name('home');

Route::get('/home', fn () => redirect()->route('buyer.home'));

Route::get('/shop', function () {
    return Auth::check()
        ? redirect()->route('buyer.home')
        : redirect()->route('chooseRole');
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

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/chooseRole', fn () => view('auth.chooseRole'))->name('chooseRole');

Route::get('/pending', fn () => view('auth.pending'))->name('pending');
Route::get('/blocked', fn () => view('auth.blocked'))->name('blocked');

//////////////////////////////////////////////////
// 🧾 REGISTRATION
//////////////////////////////////////////////////

Route::get('/register/buyer-register', [AuthController::class, 'showBuyerRegister'])->name('buyer.register');
Route::post('/register/buyer-register', [AuthController::class, 'registerBuyer'])->name('buyer.register.post');

Route::get('/register/seller-register', [AuthController::class, 'showSellerRegister'])->name('seller.register');
Route::post('/register/seller-register', [AuthController::class, 'registerSeller'])->name('seller.register.post');

//////////////////////////////////////////////////
// 📨 CONTACT (PUBLIC)
//////////////////////////////////////////////////

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

//////////////////////////////////////////////////
// 🔐 AUTHENTICATED SYSTEM
//////////////////////////////////////////////////

Route::middleware(['auth'])->group(function () {

    //////////////////////////////////////////////////
    // 🔔 NOTIFICATIONS
    //////////////////////////////////////////////////

    Route::get('/notifications/unread', function () {
        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications,
        ]);
    });

    Route::post('/notifications/{id}/read', function ($id) {
        \App\Models\Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['is_read' => true]);

        return response()->json(['ok' => true]);
    });

    Route::post('/notifications/read-all', function () {
        \App\Models\Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['ok' => true]);
    });

    Route::get('/seller/notifications', function () {
        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('seller.notifications', compact('notifications'));
    })->name('seller.notifications');

    //////////////////////////////////////////////////
    // 💬 SHARED MESSAGES SYSTEM
    //////////////////////////////////////////////////

    Route::get('/messages', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/chat/{userId}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/messages/{userId}/fetch', [MessageController::class, 'fetchMessages']);

    //////////////////////////////////////////////////
    // 🛒 ORDERS
    //////////////////////////////////////////////////

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    //////////////////////////////////////////////////
    // 🟢 BUYER
    //////////////////////////////////////////////////

    Route::middleware(['role:buyer'])->group(function () {
        Route::get('/buyer/home', [BuyerController::class, 'index'])->name('buyer.home');
        Route::get('/cart', fn () => view('buyer.cart'))->name('cart.index');
    });

    //////////////////////////////////////////////////
    // 🔴 SELLER
    //////////////////////////////////////////////////

    Route::middleware(['role:seller'])->group(function () {

        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dash');
        
        Route::resource('products', ProductController::class);
        
        // ORDERS — ADDED accept/reject routes
        Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
        Route::post('/seller/orders/{id}/accept', [SellerController::class, 'acceptOrder'])->name('seller.orders.accept');
        Route::post('/seller/orders/{id}/reject', [SellerController::class, 'rejectOrder'])->name('seller.orders.reject');
        
        Route::get('/seller/messages', [MessageController::class, 'sellerInbox'])->name('seller.messages');
        
        // Image delete route
        Route::delete('/seller/images/{image}/delete', [ProductController::class, 'deleteImage'])->name('images.delete');
    });

    //////////////////////////////////////////////////
    // 🟣 ADMIN
    //////////////////////////////////////////////////

    Route::middleware(['role:admin'])->group(function () {

        // Dashboard & Users
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'allUsers'])->name('admin.users');
        Route::get('/admin/sellers', [AdminController::class, 'sellers'])->name('admin.sellers');
        Route::get('/admin/buyers', [AdminController::class, 'buyers'])->name('admin.buyers');
        Route::get('/admin/blocked', [AdminController::class, 'blockedUsers'])->name('admin.blocked');

        // User Actions
        Route::post('/admin/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');
        Route::post('/admin/reject/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject');
        Route::post('/admin/block/{id}', [AdminController::class, 'block'])->name('admin.block');
        Route::post('/admin/unblock/{id}', [AdminController::class, 'unblock'])->name('admin.unblock');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // Email
        Route::get('/admin/email/{id}', [AdminController::class, 'emailPage'])->name('admin.email.page');
        Route::post('/admin/email/{id}', [AdminController::class, 'sendEmail'])->name('admin.email.send');

        // Valid ID
        Route::get('/admin/view-id/{id}', [AdminController::class, 'viewId'])->name('admin.view.id');

        // Settings
        Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

        // Analytics
        Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');

        // Delete Users Page
        Route::get('/admin/users/delete', [AdminController::class, 'deleteUsersPage'])->name('admin.users.delete.page');

        // Contacts / Complaints
        Route::get('/admin/contacts', [AdminController::class, 'contacts'])->name('admin.contacts');
        Route::post('/admin/contacts/read/{id}', [AdminController::class, 'markAsRead'])->name('admin.contacts.read');

        // Messages
        Route::get('/admin/messages', [MessageController::class, 'adminInbox'])->name('admin.messages');
        Route::get('/admin/messages/{id}', [MessageController::class, 'adminChat'])->name('admin.chat');
    });
});
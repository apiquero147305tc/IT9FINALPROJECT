<?php

/**
 * Routes for E-Commerce Features
 * Favorites, Reviews & Ratings, and Search & Filter System
 */

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductSearchController;
use Illuminate\Support\Facades\Route;

// Favorites Routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::get('/favorites/{product}/check', [FavoriteController::class, 'check'])->name('favorites.check');

    // Review Routes (requires authentication)
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Search and Filter Routes (public)
Route::get('/search', [ProductSearchController::class, 'index'])->name('products.search');
Route::get('/api/filters', [ProductSearchController::class, 'getFilters']);

// Public API route for fetching reviews
Route::get('/api/products/{product}/reviews', [ReviewController::class, 'getProductReviews']);

# E-Commerce Features Implementation Guide

## Overview
This document describes the three new e-commerce features added to the IT9FINALPROJECT:

1. **Favorites/Wishlist** - Allow users to save products for later
2. **Product Reviews & Ratings** - Enable buyers to rate and review products
3. **Search & Filter System** - Help users find products with advanced filtering

## Installation & Setup

### Step 1: Update Your Models

#### User Model (app/Models/User.php)
Add the following relationships and methods:

```php
public function favorites()
{
    return $this->belongsToMany(Product::class, 'favorites')
                ->withTimestamps();
}

public function isFavorite($productId)
{
    return $this->favorites()->where('product_id', $productId)->exists();
}
```

#### Product Model (app/Models/Product.php)
Add the following relationships and methods:

```php
public function reviews()
{
    return $this->hasMany(Review::class);
}

public function approvedReviews()
{
    return $this->reviews()->where('approved', true)->orderByDesc('created_at');
}

public function getAverageRating()
{
    return $this->approvedReviews()->avg('rating') ?? 0;
}

public function getReviewCount()
{
    return $this->approvedReviews()->count();
}
```

### Step 2: Run Migrations

```bash
php artisan migrate
```

This will create:
- `favorites` table - for storing user favorites
- `reviews` table - for storing product reviews and ratings

### Step 3: Include Routes

Add the following to your `routes/web.php`:

```php
include 'features-routes.php';
```

Or manually add the routes from `routes/features-routes.php`

### Step 4: Update Navigation

Add links to your navigation/layout:

```blade
@auth
    <li><a href="{{ route('favorites.index') }}">My Favorites</a></li>
@endauth
<li><a href="{{ route('products.search') }}">Search Products</a></li>
```

## Features Documentation

### 1. Favorites/Wishlist

**Location:** `/favorites`

**Features:**
- Users can add/remove products to/from favorites
- View all favorite products with pagination
- Products show favorite status throughout the site
- AJAX endpoint to check favorite status

**Database Table:** `favorites`
- `user_id` - Reference to user
- `product_id` - Reference to product
- Unique constraint ensures no duplicate favorites

**Key Files:**
- `app/Http/Controllers/FavoriteController.php`
- `app/Models/Favorite.php`
- `resources/views/favorites/index.blade.php`

### 2. Product Reviews & Ratings

**Features:**
- Users can rate products (1-5 stars)
- Leave optional written reviews/comments
- View all reviews on product page
- See average product rating
- Review moderation system (can be approved/rejected)
- Prevent duplicate reviews from same user

**Database Table:** `reviews`
- `user_id` - Who wrote the review
- `product_id` - Product being reviewed
- `rating` - Star rating (1-5)
- `comment` - Written review
- `approved` - Moderation flag

**Key Files:**
- `app/Http/Controllers/ReviewController.php`
- `app/Models/Review.php`
- `resources/views/components/product-reviews.blade.php`

**Include in Product View:**
```blade
@include('components.product-reviews', ['product' => $product])
```

### 3. Search & Filter System

**Location:** `/search`

**Filters Available:**
- **Keyword Search** - Search by product name/description
- **Category Filter** - Filter by product category
- **Price Range** - Filter by minimum and maximum price
- **Rating Filter** - Filter by minimum average rating
- **Sort Options**:
  - Latest products
  - Price: Low to High
  - Price: High to Low
  - Highest Rating

**Features:**
- Persistent filter state (filters remain when navigating)
- Pagination support
- Combined filtering (multiple filters at once)
- Responsive design

**Key Files:**
- `app/Http/Controllers/ProductSearchController.php`
- `resources/views/products/search.blade.php`

## Usage Examples

### Add to Favorites Button
```blade
<form action="{{ route('favorites.store', $product->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">
        {{ Auth::user()->isFavorite($product->id) ? 'Remove from Favorites' : 'Add to Favorites' }}
    </button>
</form>
```

### Display Product Rating
```blade
@if($product->getAverageRating() > 0)
    <div class="rating">
        <span class="stars">{{ str_repeat('★', round($product->getAverageRating())) }}</span>
        <span class="rating-value">{{ number_format($product->getAverageRating(), 1) }}/5</span>
        <span class="review-count">({{ $product->getReviewCount() }} reviews)</span>
    </div>
@endif
```

## Admin Moderation

Reviews require moderation before appearing. To approve reviews:

```bash
php artisan tinker
App\Models\Review::where('approved', false)->update(['approved' => true]);
```

Or create an admin panel to manage reviews.

## Future Enhancements

- Add helpful/unhelpful voting on reviews
- Review images/photos
- Verified purchase badge on reviews
- Email notifications for new favorites alerts
- Advanced search with faceted navigation
- Review analytics dashboard
- Email reminders for abandoned favorites

## Troubleshooting

**Issue:** Foreign key constraint error on migration
- Ensure `users` and `products` tables exist first
- Check table names match in migrations

**Issue:** Favorites not showing
- Verify `favorites` table was created: `php artisan migrate`
- Check User model has `favorites()` relationship

**Issue:** Reviews not appearing
- Ensure reviews have `approved = true`
- Verify `reviews` table has data
- Check Review model `approvedReviews()` scope

## Support

For issues or questions, refer to the GitHub issues:
- #[Favorites Issue Number]
- #[Reviews Issue Number]
- #[Search Filter Issue Number]

@extends('layouts.app')

@section('title', 'Shop - CraveCart')

@section('content')
<div class="shop-page">
    <!-- Hero Section -->
    <div class="shop-hero">
        <h1>🛒 CraveCart Shop</h1>
        <p>Discover delicious food, drinks, and snacks from our sellers</p>
    </div>

    <!-- Search & Filter Bar -->
    <div class="filter-section">
        <form action="{{ route('shop') }}" method="GET" class="filter-form">
            <div class="search-box">
                <input type="text" name="search" placeholder="🔍 Search products or sellers..." 
                       value="{{ request('search') }}" class="search-input">
            </div>
            <select name="category" class="category-select">
                <option value="All">All Categories</option>
                <option value="food" {{ request('category') == 'food' ? 'selected' : '' }}>🍔 Food</option>
                <option value="drinks" {{ request('category') == 'drinks' ? 'selected' : '' }}>🥤 Drinks</option>
                <option value="snacks" {{ request('category') == 'snacks' ? 'selected' : '' }}>🍿 Snacks</option>
                <option value="desserts" {{ request('category') == 'desserts' ? 'selected' : '' }}>🍰 Desserts</option>
            </select>
            <select name="sort" class="sort-select">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>📅 Latest</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>💰 Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>💰 Price: High to Low</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>⭐ Top Rated</option>
            </select>
            <button type="submit" class="btn-filter">🔍 Search</button>
            @if(request('search') || request('category') || request('sort'))
                <a href="{{ route('shop') }}" class="btn-clear">✕ Clear</a>
            @endif
        </form>
    </div>

    <!-- Products Grid -->
    <div class="products-container">
        @forelse($products as $product)
            @php
                $ratings = $product->ratings ?? collect();
                $avgRating = $ratings->avg('rating') ?? 0;
                $ratingCount = $ratings->count() ?? 0;
                $fullStars = floor($avgRating);
                $images = $product->images ?? collect();
                $firstImage = $images->first();
            @endphp

            <div class="product-card">
                <a href="{{ route('products.show', $product->id) }}" class="product-link">
                    <div class="product-image">
                        @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage->path) }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="no-image">🍽️</div>
                        @endif
                        <span class="category-badge">{{ ucfirst($product->category ?? 'Food') }}</span>
                    </div>
                    <div class="product-details">
                        <h3>{{ $product->name }}</h3>
                        <p class="seller">🏪 {{ $product->user->shop_name ?? $product->user->name ?? 'CraveCart Seller' }}</p>
                        
                        <!-- Rating -->
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <span class="star filled">★</span>
                                @else
                                    <span class="star">☆</span>
                                @endif
                            @endfor
                            <span class="rating-text">{{ number_format($avgRating, 1) }} ({{ $ratingCount }})</span>
                        </div>

                        <div class="product-footer">
                            <span class="price">₱{{ number_format($product->price, 2) }}</span>
                            <span class="stock {{ ($product->stock ?? 0) > 0 ? 'available' : 'unavailable' }}">
                                {{ ($product->stock ?? 0) > 0 ? '✅ In Stock' : '❌ Sold Out' }}
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Actions -->
                <div class="product-actions">
                    <a href="{{ route('products.show', $product->id) }}" class="btn-view">👁️ View</a>
                    @auth
                        @if(Auth::user()->role === 'buyer' && ($product->stock ?? 0) > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-cart">🛒 Cart</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div class="empty-shop">
                <div class="empty-icon">📭</div>
                <h3>No Products Found</h3>
                <p>Try adjusting your search or check back later for new items.</p>
                <a href="{{ route('shop') }}" class="btn-browse">Browse All Products</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($products) && method_exists($products, 'links'))
        <div class="pagination-wrapper">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif

    <!-- CTA for guests -->
    @guest
        <div class="guest-cta">
            <p>Want to order? <a href="{{ route('login') }}">Login</a> or <a href="{{ route('chooseRole') }}">Register</a> now!</p>
        </div>
    @endguest
</div>
@endsection

@push('styles')
<style>
    .shop-page {
        max-width: 1400px;
        margin: 0 auto;
    }
    .shop-hero {
        text-align: center;
        padding: 40px 20px;
        margin-bottom: 30px;
    }
    .shop-hero h1 {
        color: #333;
        font-size: 2.5rem;
        margin-bottom: 10px;
    }
    .shop-hero p {
        color: #666;
        font-size: 1.1rem;
    }
    .filter-section {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    .filter-form {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }
    .search-box {
        flex: 2;
        min-width: 250px;
    }
    .search-input {
        width: 100%;
        padding: 14px 25px;
        border: 2px solid #e9ecef;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.3s;
    }
    .search-input:focus {
        border-color: #dd0d22;
    }
    .category-select, .sort-select {
        padding: 14px 20px;
        border: 2px solid #e9ecef;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        background: white;
        cursor: pointer;
        min-width: 150px;
    }
    .btn-filter {
        padding: 14px 30px;
        background: #dd0d22;
        color: white;
        border: none;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-filter:hover {
        background: #b30b1b;
        transform: translateY(-2px);
    }
    .btn-clear {
        padding: 14px 20px;
        background: #f8f9fa;
        color: #666;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-clear:hover {
        background: #e9ecef;
    }
    .products-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }
    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    .product-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .product-image {
        height: 220px;
        background: #f8f9fa;
        position: relative;
        overflow: hidden;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
    }
    .category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(221,13,34,0.9);
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .product-details {
        padding: 20px;
    }
    .product-details h3 {
        color: #333;
        font-size: 1.1rem;
        margin-bottom: 8px;
        font-weight: 600;
    }
    .seller {
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 10px;
    }
    .rating {
        display: flex;
        align-items: center;
        gap: 3px;
        margin-bottom: 12px;
    }
    .star {
        color: #ffc107;
        font-size: 1rem;
    }
    .star.filled {
        color: #ffc107;
    }
    .rating-text {
        color: #666;
        font-size: 0.8rem;
        margin-left: 5px;
    }
    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }
    .price {
        color: #dd0d22;
        font-size: 1.3rem;
        font-weight: 700;
    }
    .stock {
        font-size: 0.8rem;
        font-weight: 600;
    }
    .available { color: #28a745; }
    .unavailable { color: #dc3545; }
    .product-actions {
        display: flex;
        gap: 10px;
        padding: 0 20px 20px;
    }
    .btn-view, .btn-cart {
        flex: 1;
        padding: 12px;
        border-radius: 50px;
        text-align: center;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        border: none;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-view {
        background: transparent;
        color: #dd0d22;
        border: 2px solid #dd0d22;
    }
    .btn-view:hover {
        background: #fff5f5;
    }
    .btn-cart {
        background: #dd0d22;
        color: white;
    }
    .btn-cart:hover {
        background: #b30b1b;
        transform: translateY(-2px);
    }
    .empty-shop {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
    }
    .empty-icon {
        font-size: 5rem;
        margin-bottom: 20px;
    }
    .empty-shop h3 {
        color: #333;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    .empty-shop p {
        color: #666;
        margin-bottom: 25px;
    }
    .btn-browse {
        display: inline-block;
        padding: 14px 35px;
        background: #dd0d22;
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-browse:hover {
        background: #b30b1b;
        transform: translateY(-2px);
    }
    .pagination-wrapper {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }
    .guest-cta {
        text-align: center;
        margin-top: 40px;
        padding: 30px;
        background: white;
        border-radius: 20px;
    }
    .guest-cta a {
        color: #dd0d22;
        font-weight: 600;
        text-decoration: none;
    }
    .guest-cta a:hover {
        text-decoration: underline;
    }
    @media (max-width: 768px) {
        .filter-form {
            flex-direction: column;
        }
        .search-box, .category-select, .sort-select, .btn-filter, .btn-clear {
            width: 100%;
        }
        .shop-hero h1 {
            font-size: 1.8rem;
        }
    }
</style>
@endpush
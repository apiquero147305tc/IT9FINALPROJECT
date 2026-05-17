<x-buyerDash>

<script src="https://unpkg.com/lucide@latest"></script>

<style>
body {
    background: #f8fafc;
}

.page-wrapper {
    padding: 30px;
    min-height: 100vh;
    background: radial-gradient(circle at top, #fff1f2 0%, #f8fafc 60%);
}

/* HEADER */
.page-header {
    margin-bottom: 18px;
}

.page-header h1 {
    margin: 0;
    font-size: 34px;
    font-weight: 900;
    background: linear-gradient(90deg,#e11d48,#f97316);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.page-header p {
    margin-top: 6px;
    color: #6b7280;
}

/* SORT BAR */
.sort-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    gap: 10px;
    flex-wrap: wrap;
}

.sort-bar select {
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background: white;
    font-weight: 600;
    cursor: pointer;
}

/* PRODUCT CARD */
.product-card {
    background: white;
    border-radius: 18px;
    overflow: hidden;
    transition: 0.2s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    border: 1px solid #f1f5f9;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 30px rgba(0,0,0,0.10);
}

.product-actions {
    position: absolute;
    top: 10px;
    right: 10px;
}

.icon-btn {
    background: rgba(255,255,255,0.95);
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

/* CART */
.cart-btn {
    width: 100%;
    border: none;
    padding: 11px;
    border-radius: 12px;
    background: linear-gradient(90deg, #e11d48, #f97316);
    color: white;
    font-weight: 700;
}

/* CATEGORY */
.category-tag {
    display: inline-block;
    background: #fff1f2;
    color: #e11d48;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 10px;
}

/* RATING */
.rating-row {
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 6px 0 10px;
    font-size: 13px;
    color: #6b7280;
}

.stars {
    display: flex;
    gap: 2px;
}

.star {
    font-size: 14px;
    color: #d1d5db;
}

.star.filled {
    color: #f59e0b;
}

/* GRID */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 22px;
}

.empty-state {
    grid-column: 1/-1;
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 16px;
    border: 1px solid #eee;
}
</style>

<div class="page-wrapper">

    <div class="page-header">
        <h1>Buyer Marketplace</h1>
        <p>Browse products and discover affordable essentials.</p>
    </div>

    {{-- SORTING UI --}}
    <form method="GET" class="sort-bar">
        <div></div>

        <select name="sort" onchange="this.form.submit()">
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
        </select>
    </form>

    @php
        $user = auth()->user();
        $favorites = $user ? ($user->favoriteProducts ?? collect()) : collect();
    @endphp

    <div class="product-grid">

        @forelse($products as $product)

            @php
                $ratings = $product->ratings ?? collect();
                $avgRating = $ratings->avg('rating') ?? 0;
                $ratingCount = $ratings->count() ?? 0;

                $fullStars = floor($avgRating);
            @endphp

            <div class="product-card">

                {{-- FAVORITE --}}
                <div class="product-actions">
                    <form action="{{ route('favorite.toggle', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="icon-btn">
                            @if($favorites->contains($product->id))
                                <i data-lucide="heart" style="color:#e11d48; fill:#e11d48;"></i>
                            @else
                                <i data-lucide="heart" style="color:#9ca3af;"></i>
                            @endif
                        </button>
                    </form>
                </div>

                <div style="height:220px; overflow:hidden;">
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/300x220' }}"
                         style="width:100%; height:100%; object-fit:cover;">
                </div>

                <div style="padding:18px;">

                    <div class="category-tag">
                        {{ $product->category }}
                    </div>

                    <h3 style="margin:0;">
                        {{ $product->name }}
                    </h3>

                    <p style="margin-top:10px; font-size:22px; font-weight:800; color:#e11d48;">
                        ₱{{ number_format($product->price, 2) }}
                    </p>

                    {{-- RATING (UPGRADED) --}}
                    <div class="rating-row">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $fullStars ? 'filled' : '' }}">★</span>
                            @endfor
                        </div>

                        <span>
                            {{ number_format($avgRating, 1) }} ({{ $ratingCount }})
                        </span>
                    </div>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button class="cart-btn">Add to Cart</button>
                    </form>

                </div>
            </div>

        @empty

            <div class="empty-state">
                <h2>No products found</h2>
                <p style="color:#6b7280;">Try adjusting search or category.</p>
            </div>

        @endforelse

    </div>
</div>

<script>
    lucide.createIcons();
</script>

<!-- <div class="bg-white p-4 rounded-xl shadow mb-6">
    <h2 class="text-lg font-bold mb-2">Notifications</h2>

    @forelse($notifications as $note)

        <div class="border-b py-2">
            <h3 class="font-semibold">{{ $note->subject }}</h3>
            <p class="text-gray-600">{{ $note->message }}</p>
        </div>

    @empty
        <p class="text-gray-400">No notifications yet.</p>
    @endforelse
</div> -->

</x-buyerDash>
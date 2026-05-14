<x-buyerDash>

<script src="https://unpkg.com/lucide@latest"></script>

<style>
    body {
        background: #f8fafc;
    }

    .product-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        transition: 0.25s ease;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 30px rgba(0,0,0,0.10);
    }

    .cart-btn {
        width: 100%;
        border: none;
        padding: 12px;
        border-radius: 12px;
        background: linear-gradient(90deg, #f59e0b, #d97706);
        color: white;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .cart-btn:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }

    /* ❤️ FAVORITE BUTTON STYLE */
    .icon-btn {
        background: rgba(255,255,255,0.9);
        border: none;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        font-size: 16px;
    }

    .product-actions {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>

<div style="
    padding:30px;
    min-height:100vh;
    background: radial-gradient(circle at top, #fff7ed 0%, #f8fafc 60%);
">

    {{-- HEADER --}}
    <div style="margin-bottom:25px;">
        <h1 style="
            margin:0;
            font-size:34px;
            font-weight:900;
            background: linear-gradient(90deg,#fbbf24,#f59e0b,#d97706);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        ">
            Buyer Marketplace
        </h1>

        <p style="color:#6b7280;">
            Browse products and discover affordable essentials.
        </p>
    </div>

    {{-- NOTIFICATIONS --}}
    @if(session('success'))
        <div style="background:#dcfce7; color:#166534; padding:14px; border-radius:12px; margin-bottom:15px;">
            ✔ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fee2e2; color:#991b1b; padding:14px; border-radius:12px; margin-bottom:15px;">
            ✖ {{ session('error') }}
        </div>
    @endif

    {{-- PRODUCT GRID --}}
    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fill, minmax(240px,1fr));
        gap:22px;
    ">

        @forelse($products as $product)

            <div class="product-card">

                {{-- ❤️ FAVORITE BUTTON (ADDED ONLY) --}}
                <div class="product-actions">
                    <form action="{{ route('favorite.toggle', $product->id) }}" method="POST">
                        @csrf

                        <button type="submit" class="icon-btn" title="Favorite">
                            @if(auth()->user()->favoriteProducts->contains($product->id))
                                ❤️
                            @else
                                🤍
                            @endif
                        </button>
                    </form>
                </div>

                {{-- ✅ IMAGE FIX (ONLY CHANGE MADE) --}}
                <div style="height:220px; overflow:hidden;">

                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <img src="https://via.placeholder.com/300x220"
                             style="width:100%; height:100%; object-fit:cover;">
                    @endif

                </div>

                <div style="padding:18px;">

                    <div style="
                        display:inline-block;
                        background:#fef3c7;
                        color:#92400e;
                        padding:6px 12px;
                        border-radius:999px;
                        font-size:12px;
                        font-weight:700;
                        margin-bottom:10px;
                    ">
                        {{ $product->category }}
                    </div>

                    <h3 style="margin:0; color:#111827;">
                        {{ $product->name }}
                    </h3>

                    <p style="
                        margin-top:10px;
                        font-size:22px;
                        font-weight:800;
                        color:#d97706;
                    ">
                        ₱{{ number_format($product->price, 2) }}
                    </p>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button class="cart-btn">🛒 Add to Cart</button>
                    </form>

                </div>
            </div>

        @empty

            <div style="
                grid-column:1/-1;
                text-align:center;
                padding:60px 20px;
                background:white;
                border-radius:16px;
                border:1px solid #eee;
            ">
                <h2 style="margin-bottom:5px;">No products found</h2>
                <p style="color:#6b7280;">
                    Try adjusting search or category in the navbar.
                </p>
            </div>

        @endforelse

    </div>

</div>

</x-buyerDash>
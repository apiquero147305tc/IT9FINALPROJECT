<x-buyerDash>

<style>
    *{ box-sizing:border-box; }

    body{
        margin:0;
        font-family:Arial, Helvetica, sans-serif;
        background:#f3f4f6;
        color:#111827;
    }

    .container{
        max-width:1100px;
        margin:40px auto;
        background:white;
        border-radius:24px;
        padding:30px;
        box-shadow:0 10px 30px rgba(0,0,0,0.08);
    }

    .top-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:35px;
    }

    .images img{
        width:100%;
        height:420px;
        object-fit:cover;
        border-radius:18px;
    }

    .rating-box{
        background:#fff7ed;
        border:1px solid #fed7aa;
        border-radius:18px;
        padding:20px;
        margin-top:20px;
    }

    .rating-score{
        font-size:42px;
        font-weight:800;
        color:#f59e0b;
    }

    .stars{
        color:#f59e0b;
        font-size:22px;
        letter-spacing:3px;
    }

    .review-form select,
    .review-form textarea{
        width:100%;
        border:1px solid #d1d5db;
        border-radius:14px;
        padding:14px;
        font-size:14px;
        margin-bottom:15px;
    }

    .submit-btn{
        width:100%;
        border:none;
        background:linear-gradient(to right,#dc2626,#ea580c);
        color:white;
        padding:14px;
        border-radius:14px;
        font-weight:800;
        cursor:pointer;
    }

    .seller-box{
        margin-top:30px;
        padding:20px;
        background:#f9fafb;
        border-radius:18px;
        border:1px solid #e5e7eb;
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:15px;
    }

    .chat-btn{
        text-decoration:none;
        background:#111;
        color:white;
        padding:12px 18px;
        border-radius:12px;
        font-weight:700;
    }

    .sold-out{
        margin-top:20px;
        color:red;
        font-weight:700;
    }

    .back-link{
        display:inline-block;
        margin-top:25px;
        color:#6b7280;
        font-weight:700;
        text-decoration:none;
    }

    .success-box{
        background:#dcfce7;
        color:#166534;
        padding:14px;
        border-radius:12px;
        margin-bottom:20px;
    }
</style>

<div class="container">

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="success-box">
            {{ session('success') }}
        </div>
    @endif

    @php
        $reviews = $product->reviews ?? collect();
        $avgRating = round($reviews->avg('rating') ?? 0, 1);
        $totalReviews = $reviews->count();
    @endphp

    <div class="top-grid">

        {{-- LEFT --}}
        <div class="images">
            @forelse($product->images ?? [] as $img)
                <img src="{{ asset('storage/' . $img->image_path) }}">
            @empty
                <img src="https://via.placeholder.com/500">
            @endforelse
        </div>

        {{-- RIGHT --}}
        <div>

            <div style="font-size:26px; font-weight:800;">
                {{ $product->name }}
            </div>

            <div style="color:#666; margin-top:5px;">
                Sold by <b>{{ $product->seller->shop_name ?? $product->seller->name }}</b>
            </div>

            <div style="font-size:28px; font-weight:900; color:#dc2626; margin-top:10px;">
                ₱{{ number_format($product->price, 2) }}
            </div>

            <div style="margin-top:12px; color:#444;">
                {{ $product->description }}
            </div>

            {{-- BUY + CART ACTIONS --}}
            @auth
                @if(auth()->user()->role === 'buyer' && $product->stock > 0)

                    <div style="margin-top:20px; display:flex; gap:10px;">

                        {{-- BUY NOW --}}
                        <form action="{{ route('orders.store') }}" method="POST" style="flex:1;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">

                            <button style="
                                width:100%;
                                padding:14px;
                                background:linear-gradient(to right,#dc2626,#ea580c);
                                color:white;
                                border:none;
                                border-radius:12px;
                                font-weight:900;
                            ">
                                ⚡ Buy Now
                            </button>
                        </form>

                        {{-- ADD TO CART --}}
                        <form action="{{ route('cart.add', $product) }}" method="POST" style="flex:1;">
                            @csrf
                            <button style="
                                width:100%;
                                padding:14px;
                                background:white;
                                border:1px solid #ddd;
                                border-radius:12px;
                                font-weight:800;
                            ">
                                🛒 Add to Cart
                            </button>
                        </form>

                    </div>

                @else
                    <div class="sold-out">
                        Product Sold Out
                    </div>
                @endif
            @endauth

        </div>
    </div>

    {{-- RATINGS --}}
    <div class="rating-box">

        <div style="display:flex; gap:20px; align-items:center;">
            <div class="rating-score">{{ $avgRating }}</div>

            <div>
                <div class="stars">★★★★★</div>
                <div>{{ $totalReviews }} Reviews</div>
            </div>
        </div>

        <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="review-form">
            @csrf

            <select name="rating" required>
                <option value="">Select Rating</option>
                <option value="5">★★★★★</option>
                <option value="4">★★★★</option>
                <option value="3">★★★</option>
                <option value="2">★★</option>
                <option value="1">★</option>
            </select>

            <textarea name="comment" placeholder="Write review..." required></textarea>

            <button class="submit-btn">Submit Review</button>
        </form>

    </div>

    {{-- SELLER --}}
    <div class="seller-box">

        <div>
            <strong>Seller:</strong>
            {{ $product->seller->name ?? 'Unknown' }}
        </div>

        <a href="{{ route('messages.chat', $product->user_id) }}" class="chat-btn">
            💬 Chat
        </a>

        <button type="button" onclick="openReportModal()" class="chat-btn">
            ⚠ Report
        </button>

    </div>

    <a href="{{ route('buyer.home') }}" class="back-link">
        ← Back to Marketplace
    </a>

</div>

{{-- REPORT MODAL --}}
<div id="reportModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">

    <div style="background:white; width:90%; max-width:400px; padding:20px; border-radius:16px;">

        <form method="POST" action="{{ route('report.store') }}">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="seller_id" value="{{ $product->user_id }}">

            <select name="type" style="width:100%; padding:10px;">
                <option value="product">Product</option>
                <option value="seller">Seller</option>
            </select>

            <textarea name="reason" placeholder="Reason..." style="width:100%; padding:10px; margin-top:10px;"></textarea>

            <button style="width:100%; margin-top:10px; padding:12px; background:#dc2626; color:white;">
                Submit
            </button>
        </form>

        <button onclick="closeReportModal()" style="width:100%; margin-top:10px; padding:10px;">
            Cancel
        </button>

    </div>
</div>

<script>
function openReportModal(){
    document.getElementById('reportModal').style.display='flex';
}
function closeReportModal(){
    document.getElementById('reportModal').style.display='none';
}
</script>

</x-buyerDash>
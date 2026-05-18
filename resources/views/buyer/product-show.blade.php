<x-buyerDash>

    <style>
        *{
            box-sizing:border-box;
        }

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

        .images{
            display:flex;
            gap:12px;
            overflow-x:auto;
        }

        .images img{
            width:220px;
            height:220px;
            object-fit:cover;
            border-radius:18px;
            border:1px solid #e5e7eb;
            background:#f9fafb;
        }

        .product-name{
            font-size:34px;
            font-weight:800;
            margin-bottom:8px;
        }

        .shop-name{
            color:#6b7280;
            margin-bottom:18px;
        }

        .price{
            color:#dc2626;
            font-size:34px;
            font-weight:800;
            margin-bottom:18px;
        }

        .description{
            color:#374151;
            line-height:1.7;
            margin-bottom:25px;
        }

        .rating-box{
            background:#fff7ed;
            border:1px solid #fed7aa;
            border-radius:18px;
            padding:20px;
            margin-top:20px;
        }

        .rating-header{
            display:flex;
            align-items:center;
            gap:16px;
            margin-bottom:15px;
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

        .review-count{
            color:#6b7280;
            font-size:14px;
            margin-top:5px;
        }

        .review-form{
            margin-top:20px;
        }

        .review-form label{
            display:block;
            margin-bottom:8px;
            font-weight:700;
            color:#374151;
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

        .review-form textarea{
            min-height:120px;
            resize:vertical;
        }

        .submit-btn{
            border:none;
            background:linear-gradient(to right,#dc2626,#ea580c);
            color:white;
            padding:14px 20px;
            border-radius:14px;
            font-weight:700;
            cursor:pointer;
            width:100%;
            transition:0.2s;
        }

        .submit-btn:hover{
            opacity:0.95;
            transform:translateY(-1px);
        }

        .reviews-section{
            margin-top:40px;
        }

        .section-title{
            font-size:24px;
            font-weight:800;
            margin-bottom:20px;
        }

        .review-card{
            background:#f9fafb;
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:18px;
            margin-bottom:15px;
        }

        .review-top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:10px;
        }

        .review-user{
            font-weight:700;
        }

        .review-stars{
            color:#f59e0b;
            font-weight:700;
        }

        .review-comment{
            color:#374151;
            line-height:1.6;
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
            background:#dc2626;
            color:white;
            padding:12px 18px;
            border-radius:12px;
            font-weight:700;
        }

        .buy-form{
            margin-top:25px;
        }

        .buy-btn{
            width:100%;
            border:none;
            padding:16px;
            border-radius:16px;
            background:linear-gradient(to right,#dc2626,#ea580c);
            color:white;
            font-size:16px;
            font-weight:800;
            cursor:pointer;
        }

        .sold-out{
            margin-top:20px;
            color:red;
            font-weight:700;
        }

        .back-link{
            display:inline-block;
            margin-top:25px;
            text-decoration:none;
            color:#6b7280;
            font-weight:700;
        }

        .empty-review{
            text-align:center;
            color:#6b7280;
            padding:30px;
            background:#f9fafb;
            border-radius:18px;
            border:1px solid #e5e7eb;
        }

        .success-box{
            background:#dcfce7;
            color:#166534;
            padding:14px;
            border-radius:12px;
            margin-bottom:20px;
        }

        @media(max-width:900px){

            .top-grid{
                grid-template-columns:1fr;
            }

            .images img{
                width:180px;
                height:180px;
            }
        }
    </style>
</head>

<body style="margin:0; background:#f5f5f5; font-family:Arial;">


@php
    $reviews = $product->reviews ?? collect();

    $avgRating = round($reviews->avg('rating') ?? 0, 1);
    $totalReviews = $reviews->count();
@endphp

<div class="container">

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="success-box">
            {{ session('success') }}
        </div>
    @endif

    <div class="top-grid">

        {{-- LEFT --}}
        <div>

            {{-- PRODUCT IMAGES --}}
            <div style="max-width:520px; margin:0 auto; background:white; min-height:100vh; position:relative;">

    {{-- IMAGE CAROUSEL (TikTok style) --}}
    <div style="display:flex; overflow-x:auto; scroll-snap-type:x mandatory;">

        @forelse($product->images ?? [] as $img)
            <img src="{{ asset('storage/' . $img->image_path) }}"
                 style="width:100%; flex:0 0 100%; height:420px; object-fit:cover; scroll-snap-align:center;">
        @empty
            <img src="https://via.placeholder.com/500"
                 style="width:100%; height:420px; object-fit:cover;">
        @endforelse

    </div>

    
    {{-- RIGHT --}}
    <div style="padding:16px;">
        
        <div style="font-size:22px; font-weight:800;">
            {{ $product->name }}
        </div>
        
        <div style="color:#666; margin-top:5px;">
            Sold by <b>{{ $product->seller->shop_name ?? $product->seller->name }}</b>
        </div>
        
        <div style="font-size:26px; font-weight:900; color:#dc2626; margin-top:10px;">
            ₱{{ number_format($product->price, 2) }}
        </div>
        
        <div style="margin-top:12px; color:#444; line-height:1.6;">
            {{ $product->description }}
        </div>
        
    </div>
    
    {{-- STEP 11 + STEP 12 --}}
    {{-- RATINGS + REVIEWS DISPLAY --}}
    <div class="rating-box">
        
        <div class="rating-header">
            
            <div class="rating-score">
                {{ $avgRating }}
            </div>
            
            <div>
                
                <div class="stars">
                    ★★★★★
                </div>
                
                <div class="review-count">
                    {{ $totalReviews }} Reviews • {{ $avgRating }}/5 Avg Rating
                </div>
                
            </div>
            
        </div>
        
        {{-- REVIEW FORM --}}
        <div class="review-form">
            
            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                @csrf
                
                {{-- STEP 11 --}}
                {{-- STAR RATING INPUT --}}
                <label>
                    Product Rating
                </label>
                
                <select name="rating" required>
                    
                    <option value="">Select Rating</option>
                    <option value="5">★★★★★ - Excellent</option>
                    <option value="4">★★★★ - Very Good</option>
                            <option value="3">★★★ - Good</option>
                            <option value="2">★★ - Fair</option>
                            <option value="1">★ - Poor</option>
                            
                        </select>
                        
                        {{-- STEP 12 --}}
                        {{-- REVIEW COMMENT --}}
                        <label>
                            Your Review
                        </label>
                        
                        <textarea
                            name="comment"
                            required
                            placeholder="Share your experience..."
                            style="width:100%; padding:12px; border-radius:10px; min-height:120px;"
                        ></textarea>
                        
                        <button type="submit" class="submit-btn">
                            Submit Review
                        </button>

                    </form>
                    
                </div>

            </div>

        </div>

    </div>

    {{-- CUSTOMER REVIEWS --}}
    <div class="reviews-section">

        <div class="section-title">
            Customer Reviews
        </div>

        @forelse($product->reviews as $review)

        <div class="review-card">
            
            <div class="review-top">
                
                <div class="review-user">
                {{ $review->user->name ?? 'Anonymous User' }}
            </div>

            <div class="review-stars">
                ★ {{ $review->rating }}/5
            </div>
            
        </div>

        <div class="review-comment">
            {{ $review->comment }}
        </div>

    </div>

    @empty

    <div class="empty-review">
        No reviews yet.
    </div>

@endforelse

    </div>

    {{-- SELLER --}}
    <div class="seller-box">

           <div>
        <strong>Seller:</strong>
        {{ $product->seller->name ?? 'Unknown Seller' }}
    </div>
    
    <div style="display:flex; gap:10px; padding:16px;">
        
        {{-- CHAT --}}
        <a href="{{ route('messages.chat', $product->user_id) }}"
        style="flex:1; text-align:center; padding:12px; background:#111; color:white; border-radius:10px; text-decoration:none;">
        💬 Chat
    </a>
    
    <button type="button"
    onclick="openReportModal()"
    style="
        background:#111827;
        color:white;
        padding:12px 18px;
        border-radius:12px;
        font-weight:700;
        border:none;
        cursor:pointer;
        position:relative;
        z-index:10;
        ">
    ⚠ Report
</button>

</div>

</div>

{{-- BUY NOW --}}
@if($product->stock > 0)

<div style="
    position:fixed;
    bottom:0;
    left:0;
    width:100%;
    background:white;
    padding:12px;
    border-top:1px solid #eee;
">

    <div style="max-width:520px; margin:0 auto; display:flex; gap:10px;">

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
                font-weight:800;
            ">
                Buy Now
            </button>
        </form>

        
        @else
        
        <div class="sold-out">
            Product Sold Out
        </div>
        
    </div>
</div>
        @endif
        
        {{-- BACK --}}
    <a href="{{ route('buyer.home') }}"
    class="back-link">
    
    ← Back to Marketplace
    
    </a>
    
</div>
</div>

{{-- REPORT MODAL --}}
<div id="reportModal"
     style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,0.6);
        justify-content:center;
        align-items:center;
        z-index:9999;
     ">

    <div style="background:white; width:90%; max-width:400px; padding:20px; border-radius:16px;">

        <h2 style="font-weight:800; margin-bottom:10px;">Report Product</h2>

        <form method="POST" action="{{ route('report.store') }}">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="seller_id" value="{{ $product->user_id }}">

            <select name="type" style="width:100%; padding:10px; margin-bottom:10px;">
                <option value="product">Product</option>
                <option value="seller">Seller</option>
            </select>

            <textarea name="reason"
                      placeholder="Why are you reporting this?"
                      style="width:100%; padding:10px; min-height:100px;"></textarea>

            <button type="submit"
                    style="width:100%; margin-top:10px; padding:12px; background:#dc2626; color:white; border:none; border-radius:10px;">
                Submit Report
            </button>
        </form>

        <button onclick="closeReportModal()"
                style="margin-top:10px; width:100%; padding:10px; background:#eee; border:none; border-radius:10px;">
            Cancel
        </button>

    </div>
</div>

<script>
function openReportModal() {
    document.getElementById('reportModal').style.display = 'flex';
}

function closeReportModal() {
    document.getElementById('reportModal').style.display = 'none';
}
</script>

</x-buyerDash>
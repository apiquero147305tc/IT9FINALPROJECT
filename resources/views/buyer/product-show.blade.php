<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>

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

<body>

@php
    $ratings = $product->ratings ?? collect();
    $reviews = $product->reviews ?? collect();

    $avgRating = round($ratings->avg('rating') ?? 0, 1);
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
            <div class="images">

                @forelse($product->images ?? [] as $img)

                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="Product Image">

                @empty

                    <img src="https://via.placeholder.com/220" alt="No Image">

                @endforelse

            </div>

        </div>

        {{-- RIGHT --}}
        <div>

            <div class="product-name">
                {{ $product->name }}
            </div>

            <div class="shop-name">
                Sold by:
                <strong>
                    {{ $product->seller->shop_name ?? $product->seller->name ?? 'Shop' }}
                </strong>
            </div>

            <div class="price">
                ₱{{ number_format($product->price, 2) }}
            </div>

            <div class="description">
                {{ $product->description ?? 'No description available.' }}
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
                            {{ $totalReviews }} Reviews • {{ $ratings->count() }} Ratings
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
                            placeholder="Share your experience about this product..."
                            required
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

    <div style="display:flex; gap:10px; align-items:center;">

        {{-- CHAT --}}
        <a href="{{ route('messages.chat', $product->user_id) }}"
           class="chat-btn">

            💬 Chat Seller

        </a>

        {{-- REPORT BUTTON (STEP 5) --}}
        <button type="button"
                onclick="document.getElementById('reportModal').classList.remove('hidden')"
                style="
                    background:#111827;
                    color:white;
                    padding:12px 18px;
                    border-radius:12px;
                    font-weight:700;
                    border:none;
                    cursor:pointer;
                ">

            ⚠ Report

        </button>

    </div>

    </div>

    {{-- BUY NOW --}}
    @if($product->stock > 0)

        <form action="{{ route('orders.store') }}"
              method="POST"
              class="buy-form">

            @csrf

            <input type="hidden"
                   name="product_id"
                   value="{{ $product->id }}">

            <input type="hidden"
                   name="quantity"
                   value="1">

            <button type="submit" class="buy-btn">
                Buy Now
            </button>

        </form>

    @else

        <div class="sold-out">
            Product Sold Out
        </div>

    @endif

    {{-- BACK --}}
    <a href="{{ route('buyer.home') }}"
       class="back-link">

        ← Back to Marketplace

    </a>

</div>

{{-- REPORT MODAL --}}
<div id="reportModal"
     class="hidden"
     style="
        position:fixed;
        top:0; left:0;
        width:100%; height:100%;
        background:rgba(0,0,0,0.5);
        display:flex;
        align-items:center;
        justify-content:center;
     ">

    <div style="
        background:white;
        width:100%;
        max-width:500px;
        padding:25px;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,0.2);
    ">

        <h2 style="font-size:22px; font-weight:800; margin-bottom:15px;">
            Report Product / Seller
        </h2>

        <form method="POST" action="{{ route('report.store') }}">
            @csrf

            {{-- PRODUCT ID --}}
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            {{-- SELLER ID --}}
            <input type="hidden" name="seller_id" value="{{ $product->user_id }}">

            {{-- TYPE --}}
            <label style="font-weight:700;">Report Type</label>
            <select name="type" required
                    style="width:100%; padding:12px; border-radius:10px; margin:8px 0 15px;">

                <option value="product">Product</option>
                <option value="seller">Seller / Shop</option>

            </select>

            {{-- REASON --}}
            <label style="font-weight:700;">Reason</label>
            <textarea name="reason"
                      required
                      placeholder="Explain your report..."
                      style="width:100%; padding:12px; border-radius:10px; min-height:120px; margin-top:8px;">
            </textarea>

            {{-- BUTTONS --}}
            <button type="submit"
                    style="
                        width:100%;
                        background:#dc2626;
                        color:white;
                        padding:12px;
                        border:none;
                        border-radius:12px;
                        font-weight:800;
                        margin-top:15px;
                        cursor:pointer;
                    ">
                Submit Report
            </button>

        </form>

        {{-- CLOSE --}}
        <button onclick="document.getElementById('reportModal').classList.add('hidden')"
                style="
                    margin-top:10px;
                    width:100%;
                    background:#e5e7eb;
                    padding:10px;
                    border:none;
                    border-radius:10px;
                    cursor:pointer;
                ">
            Cancel
        </button>

    </div>
</div>

</body>
</html>
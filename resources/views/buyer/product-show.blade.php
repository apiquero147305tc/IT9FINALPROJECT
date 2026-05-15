<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }}</title>

    <style>
        body {
            font-family: sans-serif;
            background: #f8fafc;
            padding: 25px;
            margin: 0;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }

        .images {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .images img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
        }

        .shop-name {
            color: #6b7280;
            margin-top: -10px;
        }

        .price {
            color: #e11d48;
            font-size: 30px;
            font-weight: 800;
            margin-top: 10px;
        }

        .description {
            margin-top: 18px;
            line-height: 1.7;
            color: #374151;
        }

        .rating-box {
            margin-top: 25px;
            background: #fff7ed;
            border-radius: 18px;
            padding: 18px;
            border: 1px solid #fed7aa;
        }

        .rating-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .rating-score {
            font-size: 28px;
            font-weight: 800;
            color: #f59e0b;
        }

        .stars {
            color: #f59e0b;
            font-size: 20px;
            letter-spacing: 2px;
        }

        .review-count {
            color: #6b7280;
            font-size: 14px;
        }

        .review-form {
            margin-top: 20px;
        }

        .review-form textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            padding: 14px;
            resize: vertical;
            min-height: 100px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .submit-btn {
            margin-top: 12px;
            border: none;
            background: linear-gradient(90deg, #e11d48, #f97316);
            color: white;
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .submit-btn:hover {
            transform: scale(1.02);
        }

        .reviews-section {
            margin-top: 30px;
        }

        .review-card {
            background: #f9fafb;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 14px;
            border: 1px solid #e5e7eb;
        }

        .review-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .review-user {
            font-weight: 700;
            color: #111827;
        }

        .review-stars {
            color: #f59e0b;
            font-size: 14px;
        }

        .review-comment {
            color: #374151;
            line-height: 1.6;
        }

        .seller-box {
            margin-top: 25px;
            padding: 18px;
            border-radius: 16px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .seller-box a {
            text-decoration: none;
            color: #e11d48;
            font-weight: 700;
            margin-left: 10px;
        }

        .btn {
            width: 100%;
            border: none;
            padding: 14px;
            border-radius: 14px;
            margin-top: 20px;
            cursor: pointer;
            font-weight: 700;
            font-size: 15px;
        }

        .buy {
            background: linear-gradient(90deg, #e11d48, #f97316);
            color: white;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #6b7280;
            font-weight: 600;
        }

        .empty-review {
            color: #6b7280;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- IMAGES --}}
    <div class="images">
        @forelse($product->images ?? [] as $img)
            <img src="{{ asset('storage/' . $img->image_path) }}">
        @empty
            <img src="https://via.placeholder.com/180">
        @endforelse
    </div>

    {{-- PRODUCT INFO --}}
    <h1>{{ $product->name }}</h1>

    <div class="shop-name">
        {{ $product->seller->shop_name ?? 'Shop' }}
    </div>

    <div class="price">
        ₱{{ number_format($product->price, 2) }}
    </div>

    <div class="description">
        {{ $product->description ?? 'No description available.' }}
    </div>

    {{-- RATINGS --}}
    @php
        $ratings = $product->ratings ?? collect();
        $avg = round($ratings->avg('rating') ?? 0, 1);

        $reviews = $product->reviews ?? collect();
    @endphp

    <div class="rating-box">

        <div class="rating-header">

            <div class="rating-score">
                {{ $avg }}
            </div>

            <div>
                <div class="stars">
                    ★★★★★
                </div>

                <div class="review-count">
                    {{ $ratings->count() }} ratings
                </div>
            </div>

        </div>

        {{-- REVIEW FORM --}}
        <div class="review-form">

            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                @csrf

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

    {{-- REVIEWS --}}
    <div class="reviews-section">

        <h2>Customer Reviews</h2>

        @forelse($reviews as $review)

            <div class="review-card">

                <div class="review-top">

                    <div class="review-user">
                        {{ $review->user->name ?? 'Anonymous User' }}
                    </div>

                    <div class="review-stars">
                        ★ {{ $review->rating ?? 5 }}/5
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

        <strong>Seller:</strong>
        {{ $product->seller->name ?? 'Unknown Seller' }}

        <a href="{{ route('messages.chat', $product->user_id) }}">
            Chat Seller
        </a>

    </div>

    {{-- BUY --}}
    @if($product->stock > 0)

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">

            <button type="submit" class="btn buy">
                Buy Now
            </button>
        </form>

    @else

        <p style="color:red; font-weight:bold;">
            Sold Out
        </p>

    @endif

    <a href="{{ route('buyer.home') }}" class="back-link">
        ← Back to Marketplace
    </a>

</div>

</body>
</html>
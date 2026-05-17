<!DOCTYPE html>
<html>
<head>
    <title>Seller Shop</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 20px;
        }

        .back {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            font-weight: 600;
            color: #111827;
        }

        .shop-header {
            background: white;
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 20px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        }

        .shop-header h2 {
            margin: 0;
            font-size: 22px;
            color: #111827;
        }

        .shop-header p {
            margin: 5px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            gap: 18px;
        }

        .card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transition: 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 22px rgba(0,0,0,0.10);
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .card-body {
            padding: 12px;
        }

        .card h3 {
            font-size: 14px;
            margin: 0 0 8px;
            color: #111827;
        }

        .price {
            color: #d97706;
            font-weight: 800;
            font-size: 15px;
        }

        .empty {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 12px;
            color: #6b7280;
        }
    </style>
</head>

<body>

<a href="{{ url()->previous() }}" class="back">← Back</a>

<div class="shop-header">

    <h2>
        🏪 {{ optional($products->first()->user)->shop_name ?? 'Shop' }}
    </h2>

    <p>
        {{ $products->count() }} product(s) available
    </p>

</div>

@if($products->count() > 0)

    <div class="grid">

        @foreach($products as $product)

            <a href="{{ route('products.show', $product->id) }}"
               style="text-decoration:none; color:inherit;">

                <div class="card">

                    @if(!empty($product->images) && $product->images->count())
                        <img src="{{ asset('storage/'.$product->images[0]->image_path) }}">
                    @else
                        <img src="https://via.placeholder.com/300x300?text=No+Image">
                    @endif

                    <div class="card-body">

                        <h3>{{ $product->name }}</h3>

                        <div class="price">
                            ₱{{ number_format($product->price, 2) }}
                        </div>

                    </div>

                </div>

            </a>

        @endforeach

    </div>

@else

    <div class="empty">
        No products available in this shop.
    </div>

@endif

</body>
</html>
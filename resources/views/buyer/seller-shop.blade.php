<!DOCTYPE html>
<html>
<head>
    <title>Seller Shop</title>
    <style>
        body { font-family: Arial; background:#f5f5f5; padding:20px; }

        .back {
            display:inline-block;
            margin-bottom:15px;
            text-decoration:none;
            font-weight:bold;
            color:#333;
        }

        .shop-header {
            background:white;
            padding:20px;
            border-radius:10px;
            margin-bottom:20px;
            box-shadow:0 2px 6px rgba(0,0,0,0.1);
        }

        .grid {
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
            gap:15px;
        }

        .card {
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 2px 6px rgba(0,0,0,0.1);
        }

        .card img {
            width:100%;
            height:150px;
            object-fit:cover;
        }

        .card h3 {
            font-size:14px;
            margin:10px;
        }

        .price {
            margin:10px;
            color:#dd0d22;
            font-weight:bold;
        }
    </style>
</head>
<body>

<a href="{{ url()->previous() }}" class="back">← Back</a>

<div class="shop-header">
   <h2>🏪 {{ $products->first()->user->shop_name ?? 'Shop' }}</h2>
    <p>{{ $products->count() }} products available</p>
</div>

<div class="grid">

    @foreach($products as $product)
        <div class="card">

            <a href="{{ route('products.show', $product->id) }}"
               style="text-decoration:none; color:inherit;">

                @if($product->images->count())
                    <img src="{{ asset('storage/'.$product->images[0]->image_path) }}">
                @else
                    <img src="https://via.placeholder.com/150">
                @endif

                <h3>{{ $product->name }}</h3>

                <div class="price">
                    ₱{{ number_format($product->price, 2) }}
                </div>

            </a>

        </div>
    @endforeach

</div>

</body>
</html>
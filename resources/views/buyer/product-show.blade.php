<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }}</title>

    <style>
        body {
            font-family: sans-serif;
            background: #f3e3cb;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
        }

        .images {
            display:flex;
            gap:10px;
        }

        .images img {
            width:150px;
            height:150px;
            object-fit:cover;
            border-radius:10px;
        }

        .price {
            color:#dd0d22;
            font-size:24px;
            font-weight:bold;
        }

        .btn {
            margin-top:15px;
            padding:12px;
            width:100%;
            border:none;
            border-radius:10px;
            cursor:pointer;
        }

        .buy {
            background:#ff4a00;
            color:white;
        }

        .chat {
            background:#eee;
        }

        .seller-box {
            margin-top:20px;
            padding:15px;
            background:#fafafa;
            border-radius:10px;
        }
    </style>
</head>
<body>

<div class="container">

    {{-- IMAGES --}}
    <div class="images">
        @foreach($product->images as $img)
            <img src="{{ asset('storage/' . $img->image_path) }}">
        @endforeach
    </div>

    {{-- PRODUCT INFO --}}
    <h2>{{ $product->name }}</h2>

    <h4>
    <a href="{{ route('seller.shop', $product->user->id) }}"
       style="text-decoration:none; color:inherit;">
        Shop Name: {{ $product->seller->shop_name }}
    </a>
    </h4>

    <p class="price">₱{{ number_format($product->price, 2) }}</p>

    <p>{{ $product->description ?? 'No description available.' }}</p>

    {{-- SELLER INFO --}}
    <div class="seller-box">
        <strong>Seller:</strong> {{ $product->user->name ?? 'Unknown Seller' }}

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
        <p style="color:red;">Sold Out</p>
    @endif

    {{-- BACK --}}
    <a href="{{ route('buyer.home') }}" style="display:block; margin-top:15px;">
        ← Back to Products
    </a>

</div>

<x-messui />
</body>
</html>
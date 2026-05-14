<<<<<<< HEAD
<x-buyerDash>
    <style>
        .cart-wrapper {
            font-family: sans-serif;
            /* We use padding instead of min-height to avoid hiding the navbar */
            padding: 50px 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .cart-box {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .h2cartname {
            color: #dd0d22;
            margin-top: 0;
            margin-bottom: 20px;
        }

        /* Styling for the items that appear */
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .item-details h4 {
            margin: 0;
            font-size: 1rem;
        }

        .item-details p {
            margin: 5px 0 0;
            color: #dd0d22;
            font-weight: bold;
        }

        .empty {
            color: #777;
            padding: 40px;
        }

        .back-btnbuyer {
            display: inline-block;
            margin-top: 20px;
            background: #dd0d22;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }

        .back-btnbuyer:hover {
            background: #b30b1b;
        }
        
        .checkout-btn {
            width: 100%;
            background: #28a745;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
        }
    </style>

    <div class="cart-wrapper">
        <div class="cart-box">
            <h2 class="h2cartname">My Cart</h2>

            <!-- Check if there are items in the cart -->
            @if(isset($cartItems) && $cartItems->count() > 0)
                <div class="cart-list">
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <div class="item-info">
                                <!-- Relationship from Cart.php model -->
                                <img src="{{ asset('storage/' . $item->product->image) }}" width="60" style="border-radius: 10px;">
                                <div class="item-details">
                                    <h4>{{ $item->product->name }}</h4>
                                    <p>₱{{ number_format($item->product->price, 2) }}</p>
                                </div>
                            </div>
                            <div class="item-qty">
                                <span>Qty: {{ $item->quantity }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="checkout-btn">Proceed to Checkout</button>
            @else
                <!-- Show this ONLY if cart is empty -->
                <div class="empty">
                    Your cart is currently empty.
                </div>
            @endif

            <a href="{{ route('buyer.home') }}" class="back-btnbuyer">
                ← Back to Shop
            </a>
        </div>
    </div>
</x-buyerDash>
=======
<x-layout>
@section('title', 'My Cart - CraveCart')

@section('content')
<section class="page-container">
    <h1 class="page-title">🛒 My Cart</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    

    @if(count($cartItems) > 0)
        <div class="cart-container">
            {{-- Cart Items --}}
            <div class="cart-items">
                @foreach($cartItems as $item)
                <div class="cart-item">
                    <img src="{{ $item->product->image ?? '/images/placeholder.jpg' }}" alt="{{ $item->product->name }}">
                    
                    <div class="item-details">
                        <h3>{{ $item->product->name }}</h3>
                        <p class="item-price">₱{{ number_format($item->product->price, 2) }}</p>
                    </div>

                    <div class="item-quantity">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="qty-btn" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                            <span class="qty-number">{{ $item->quantity }}</span>
                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="qty-btn">+</button>
                        </form>
                    </div>

                    <div class="item-total">
                        <p>₱{{ number_format($item->product->price * $item->quantity, 2) }}</p>
                    </div>

                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="remove-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="remove-btn">🗑️</button>
                    </form>
                </div>
                @endforeach
            </div>

            {{-- Cart Summary --}}
            <div class="cart-summary">
                <h3>Order Summary</h3>
                
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($subtotal, 2) }}</span>
                </div>
                
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>₱{{ number_format($shipping, 2) }}</span>
                </div>
                
                <div class="summary-row">
                    <span>Tax (12%)</span>
                    <span>₱{{ number_format($tax, 2) }}</span>
                </div>

                <div class="summary-row total">
                    <span><strong>Total</strong></span>
                    <span><strong>₱{{ number_format($total, 2) }}</strong></span>
                </div>

                <a href="{{ route('checkout') }}" class="btn btn-primary" style="width: 100%; margin-top: 20px; display: block; text-align: center;">
                    Proceed to Checkout
                </a>

                <a href="{{ route('buyer.home') }}" class="forlinks" style="display: block; text-align: center; margin-top: 15px;">
                    ← Continue Shopping
                </a>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <div class="empty-cart-icon">🛒</div>
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('buyer.home') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @endif
</section>

<style>
.cart-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.cart-items {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.cart-item {
    display: flex;
    align-items: center;
    gap: 20px;
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.cart-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
}

.item-details {
    flex: 1;
}

.item-details h3 {
    margin: 0 0 5px 0;
    color: #1f2937;
    font-size: 1.1rem;
}

.item-price {
    color: var(--red);
    font-weight: bold;
    font-size: 1.1rem;
    margin: 0;
}

.item-quantity {
    display: flex;
    align-items: center;
}

.qty-btn {
    width: 35px;
    height: 35px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-btn:hover {
    background: var(--cream);
}

.qty-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.qty-number {
    width: 40px;
    text-align: center;
    font-weight: bold;
}

.item-total p {
    font-weight: bold;
    color: var(--red);
    font-size: 1.2rem;
    margin: 0;
}

.remove-btn {
    background: none;
    border: none;
    font-size: 1.3rem;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: 0.2s;
}

.remove-btn:hover {
    background: #fee2e2;
}

.cart-summary {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    height: fit-content;
    position: sticky;
    top: 100px;
}

.cart-summary h3 {
    margin-top: 0;
    color: var(--red);
    border-bottom: 2px solid var(--cream);
    padding-bottom: 15px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.summary-row.total {
    border-bottom: none;
    border-top: 2px solid var(--red);
    margin-top: 10px;
    padding-top: 15px;
    font-size: 1.2rem;
    color: var(--red);
}

.empty-cart {
    text-align: center;
    padding: 60px 20px;
}

.empty-cart-icon {
    font-size: 4rem;
    margin-bottom: 20px;
}

.empty-cart h2 {
    color: var(--red);
    margin-bottom: 10px;
}

.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

@media (max-width: 768px) {
    .cart-container {
        grid-template-columns: 1fr;
    }
    
    .cart-item {
        flex-wrap: wrap;
    }
}
</style>
@endsection
</x-layout>
>>>>>>> origin/Kino

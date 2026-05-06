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
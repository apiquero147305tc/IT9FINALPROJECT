<x-buyerDash>

<div style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #333; margin-bottom: 10px;">🛒 My Cart</h2>
    <p style="color: #666; margin-bottom: 30px;">Review your items before checkout</p>

    @if($cartItems->isEmpty())
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 4rem; margin-bottom: 20px;">🛒</div>
            <h3 style="color: #666;">Your Cart is Empty</h3>
            <p style="color: #999;">Browse products and add them to your cart.</p>
            <a href="{{ route('buyer.home') }}" 
               style="display: inline-block; margin-top: 15px; padding: 12px 25px; background: #dd0d22; color: white; text-decoration: none; border-radius: 25px; font-weight: bold;">
                Browse Products
            </a>
        </div>
    @else
        <div style="display: grid; gap: 15px; margin-bottom: 30px;">
            @foreach($cartItems as $item)
                <div style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; gap: 20px; align-items: center;">

                    <div style="flex-shrink: 0;">
                        @if($item->product->images && $item->product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->product->images[0]->image_path) }}" 
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                        @else
                            <div style="width: 100px; height: 100px; background: #f3e3cb; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                📦
                            </div>
                        @endif
                    </div>

                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 5px 0; color: #333;">{{ $item->product->name }}</h3>
                        <p style="margin: 0; color: #666; font-size: 0.9rem;">
                            🏪 {{ $item->product->user->shop_name ?? $item->product->user->name }}
                        </p>
                        <p style="margin: 5px 0 0 0; color: #dd0d22; font-weight: bold; font-size: 1.1rem;">
                            ₱{{ number_format($item->product->price, 2) }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px;">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: flex; align-items: center; gap: 8px;">
                            @csrf
                            @method('PATCH')

                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}"
                                    style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #ddd; background: white; cursor: pointer; font-weight: bold; color: #666;">
                                −
                            </button>

                            <span style="font-weight: bold; color: #333; min-width: 30px; text-align: center;">
                                {{ $item->quantity }}
                            </span>

                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                    style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #ddd; background: white; cursor: pointer; font-weight: bold; color: #666;">
                                +
                            </button>
                        </form>
                    </div>

                    <div style="text-align: right; min-width: 100px;">
                        <p style="margin: 0; color: #dd0d22; font-weight: bold; font-size: 1.1rem;">
                            ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                        </p>
                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST" style="margin-top: 8px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 0.85rem; text-decoration: underline;">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h3 style="margin: 0; color: #333;">Cart Summary</h3>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9rem;">{{ $cartItems->count() }} item(s)</p>
                </div>
                <div style="text-align: right;">
                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Total</p>
                    <p style="margin: 0; color: #dd0d22; font-size: 1.5rem; font-weight: bold;">
                        ₱{{ number_format($total, 2) }}
                    </p>
                </div>
            </div>

            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" 
                        style="width: 100%; padding: 15px; background: #dd0d22; color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: bold; cursor: pointer;">
                    🛒 Proceed to Checkout
                </button>
            </form>

            <a href="{{ route('buyer.home') }}" 
               style="display: block; text-align: center; margin-top: 15px; color: #dd0d22; text-decoration: none; font-weight: bold;">
                ← Continue Shopping
            </a>
        </div>
    @endif
</div>

</x-buyerDash>
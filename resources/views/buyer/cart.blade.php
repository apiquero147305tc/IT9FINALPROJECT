<x-buyerDash>

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">

    <h1 style="color: #dd0d22; margin-bottom: 25px;">🛒 My Cart</h1>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cartItems) > 0)
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            
            {{-- Cart Items --}}
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @foreach($cartItems as $item)
                <div style="display: flex; align-items: center; gap: 20px; background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                    
                    <img src="{{ $item->product->image ?? '/images/placeholder.jpg' }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                    
                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 5px; color: #1f2937; font-size: 1.1rem;">{{ $item->product->name }}</h3>
                        <p style="color: #dd0d22; font-weight: bold; font-size: 1.1rem; margin: 0;">₱{{ number_format($item->product->price, 2) }}</p>
                    </div>

                    <div style="display: flex; align-items: center; gap: 5px;">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" style="width: 35px; height: 35px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer;" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                            <span style="width: 40px; text-align: center; display: inline-block; font-weight: bold;">{{ $item->quantity }}</span>
                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" style="width: 35px; height: 35px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer;">+</button>
                        </form>
                    </div>

                    <div style="font-weight: bold; color: #dd0d22; font-size: 1.2rem;">
                        ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                    </div>

                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; font-size: 1.3rem; cursor: pointer; padding: 5px;">🗑️</button>
                    </form>
                </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); height: fit-content; position: sticky; top: 100px;">
                <h3 style="color: #dd0d22; margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #f3e3cb;">Order Summary</h3>
                
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee;">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($subtotal, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee;">
                    <span>Shipping</span>
                    <span>₱{{ number_format($shipping, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee;">
                    <span>Tax (12%)</span>
                    <span>₱{{ number_format($tax, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #dd0d22; margin-top: 10px; font-size: 1.2rem; color: #dd0d22; font-weight: bold;">
                    <span>Total</span>
                    <span>₱{{ number_format($total, 2) }}</span>
                </div>

                <a href="{{ route('checkout') }}" style="display: block; width: 100%; background: linear-gradient(to right, #dd0d22, #ff6a00); color: white; text-align: center; padding: 15px; border-radius: 25px; text-decoration: none; font-weight: bold; margin-top: 20px;">
                    Proceed to Checkout
                </a>

                <a href="{{ route('buyer.home') }}" style="display: block; text-align: center; margin-top: 15px; color: #dd0d22;">
                    ← Continue Shopping
                </a>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 15px;">
            <div style="font-size: 4rem; margin-bottom: 20px;">🛒</div>
            <h2 style="color: #dd0d22; margin-bottom: 10px;">Your cart is empty</h2>
            <p style="color: #666; margin-bottom: 20px;">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('buyer.home') }}" style="display: inline-block; background: linear-gradient(to right, #dd0d22, #ff6a00); color: white; padding: 12px 30px; border-radius: 25px; text-decoration: none; font-weight: bold;">
                Start Shopping
            </a>
        </div>
    @endif

</div>

</x-buyerDash>
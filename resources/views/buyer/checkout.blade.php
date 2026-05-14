<x-buyerDash>

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">

    <h1 style="color: #dd0d22; margin-bottom: 25px;">💳 Checkout</h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
        
        {{-- Order Summary --}}
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); height: fit-content; position: sticky; top: 100px;">
            <h3 style="color: #dd0d22; margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #f3e3cb;">📦 Order Summary</h3>
            
            @foreach($cartItems as $item)
            <div style="display: flex; align-items: center; gap: 15px; padding: 15px 0; border-bottom: 1px solid #eee;">
                <img src="{{ $item->product->image ?? '/images/placeholder.jpg' }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                <div style="flex: 1;">
                    <h4 style="margin: 0 0 5px 0; font-size: 0.95rem;">{{ $item->product->name }}</h4>
                    <p style="margin: 0; color: #666; font-size: 0.85rem;">Qty: {{ $item->quantity }} × ₱{{ number_format($item->product->price, 2) }}</p>
                </div>
                <div style="font-weight: bold; color: #dd0d22;">₱{{ number_format($item->product->price * $item->quantity, 2) }}</div>
            </div>
            @endforeach

            <div style="margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($subtotal, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                    <span>Shipping</span>
                    <span>₱{{ number_format($shipping, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                    <span>Tax (12%)</span>
                    <span>₱{{ number_format($tax, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #dd0d22; margin-top: 10px; font-size: 1.2rem; color: #dd0d22; font-weight: bold;">
                    <span><strong>Total</strong></span>
                    <span><strong>₱{{ number_format($total, 2) }}</strong></span>
                </div>
            </div>
        </div>

        {{-- Checkout Form --}}
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                {{-- Delivery Address --}}
                <div style="margin-bottom: 30px;">
                    <h3 style="color: #dd0d22; margin-bottom: 20px; font-size: 1.1rem;">📍 Delivery Address</h3>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #4b5563;">Full Name</label>
                        <input type="text" name="full_name" value="{{ auth()->user()->name }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #4b5563;">Phone Number</label>
                        <input type="tel" name="phone" placeholder="09XX XXX XXXX" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #4b5563;">Address</label>
                        <textarea name="address" rows="3" placeholder="Street, Barangay, City" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; resize: vertical;"></textarea>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #4b5563;">Zip Code</label>
                        <input type="text" name="zip_code" placeholder="1000" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px;">
                    </div>
                </div>

                {{-- Payment Method --}}
                <div style="margin-bottom: 30px;">
                    <h3 style="color: #dd0d22; margin-bottom: 20px; font-size: 1.1rem;">💰 Payment Method</h3>
                    
                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px; border: 2px solid #eee; border-radius: 12px; margin-bottom: 10px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="cod" checked style="width: auto;">
                        <div>
                            <strong>Cash on Delivery</strong>
                            <p style="margin: 0; font-size: 0.85rem; color: #666;">Pay when you receive</p>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px; border: 2px solid #eee; border-radius: 12px; margin-bottom: 10px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="gcash" style="width: auto;">
                        <div>
                            <strong>GCash</strong>
                            <p style="margin: 0; font-size: 0.85rem; color: #666;">Pay via GCash e-wallet</p>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px; border: 2px solid #eee; border-radius: 12px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="maya" style="width: auto;">
                        <div>
                            <strong>Maya</strong>
                            <p style="margin: 0; font-size: 0.85rem; color: #666;">Pay via Maya</p>
                        </div>
                    </label>
                </div>

                <button type="submit" style="width: 100%; background: linear-gradient(to right, #dd0d22, #ff6a00); color: white; border: none; padding: 15px; border-radius: 25px; cursor: pointer; font-weight: bold; font-size: 1.1rem;">
                    Place Order (₱{{ number_format($total, 2) }})
                </button>

                <a href="{{ route('cart.index') }}" style="display: block; text-align: center; margin-top: 15px; color: #dd0d22;">
                    ← Back to Cart
                </a>
            </form>
        </div>
    </div>

</div>

</x-buyerDash>
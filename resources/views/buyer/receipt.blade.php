<x-buyerDash>

<div style="max-width: 600px; margin: 0 auto; padding: 20px;">

    {{-- Success Header --}}
    <div style="text-align: center; margin-bottom: 30px;">
        <div style="font-size: 4rem; margin-bottom: 15px;">✅</div>
        <h1 style="color: #dd0d22; margin: 0 0 10px 0;">Order Placed Successfully!</h1>
        <p style="color: #666; margin: 0;">Thank you for shopping with CraveCart</p>
    </div>

    {{-- Receipt Card --}}
    <div style="background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="font-size: 1.3rem; font-weight: bold; color: #dd0d22;">🛒 CraveCart</div>
            <div style="background: #d4edda; color: #155724; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 0.85rem;">PAID</div>
        </div>

        <div style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #eee;">
                <span style="color: #666;">Order ID:</span>
                <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #eee;">
                <span style="color: #666;">Date:</span>
                <strong>{{ $order->created_at->format('F d, Y h:i A') }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #eee;">
                <span style="color: #666;">Payment:</span>
                <strong>{{ ucfirst($order->payment_method) }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                <span style="color: #666;">Status:</span>
                <span style="padding: 3px 10px; border-radius: 15px; font-size: 0.8rem; font-weight: bold; background: #fff3cd; color: #856404;">{{ ucfirst($order->status) }}</span>
            </div>
        </div>

        <div style="height: 1px; background: linear-gradient(to right, transparent, #ddd, transparent); margin: 20px 0;"></div>

        {{-- Items --}}
        <div style="margin: 20px 0;">
            <h4 style="color: #dd0d22; margin-bottom: 15px;">Order Items</h4>
            @foreach($order->items as $item)
            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f5f5f5;">
                <div style="font-weight: 500;">
                    {{ $item->product_name }}
                    <span style="color: #666; font-size: 0.9rem;">× {{ $item->quantity }}</span>
                </div>
                <div style="font-weight: bold; color: #dd0d22;">₱{{ number_format($item->price * $item->quantity, 2) }}</div>
            </div>
            @endforeach
        </div>

        <div style="height: 1px; background: linear-gradient(to right, transparent, #ddd, transparent); margin: 20px 0;"></div>

        {{-- Totals --}}
        <div style="margin: 20px 0;">
            <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                <span>Subtotal</span>
                <span>₱{{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                <span>Shipping</span>
                <span>₱{{ number_format($order->shipping, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                <span>Tax</span>
                <span>₱{{ number_format($order->tax, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #dd0d22; margin-top: 10px; font-size: 1.2rem; color: #dd0d22; font-weight: bold;">
                <span><strong>TOTAL</strong></span>
                <span><strong>₱{{ number_format($order->total, 2) }}</strong></span>
            </div>
        </div>

        <div style="height: 1px; background: linear-gradient(to right, transparent, #ddd, transparent); margin: 20px 0;"></div>

        {{-- Delivery Info --}}
        <div>
            <h4 style="color: #dd0d22; margin-bottom: 15px;">📍 Delivery Address</h4>
            <p style="margin: 5px 0; color: #555;"><strong>{{ $order->full_name }}</strong></p>
            <p style="margin: 5px 0; color: #555;">{{ $order->phone }}</p>
            <p style="margin: 5px 0; color: #555;">{{ $order->address }}</p>
            <p style="margin: 5px 0; color: #555;">{{ $order->zip_code }}</p>
        </div>
    </div>

    {{-- Actions --}}
    <div style="display: flex; gap: 15px; justify-content: center;">
        <button onclick="window.print()" style="background: linear-gradient(to right, #dd0d22, #ff6a00); color: white; border: none; padding: 12px 25px; border-radius: 25px; cursor: pointer; font-weight: bold;">
            🖨️ Print Receipt
        </button>
        <a href="{{ route('buyer.home') }}" style="background: #f3e3cb; color: #dd0d22; border: none; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: bold;">
            Continue Shopping
        </a>
    </div>

</div>

</x-buyerDash>
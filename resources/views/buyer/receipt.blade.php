<x-layout>
    <x-buyerDash>
@section('title', 'Order Receipt - CraveCart')

@section('content')
<section class="page-container">
    <div class="receipt-container">
        {{-- Success Header --}}
        <div class="receipt-header">
            <div class="success-icon">✅</div>
            <h1>Order Placed Successfully!</h1>
            <p>Thank you for shopping with CraveCart</p>
        </div>

        {{-- Receipt Card --}}
        <div class="receipt-card">
            <div class="receipt-top">
                <div class="receipt-logo">🛒 CraveCart</div>
                <div class="receipt-status">PAID</div>
            </div>

            <div class="receipt-info">
                <div class="info-row">
                    <span>Order ID:</span>
                    <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </div>
                <div class="info-row">
                    <span>Date:</span>
                    <strong>{{ $order->created_at->format('F d, Y h:i A') }}</strong>
                </div>
                <div class="info-row">
                    <span>Payment:</span>
                    <strong>{{ ucfirst($order->payment_method) }}</strong>
                </div>
                <div class="info-row">
                    <span>Status:</span>
                    <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
            </div>

            <div class="receipt-divider"></div>

            {{-- Items --}}
            <div class="receipt-items">
                <h4>Order Items</h4>
                @foreach($order->items as $item)
                <div class="receipt-item">
                    <div class="item-name">
                        {{ $item->product_name }}
                        <span class="item-qty">× {{ $item->quantity }}</span>
                    </div>
                    <div class="item-price">₱{{ number_format($item->price * $item->quantity, 2) }}</div>
                </div>
                @endforeach
            </div>

            <div class="receipt-divider"></div>

            {{-- Totals --}}
            <div class="receipt-totals">
                <div class="total-line">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="total-line">
                    <span>Shipping</span>
                    <span>₱{{ number_format($order->shipping, 2) }}</span>
                </div>
                <div class="total-line">
                    <span>Tax</span>
                    <span>₱{{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="total-line grand">
                    <span><strong>TOTAL</strong></span>
                    <span><strong>₱{{ number_format($order->total, 2) }}</strong></span>
                </div>
            </div>

            <div class="receipt-divider"></div>

            {{-- Delivery Info --}}
            <div class="receipt-delivery">
                <h4>📍 Delivery Address</h4>
                <p><strong>{{ $order->full_name }}</strong></p>
                <p>{{ $order->phone }}</p>
                <p>{{ $order->address }}</p>
                <p>{{ $order->zip_code }}</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="receipt-actions">
            <button onclick="window.print()" class="btn btn-primary">🖨️ Print Receipt</button>
            <a href="{{ route('buyer.home') }}" class="btn" style="background: var(--cream); color: var(--red);">Continue Shopping</a>
        </div>
    </div>
</section>

<style>
.receipt-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.receipt-header {
    text-align: center;
    margin-bottom: 30px;
}

.success-icon {
    font-size: 4rem;
    margin-bottom: 15px;
}

.receipt-header h1 {
    color: var(--red);
    margin: 0 0 10px 0;
}

.receipt-header p {
    color: #666;
    margin: 0;
}

.receipt-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 30px;
    margin-bottom: 30px;
}

.receipt-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.receipt-logo {
    font-size: 1.3rem;
    font-weight: bold;
    color: var(--red);
}

.receipt-status {
    background: #d4edda;
    color: #155724;
    padding: 5px 15px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.85rem;
}

.receipt-info {
    margin-bottom: 20px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px dashed #eee;
}

.info-row span:first-child {
    color: #666;
}

.status-badge {
    padding: 3px 10px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: bold;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-completed {
    background: #d4edda;
    color: #155724;
}

.receipt-divider {
    height: 1px;
    background: linear-gradient(to right, transparent, #ddd, transparent);
    margin: 20px 0;
}

.receipt-items h4,
.receipt-delivery h4 {
    color: var(--red);
    margin-bottom: 15px;
}

.receipt-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f5f5f5;
}

.item-name {
    font-weight: 500;
}

.item-qty {
    color: #666;
    font-size: 0.9rem;
}

.item-price {
    font-weight: bold;
    color: var(--red);
}

.receipt-totals {
    margin: 20px 0;
}

.total-line {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
}

.total-line.grand {
    border-top: 2px solid var(--red);
    margin-top: 10px;
    padding-top: 15px;
    font-size: 1.2rem;
    color: var(--red);
}

.receipt-delivery p {
    margin: 5px 0;
    color: #555;
}

.receipt-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
}

.receipt-actions .btn {
    padding: 12px 25px;
}

@media print {
    .navbar, .footer, .receipt-actions {
        display: none !important;
    }
    
    .receipt-card {
        box-shadow: none;
        border: 1px solid #ddd;
    }
}
</style>
@endsection
    </x-buyerDash>
</x-layout>
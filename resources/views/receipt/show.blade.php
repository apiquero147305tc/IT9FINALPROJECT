@extends('layouts.app')

@section('title', 'Order Receipt')

@section('content')
<div class="receipt-container" style="max-width: 600px; margin: 40px auto; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">

    <div style="text-align: center; border-bottom: 2px dashed #ddd; padding-bottom: 20px; margin-bottom: 30px;">
        <h1 style="color: #dd0d22; margin: 0;">🧾 CraveCart</h1>
        <p style="color: #666; margin: 5px 0;">Official Receipt</p>
        <p style="color: #999; font-size: 0.9rem;">{{ $order->created_at->format('F d, Y h:i A') }}</p>
    </div>

    <div style="margin-bottom: 25px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span style="color: #666;">Order ID:</span>
            <span style="font-weight: bold;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span style="color: #666;">Status:</span>
            <span style="
                padding: 3px 10px;
                border-radius: 12px;
                font-size: 0.85rem;
                font-weight: bold;
                @if($order->status == 'pending') background: #fff3cd; color: #856404;
                @elseif($order->status == 'accepted') background: #d4edda; color: #155724;
                @elseif($order->status == 'completed') background: #cce5ff; color: #004085;
                @elseif($order->status == 'declined') background: #f8d7da; color: #721c24;
                @else background: #e2e3e5; color: #383d41; @endif
            ">{{ ucfirst($order->status) }}</span>
        </div>
    </div>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
        <h3 style="margin-top: 0; color: #333;">Product Details</h3>

        @if($order->product->images && $order->product->images->isNotEmpty())
            <img src="{{ asset('storage/' . $order->product->images[0]->image_path) }}" 
                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
        @endif

        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span style="color: #666;">Product:</span>
            <span style="font-weight: bold;">{{ $order->product->name }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span style="color: #666;">Shop:</span>
            <span>{{ $order->product->user->shop_name ?? $order->product->user->name }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span style="color: #666;">Unit Price:</span>
            <span>₱{{ number_format($order->product->price, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span style="color: #666;">Quantity:</span>
            <span>{{ $order->quantity }}</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px;">
            <h4 style="margin-top: 0; color: #333; font-size: 0.9rem;">👤 Buyer</h4>
            <p style="margin: 5px 0; color: #555;">{{ $order->user->name }}</p>
            <p style="margin: 5px 0; color: #777; font-size: 0.85rem;">{{ $order->user->email }}</p>
        </div>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px;">
            <h4 style="margin-top: 0; color: #333; font-size: 0.9rem;">🏪 Seller</h4>
            <p style="margin: 5px 0; color: #555;">{{ $order->product->user->name }}</p>
            <p style="margin: 5px 0; color: #777; font-size: 0.85rem;">{{ $order->product->user->shop_name ?? 'No shop name' }}</p>
        </div>
    </div>

    <div style="border-top: 2px solid #ddd; padding-top: 20px; margin-bottom: 25px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span style="color: #666;">Subtotal:</span>
            <span>₱{{ number_format($order->total_price, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span style="color: #666;">Shipping:</span>
            <span style="color: #28a745;">Free</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold; color: #dd0d22;">
            <span>Total:</span>
            <span>₱{{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    <div style="display: flex; gap: 10px; justify-content: center;">
        <button onclick="window.print()" 
                style="padding: 10px 25px; background: #dd0d22; color: white; border: none; border-radius: 25px; cursor: pointer; font-weight: bold;">
            🖨️ Print Receipt
        </button>

        @if($isBuyer)
            <a href="{{ route('buyer.orders') }}" 
               style="padding: 10px 25px; background: #f3e3cb; color: #dd0d22; border-radius: 25px; text-decoration: none; font-weight: bold;">
                ← My Orders
            </a>
        @elseif($isSeller)
            <a href="{{ route('seller.orders') }}" 
               style="padding: 10px 25px; background: #f3e3cb; color: #dd0d22; border-radius: 25px; text-decoration: none; font-weight: bold;">
                ← Order Hub
            </a>
        @endif
    </div>

    <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px dashed #ddd;">
        <p style="color: #999; font-size: 0.85rem; margin: 0;">Thank you for using CraveCart!</p>
        <p style="color: #bbb; font-size: 0.75rem; margin: 5px 0;">This is a computer-generated receipt.</p>
    </div>
</div>

<style>
    @media print {
        body { background: white; }
        .receipt-container { box-shadow: none; margin: 0; max-width: 100%; }
        button, a { display: none !important; }
    }
</style>
@endsection
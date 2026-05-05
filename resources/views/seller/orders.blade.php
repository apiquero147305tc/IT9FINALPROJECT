<!DOCTYPE html>
<html>
<head>
    <title>Orders | Seller</title>

    <style>
        body {
            font-family: sans-serif;
            background: #f3e3cb;
            margin: 0;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }

        h2 {
            color: #dd0d22;
        }

        .status {
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 12px;
            background: #eee;
        }

        /* ✅ BACK BUTTON */
        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 12px;
            background: #dd0d22;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
        }

        .back-btn:hover {
            background: #ff4a00;
        }
    </style>
</head>
<body>

<!-- ✅ BACK BUTTON -->
<a href="{{ route('seller.dash') }}" class="back-btn">
    ← Back to Dashboard
</a>

<h2>All Orders</h2>

@forelse($orders as $order)
    <div class="card">

        <p><strong>Customer:</strong> {{ $order->user->name ?? 'Unknown' }}</p>
        <p><strong>Product:</strong> {{ $order->product->name ?? 'Deleted Product' }}</p>
        <p><strong>Total:</strong> ₱{{ number_format($order->total_price, 2) }}</p>

        <p>
            <strong>Status:</strong>
            <span class="status">{{ ucfirst($order->status) }}</span>
        </p>

        <small>{{ $order->created_at->diffForHumans() }}</small>

    </div>
@empty
    <p>No orders yet.</p>
@endforelse

</body>
</html>
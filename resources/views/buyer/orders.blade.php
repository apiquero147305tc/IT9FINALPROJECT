<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - CraveCart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #dd0d22 0%, #ff6b35 50%, #ff8c42 100%);
            padding: 40px 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 30px;
        }
        .order-item {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .order-info h4 {
            color: #333;
            margin-bottom: 5px;
        }
        .order-info p {
            color: #666;
            font-size: 0.85rem;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-accepted { background: #d4edda; color: #155724; }
        .status-completed { background: #d1ecf1; color: #0c5460; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .empty-state p {
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            color: #dd0d22;
            border: 2px solid #dd0d22;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #fff5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>📦 My Orders</h1>

            @forelse($orders as $order)
                <div class="order-item">
                    <div class="order-info">
                        <h4>{{ $order->product->name ?? 'Unknown Product' }}</h4>
                                                <p>Seller: {{ $order->product->user->shop_name ?? $order->product->user->name ?? 'Unknown' }}</p>
                        <p>Quantity: {{ $order->quantity ?? 1 }} | Total: ₱{{ number_format($order->total_price ?? 0, 2) }}</p>
                        <p>Ordered: {{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <span class="status-badge status-{{ $order->status ?? 'pending' }}">
                        {{ ucfirst($order->status ?? 'pending') }}
                    </span>
                </div>
            @empty
                <div class="empty-state">
                    <h3>No orders yet</h3>
                    <p>Your order history will appear here.</p>
                    <a href="{{ route('buyer.home') }}" class="btn">Browse Products</a>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>
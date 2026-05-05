<!DOCTYPE html>
<html>
<head>
    <title>Seller Studio | CraveCart</title>
    <style>
        body { background: #f3e3cb; font-family: sans-serif; margin: 0; padding: 20px; }
        .nav { background: #dd0d22; color: white; padding: 15px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; }
        .container { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: 20px; }
        .card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .stat-card { background: #ff4a00; color: white; padding: 15px; border-radius: 10px; text-align: center; }
        
        h2 { color: #dd0d22; margin-top: 0; font-size: 1.2rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; background: #ff9b9e; color: white; padding: 10px; font-size: 0.9rem; }
        td { padding: 10px; border-bottom: 1px solid #eee; font-size: 0.9rem; }
        
        .btn-add { background: #dd0d22; color:white; border:none; padding:10px 15px; border-radius:5px; cursor:pointer; margin-bottom:15px; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-edit { background: #ff4a00; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 0.8rem; }
        .badge { background: #f3e3cb; padding: 3px 8px; border-radius: 5px; font-size: 0.75rem; color: #555; }
        .order-item { border-left: 3px solid #ff4a00; padding: 10px; margin-bottom: 10px; background: #fffcf9; border-radius: 0 5px 5px 0; }
        .order-item p { margin: 2px 0; font-size: 0.85rem; }
    </style>
</head>
<body>

    <div class="nav">
        <strong>CraveCart Seller Studio</strong>
        <div>
            <span>Welcome, <b>{{ Auth::user()->name }}</b></span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left:15px;">
                @csrf
                <button type="submit" style="background:none; border:1px solid white; color:white; cursor:pointer; padding: 5px 10px; border-radius: 5px;">Logout</button>
            </form>
        </div>
    </div>

  <div class="container">
    <div class="main-content">

        <div class="stats-grid">
            <div class="stat-card">
                <small>Total Products</small>
                <h3>{{ $products->count() }}</h3>
            </div>

            <div class="stat-card" style="background: #dd0d22;">
                <small>Total Earnings</small>
                <h3>₱{{ number_format($totalEarnings, 2) }}</h3>
            </div>
        </div>

        <div class="card">
            <h2>My Inventory</h2>

            <a href="{{ route('products.create') }}" class="btn-add">
                + Add New Product
            </a>

            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         width="45"
                                         height="45"
                                         style="border-radius:5px; object-fit:cover;">
                                @else
                                    <div style="width:45px; height:45px; background:#eee; border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#999;">
                                        No Img
                                    </div>
                                @endif
                            </td>

                            <td><b>{{ $product->name }}</b></td>
                            <td><span class="badge">{{ $product->category }}</span></td>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }} pcs</td>

                            <td>
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="btn-edit">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"
                                style="text-align:center; padding:30px; color:#999;">
                                No products found. Start adding your items!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="sidebar">
        <div class="card">
            <h2>Recent Orders</h2>

            @forelse($orders as $order)
                <div class="order-item">
                    <p><strong>Customer:</strong> {{ $order->user->name ?? 'Unknown' }}</p>
                    <p><strong>Item:</strong> {{ $order->product->name ?? 'Deleted Product' }}</p>
                    <p><strong>Total:</strong> ₱{{ number_format($order->total_price, 2) }}</p>
                    <small style="color:#888;">
                        {{ $order->created_at->diffForHumans() }}
                    </small>
                </div>
            @empty
                <p style="color:#666; text-align:center; padding:20px;">
                    No orders yet. Keep promoting!
                </p>
            @endforelse

            @if($orders->count())
                <a href="{{ route('seller.orders') }}"
                   style="display:block; text-align:center; font-size:0.8rem; color:#dd0d22; text-decoration:none; margin-top:10px;">
                    View All Orders →
                </a>
            @endif
        </div>
    </div>
</div>

<x-messui/>

</body>
</html>
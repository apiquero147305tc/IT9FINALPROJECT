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
    <div>
    <strong>🏪 {{ Auth::user()->shop_name ?? Auth::user()->name }}</strong><br>
    <small style="opacity:0.8;">Seller Dashboard</small>
    </div>

    <div style="display:flex; align-items:center; gap:15px;">
        <a href="{{ route('messages.inbox') }}"
   style="
        display:inline-block;
        background:#dd0d22;
        color:white;
        padding:8px 14px;
        border-radius:8px;
        text-decoration:none;
        font-weight:bold;
        position:relative;
   ">
    💬 Messages

    @if(isset($notifCount) && $notifCount > 0)
        <span style="
            position:absolute;
            top:-5px;
            right:-8px;
            background:white;
            color:#dd0d22;
            font-size:10px;
            padding:2px 5px;
            border-radius:50%;
            font-weight:bold;
        ">
            {{ $notifCount }}
        </span>
    @endif
</a>

        {{-- 🔔 NOTIFICATION BELL --}}
        <a href="{{ route('seller.orders') }}" style="color:white; text-decoration:none; position:relative; display:inline-block;">
            🔔

            @if($notifCount > 0)
                <span class="badge"
                      style="
                        position:absolute;
                        top:-6px;
                        right:-10px;
                        background:white;
                        color:#dd0d22;
                        border-radius:50%;
                        font-size:11px;
                        padding:2px 6px;
                        font-weight:bold;
                      ">
                    {{ $notifCount }}
                </span>
            @endif
        </a>

        {{-- USER INFO --}}
        <span>Welcome, <b>{{ Auth::user()->name }}</b></span>

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit"
                style="background:none; border:1px solid white; color:white; cursor:pointer; padding: 5px 10px; border-radius: 5px;">
                Logout
            </button>
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

    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:15px; margin-top:15px;">

        @forelse($products as $product)
            <div style="background:white; border-radius:15px; padding:15px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

                {{-- IMAGE --}}
                @if($product->images && $product->images->count() > 0)
                    <img src="{{ asset('storage/' . $product->images[0]->image_path) }}"
                         style="width:100%; height:120px; object-fit:cover; border-radius:10px;">
                @elseif($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         style="width:100%; height:120px; object-fit:cover; border-radius:10px;">
                @else
                    <div style="width:100%; height:120px; background:#eee; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#999;">
                        No Image
                    </div>
                @endif

                {{-- PRODUCT INFO --}}
                <h4 style="margin:10px 0 5px;">{{ $product->name }}</h4>

                <p style="margin:0; color:#dd0d22; font-weight:bold;">
                    ₱{{ number_format($product->price, 2) }}
                </p>

                <p style="margin:5px 0; font-size:12px; color:#666;">
                    {{ $product->category }}
                </p>

                <p style="margin:5px 0; font-size:12px;">
                    Stock: {{ $product->stock }} pcs
                </p>

                {{-- ACTION --}}
                <a href="{{ route('products.edit', $product->id) }}"
                   style="display:block; text-align:center; margin-top:10px; background:#ff4a00; color:white; padding:8px; border-radius:8px; text-decoration:none;">
                    Edit Product
                </a>

            </div>
        @empty
            <div style="grid-column:1/-1; text-align:center; padding:30px; color:#999;">
                No products found. Start adding your items!
            </div>
        @endforelse

    </div>
</div>

    <div class="sidebar">
    <div class="card">
        <h2>Recent Orders</h2>

        @forelse($orders as $order)
            <div class="order-item"
                 style="
                    border-left: 4px solid #ff4a00;
                    padding: 12px;
                    margin-bottom: 12px;
                    background: #fffaf6;
                    border-radius: 8px;
                    transition: 0.2s;
                 "
                 onmouseover="this.style.transform='scale(1.01)'"
                 onmouseout="this.style.transform='scale(1)'">

                <p style="margin:4px 0;">
                    <strong>👤 Customer:</strong>
                    {{ $order->user->name ?? 'Unknown' }}
                </p>

                <p style="margin:4px 0;">
                    <strong>📦 Item:</strong>
                    {{ $order->product->name ?? 'Deleted Product' }}
                </p>

                <p style="margin:4px 0; color:#dd0d22;">
                    <strong>💰 Total:</strong>
                    ₱{{ number_format($order->total_price, 2) }}
                </p>

                <p style="margin:4px 0;">
                    <strong>Status:</strong>
                    <span class="
                    status
                    @if($order->status == 'completed') status-completed
                    @elseif($order->status == 'cancelled') status-cancelled
                    @else status-pending
                    @endif
                ">
                    {{ ucfirst($order->status) }}
                </span>
                </p>

                <small style="color:#888;">
                    🕒 {{ $order->created_at->diffForHumans() }}
                </small>

            </div>
        @empty
            <div style="text-align:center; padding:25px;">
                <p style="color:#999; font-size:0.9rem;">
                    📭 No orders yet.<br>
                    Keep promoting your products!
                </p>
            </div>
        @endforelse

        @if($orders->count())
            <a href="{{ route('seller.orders') }}"
               style="
                    display:block;
                    text-align:center;
                    font-size:0.85rem;
                    color:#dd0d22;
                    text-decoration:none;
                    margin-top:10px;
                    font-weight:bold;
               ">
                View All Orders →
            </a>
        @endif

    </div>
</div>

<x-messui/>

</body>
</html>
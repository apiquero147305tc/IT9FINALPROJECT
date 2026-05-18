<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lending Management - CraveCart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #dd0d22 0%, #ff6b35 50%, #ff8c42 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .header h1 {
            color: #333;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .header p {
            color: #666;
            margin-top: 5px;
        }
        .btn {
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }
        .btn-primary {
            background: #dd0d22;
            color: white;
            box-shadow: 0 4px 15px rgba(221,13,34,0.3);
        }
        .btn-primary:hover {
            background: #b30b1b;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: white;
            color: #dd0d22;
            border: 2px solid #dd0d22;
        }
        .btn-secondary:hover {
            background: #fff5f5;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            text-align: center;
        }
        .stat-card .icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .stat-card h3 {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        .stat-card .number {
            color: #dd0d22;
            font-size: 2rem;
            font-weight: 700;
        }
        .content-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .content-card h2 {
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }
        .tab {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            background: #f8f9fa;
            color: #666;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }
        .tab.active {
            background: #dd0d22;
            color: white;
        }
        .tab:hover:not(.active) {
            background: #e9ecef;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: #f8f9fa;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: #dd0d22;
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }
        .product-info {
            padding: 20px;
        }
        .product-info h3 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        .product-info p {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 10px;
        }
        .badge-lendable {
            background: #d4edda;
            color: #155724;
        }
        .badge-not-lendable {
            background: #f8f9fa;
            color: #666;
            border: 1px solid #ddd;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .empty-state h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .empty-state p {
            color: #666;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .header { flex-direction: column; text-align: center; }
            .product-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="container">

        <!-- Header -->
        <div class="header">
            <div>
                <h1>📚 Lending Management</h1>
                <p>Manage your lendable products and borrowing requests</p>
            </div>
            <a href="{{ route('seller.dash') }}" class="btn btn-secondary">← Back to Dashboard</a>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">📦</div>
                <h3>Total Products</h3>
                <div class="number">{{ $products->count() ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">📚</div>
                <h3>Lendable Items</h3>
                <div class="number">{{ $products->where('is_lendable', true)->count() ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">📋</div>
                <h3>Borrow Requests</h3>
                <div class="number">{{ $lendingRequests->count() ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">✅</div>
                <h3>Active Loans</h3>
                <div class="number">{{ $activeLoans->count() ?? 0 }}</div>
            </div>
        </div>

        <!-- My Lendable Products -->
        <div class="content-card">
            <h2>📦 My Lendable Products</h2>

            <div class="product-grid">
                @forelse($products ?? [] as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->images && $product->images->isNotEmpty())
                                <img src="{{ asset('storage/'.$product->images[0]->image_path) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                📦
                            @endif
                        </div>
                        <div class="product-info">
                            <h3>{{ $product->name }}</h3>
                            <p>💰 Value: ₱{{ number_format($product->price, 2) }}</p>
                            <p>📦 Stock: {{ $product->stock }}</p>

                            @if($product->is_lendable)
                                <span class="badge badge-lendable">✓ Available for Lending</span>
                            @else
                                <span class="badge badge-not-lendable">✗ Not Available for Lending</span>
                            @endif

                            <form action="{{ route('products.toggle-lendable', $product->id) }}" method="POST" style="margin-top:15px;">
                                @csrf
                                @method('patch')
                                <button type="submit" class="btn {{ $product->is_lendable ? 'btn-secondary' : 'btn-primary' }}" style="width:100%;padding:8px;font-size:0.85rem;">
                                    {{ $product->is_lendable ? '❌ Remove from Lending' : '✅ Make Lendable' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <div class="icon">📭</div>
                        <h3>No Products Yet</h3>
                        <p>Add products to your inventory to make them available for lending.</p>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Borrowing Requests -->
        <div class="content-card">
            <h2>📋 Borrowing Requests</h2>

            @forelse($lendingRequests ?? [] as $request)
                <div style="background:#f8f9fa;border-radius:12px;padding:20px;margin-bottom:15px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:15px;">
                    <div>
                        <h4 style="color:#333;margin-bottom:5px;">{{ $request->product->name ?? 'Product' }}</h4>
                        <p style="color:#666;font-size:0.85rem;">
                            👤 {{ $request->borrower->name ?? 'User' }} | 
                            📅 {{ $request->start_date ?? 'N/A' }} - {{ $request->end_date ?? 'N/A' }} |
                            💰 ₱{{ number_format($request->total_fee ?? 0, 2) }}
                        </p>
                    </div>
                    <div style="display:flex;gap:10px;">
                        <form action="{{ route('lending.update-status', $request->id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-primary" style="padding:8px 20px;font-size:0.85rem;">✅ Approve</button>
                        </form>
                        <form action="{{ route('lending.update-status', $request->id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-secondary" style="padding:8px 20px;font-size:0.85rem;">❌ Reject</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="icon">📭</div>
                    <h3>No Borrowing Requests</h3>
                    <p>When someone requests to borrow your items, they'll appear here.</p>
                </div>
            @endforelse
        </div>

        <!-- Active Loans -->
        <div class="content-card">
            <h2>✅ Active Loans</h2>

            @forelse($activeLoans ?? [] as $loan)
                <div style="background:#f8f9fa;border-radius:12px;padding:20px;margin-bottom:15px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:15px;">
                        <div>
                            <h4 style="color:#333;margin-bottom:5px;">{{ $loan->product->name ?? 'Product' }}</h4>
                            <p style="color:#666;font-size:0.85rem;">
                                👤 {{ $loan->borrower->name ?? 'User' }} | 
                                📅 Due: {{ $loan->end_date ?? 'N/A' }} |
                                💰 Fee: ₱{{ number_format($loan->total_fee ?? 0, 2) }}
                            </p>
                        </div>
                        <span style="background:#d4edda;color:#155724;padding:6px 15px;border-radius:20px;font-size:0.8rem;font-weight:600;">
                            🟢 Active
                        </span>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="icon">📭</div>
                    <h3>No Active Loans</h3>
                    <p>Approved lending requests will appear here.</p>
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>
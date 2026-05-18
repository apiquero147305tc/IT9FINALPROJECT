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
        .loan-item {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border-left: 4px solid #dd0d22;
        }
        .loan-item.pending { border-left-color: #ffc107; }
        .loan-item.approved { border-left-color: #28a745; }
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
            .loan-item { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

    <div class="container">

        <!-- Header -->
        <div class="header">
            <div>
                <h1>&#128218; Lending Management</h1>
                <p>Manage your lendable products and borrowing requests</p>
            </div>
            <a href="{{ route('seller.dash') }}" class="btn btn-secondary">&#8592; Back to Dashboard</a>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">&#128230;</div>
                <h3>Total Products</h3>
                <div class="number">{{ isset($products) ? $products->count() : 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">&#128218;</div>
                <h3>Lendable Items</h3>
                <div class="number">{{ isset($products) ? $products->where('is_lendable', true)->count() : 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">&#128220;</div>
                <h3>Borrow Requests</h3>
                <div class="number">{{ isset($lendingRequests) ? $lendingRequests->count() : 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">&#9989;</div>
                <h3>Active Loans</h3>
                <div class="number">{{ isset($activeLoans) ? $activeLoans->count() : 0 }}</div>
            </div>
        </div>

        <!-- My Lendable Products -->
        <div class="content-card">
            <h2>&#128230; My Lendable Products</h2>

            <div class="product-grid">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $product)
                        @php
                            $hasImages = isset($product->images) && $product->images && $product->images->isNotEmpty();
                            $firstImage = $hasImages ? $product->images->first() : null;
                            $isLendable = isset($product->is_lendable) ? $product->is_lendable : false;
                        @endphp
                        <div class="product-card">
                            <div class="product-image">
                                @if($hasImages && $firstImage && isset($firstImage->image_path))
                                    <img src="{{ asset('storage/'.$firstImage->image_path) }}" alt="{{ $product->name ?? 'Product' }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    &#128230;
                                @endif
                            </div>
                            <div class="product-info">
                                <h3>{{ $product->name ?? 'Unknown Product' }}</h3>
                                <p>&#128176; Value: &#8369;{{ isset($product->price) ? number_format($product->price, 2) : '0.00' }}</p>
                                <p>&#128230; Stock: {{ $product->stock ?? 0 }}</p>

                                @if($isLendable)
                                    <span class="badge badge-lendable">&#9989; Available for Lending</span>
                                @else
                                    <span class="badge badge-not-lendable">&#10060; Not Available for Lending</span>
                                @endif

                                <form action="{{ route('products.toggle-lendable', $product->id ?? 0) }}" method="POST" style="margin-top:15px;">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="btn {{ $isLendable ? 'btn-secondary' : 'btn-primary' }}" style="width:100%;padding:8px;font-size:0.85rem;">
                                        {{ $isLendable ? '&#10060; Remove from Lending' : '&#9989; Make Lendable' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <div class="icon">&#128229;</div>
                        <h3>No Products Yet</h3>
                        <p>Add products to your inventory to make them available for lending.</p>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Borrowing Requests -->
        <div class="content-card">
            <h2>&#128220; Borrowing Requests</h2>

            @if(isset($lendingRequests) && $lendingRequests->count() > 0)
                @foreach($lendingRequests as $request)
                    @php
                        $requestProduct = isset($request->product) ? $request->product : null;
                        $requestBorrower = isset($request->borrower) ? $request->borrower : null;
                    @endphp
                    <div class="loan-item pending">
                        <div style="flex:1;">
                            <h4 style="color:#333;margin-bottom:5px;">{{ $requestProduct ? ($requestProduct->name ?? 'Unknown Product') : 'Unknown Product' }}</h4>
                            <p style="color:#666;font-size:0.85rem;">
                                &#128100; {{ $requestBorrower ? ($requestBorrower->name ?? 'Unknown User') : 'Unknown User' }} | 
                                &#128197; {{ isset($request->start_date) && $request->start_date ? $request->start_date : 'N/A' }} - {{ isset($request->end_date) && $request->end_date ? $request->end_date : 'N/A' }} |
                                &#128176; &#8369;{{ isset($request->total_fee) ? number_format($request->total_fee, 2) : '0.00' }}
                            </p>
                        </div>
                        <div style="display:flex;gap:10px;">
                            <form action="{{ route('lending.update-status', $request->id ?? 0) }}" method="POST">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-primary" style="padding:8px 20px;font-size:0.85rem;">&#9989; Approve</button>
                            </form>
                            <form action="{{ route('lending.update-status', $request->id ?? 0) }}" method="POST">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-secondary" style="padding:8px 20px;font-size:0.85rem;">&#10060; Reject</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="icon">&#128229;</div>
                    <h3>No Borrowing Requests</h3>
                    <p>When someone requests to borrow your items, they'll appear here.</p>
                </div>
            @endif
        </div>

        <!-- Active Loans -->
        <div class="content-card">
            <h2>&#9989; Active Loans</h2>

            @if(isset($activeLoans) && $activeLoans->count() > 0)
                @foreach($activeLoans as $loan)
                    @php
                        $loanProduct = isset($loan->product) ? $loan->product : null;
                        $loanBorrower = isset($loan->borrower) ? $loan->borrower : null;
                    @endphp
                    <div class="loan-item approved">
                        <div style="flex:1;">
                            <h4 style="color:#333;margin-bottom:5px;">{{ $loanProduct ? ($loanProduct->name ?? 'Unknown Product') : 'Unknown Product' }}</h4>
                            <p style="color:#666;font-size:0.85rem;">
                                &#128100; {{ $loanBorrower ? ($loanBorrower->name ?? 'Unknown User') : 'Unknown User' }} | 
                                &#128197; Due: {{ isset($loan->due_date) && $loan->due_date ? $loan->due_date : 'N/A' }} |
                                &#128176; &#8369;{{ isset($loan->total_fee) ? number_format($loan->total_fee, 2) : '0.00' }}
                            </p>
                        </div>
                        <span style="background:#d4edda;color:#155724;padding:6px 15px;border-radius:20px;font-size:0.8rem;font-weight:600;">
                            &#128308; Active
                        </span>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="icon">&#128229;</div>
                    <h3>No Active Loans</h3>
                    <p>Approved lending requests will appear here.</p>
                </div>
            @endif
        </div>

    </div>

</body>
</html>
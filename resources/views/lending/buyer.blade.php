<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Lending - CraveCart</title>
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
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
        .loan-item.active { border-left-color: #28a745; }
        .loan-item.pending { border-left-color: #ffc107; }
        .loan-item.overdue { border-left-color: #dc3545; }

        .loan-info h4 {
            color: #333;
            margin-bottom: 5px;
        }
        .loan-info p {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 3px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-active { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-overdue { background: #f8d7da; color: #721c24; }
        .status-returned { background: #e2e3e5; color: #383d41; }

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
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        @media (max-width: 768px) {
            .header { flex-direction: column; text-align: center; }
            .loan-item { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

    <div class="container">

        <!-- Header -->
        <div class="header">
            <div>
                <h1>📚 My Lending</h1>
                <p>Track your borrowed items and lending requests</p>
            </div>
            <div style="display:flex;gap:10px;">
                <a href="{{ route('lending.index') }}" class="btn btn-primary">🔍 Browse Items</a>
                <a href="{{ route('buyer.home') }}" class="btn btn-secondary">← Back</a>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">📚</div>
                <h3>Active Loans</h3>
                <div class="number">{{ $activeLoans->count() ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">📋</div>
                <h3>Pending Requests</h3>
                <div class="number">{{ $pendingRequests->count() ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">📜</div>
                <h3>Total Borrowed</h3>
                <div class="number">{{ $allLoans->count() ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">💰</div>
                <h3>Total Fees</h3>
                <div class="number">₱{{ number_format($totalFees ?? 0, 2) }}</div>
            </div>
        </div>

        <!-- Active Loans -->
        <div class="content-card">
            <h2>✅ Active Loans</h2>

            @forelse($activeLoans ?? [] as $loan)
                <div class="loan-item {{ $loan->isOverdue() ? 'overdue' : 'active' }}">
                    <div class="loan-info">
                        <h4>{{ $loan->product->name ?? 'Product' }}</h4>
                        <p>🏪 {{ $loan->product->user->shop_name ?? $loan->product->user->name ?? 'Seller' }}</p>
                        <p>📅 Borrowed: {{ $loan->start_date ?? 'N/A' }} - Due: {{ $loan->end_date ?? 'N/A' }}</p>
                        <p>💰 Fee: ₱{{ number_format($loan->total_fee ?? 0, 2) }}</p>
                    </div>
                    <div>
                        <span class="status-badge {{ $loan->isOverdue() ? 'status-overdue' : 'status-active' }}">
                            {{ $loan->isOverdue() ? '⚠️ Overdue' : '🟢 Active' }}
                        </span>
                        <div class="action-buttons" style="margin-top:10px;">
                            <a href="{{ route('lending.show', $loan->id) }}" class="btn btn-secondary" style="padding:8px 15px;font-size:0.8rem;">View Details</a>
                            @if(!$loan->isOverdue())
                                <form action="{{ route('lending.return', $loan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="btn btn-primary" style="padding:8px 15px;font-size:0.8rem;">Return Item</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="icon">📭</div>
                    <h3>No Active Loans</h3>
                    <p>You don't have any borrowed items right now.</p>
                    <a href="{{ route('lending.index') }}" class="btn btn-primary">Browse Lendable Items</a>
                </div>
            @endforelse
        </div>

        <!-- Pending Requests -->
        <div class="content-card">
            <h2>⏳ Pending Requests</h2>

            @forelse($pendingRequests ?? [] as $request)
                <div class="loan-item pending">
                    <div class="loan-info">
                        <h4>{{ $request->product->name ?? 'Product' }}</h4>
                        <p>🏪 {{ $request->product->user->shop_name ?? $request->product->user->name ?? 'Seller' }}</p>
                        <p>📅 Requested: {{ $request->start_date ?? 'N/A' }} - {{ $request->end_date ?? 'N/A' }}</p>
                        <p>💰 Est. Fee: ₱{{ number_format($request->total_fee ?? 0, 2) }}</p>
                    </div>
                    <div>
                        <span class="status-badge status-pending">⏳ Pending Approval</span>
                        <div style="margin-top:10px;">
                            <form action="{{ route('lending.cancel', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-secondary" style="padding:8px 15px;font-size:0.8rem;" onclick="return confirm('Cancel this request?')">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="icon">📭</div>
                    <h3>No Pending Requests</h3>
                    <p>Your lending requests will appear here.</p>
                </div>
            @endforelse
        </div>

        <!-- Loan History -->
        <div class="content-card">
            <h2>📜 Loan History</h2>

            @forelse($loanHistory ?? [] as $loan)
                <div class="loan-item">
                    <div class="loan-info">
                        <h4>{{ $loan->product->name ?? 'Product' }}</h4>
                        <p>🏪 {{ $loan->product->user->shop_name ?? $loan->product->user->name ?? 'Seller' }}</p>
                        <p>📅 {{ $loan->start_date ?? 'N/A' }} - {{ $loan->returned_at ?? $loan->end_date ?? 'N/A' }}</p>
                        <p>💰 Fee: ₱{{ number_format($loan->total_fee ?? 0, 2) }}</p>
                    </div>
                    <div>
                        <span class="status-badge status-returned">✅ Returned</span>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="icon">📭</div>
                    <h3>No History</h3>
                    <p>Returned items will appear here.</p>
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>
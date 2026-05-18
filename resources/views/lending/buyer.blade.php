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
            min-height: 100vh;
            background: linear-gradient(135deg, #dd0d22 0%, #ff6b35 50%, #ff8c42 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            width: 100%;
            text-align: center;
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            font-size: 1.8rem;
            font-weight: 700;
        }
        .header p {
            color: #666;
            font-size: 1rem;
            margin-top: 5px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
            margin: 5px;
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
            background: transparent;
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
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        .stat-card .icon {
            font-size: 2rem;
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
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: left;
        }
        .content-card h2 {
            color: #333;
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .loan-item {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border-left: 4px solid #dd0d22;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .loan-item.active { border-left-color: #28a745; }
        .loan-item.pending { border-left-color: #ffc107; }
        .loan-item.overdue { border-left-color: #dc3545; }
        .loan-info h4 {
            color: #333;
            font-size: 1rem;
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
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        .empty-state .icon {
            font-size: 3rem;
            margin-bottom: 15px;
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
            .loan-item { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">

            <!-- Header -->
            <div class="header">
                <div>
                    <h1>📚 My Lending</h1>
                    <p>Track your borrowed items and lending requests</p>
                </div>
                <div>
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

                @php
                    $activeList = (isset($activeLoans) && $activeLoans) ? $activeLoans : collect();
                @endphp

                @forelse($activeList as $loan)
                    @php
                        $loanProduct = null;
                        $loanLender = null;
                        $isOverdue = false;

                        if (isset($loan) && is_object($loan)) {
                            if (isset($loan->product)) {
                                $loanProduct = $loan->product;
                            }
                            if (isset($loan->lender)) {
                                $loanLender = $loan->lender;
                            }
                            if (method_exists($loan, 'isOverdue')) {
                                try {
                                    $isOverdue = $loan->isOverdue();
                                } catch (\Exception $e) {
                                    $isOverdue = false;
                                }
                            }
                        }

                        $productName = 'Unknown Product';
                        if ($loanProduct && is_object($loanProduct)) {
                            $productName = isset($loanProduct->name) ? $loanProduct->name : 'Unknown Product';
                        }

                        $lenderDisplay = 'Unknown Seller';
                        if ($loanLender && is_object($loanLender)) {
                            $shopName = isset($loanLender->shop_name) ? $loanLender->shop_name : null;
                            $lenderName = isset($loanLender->name) ? $loanLender->name : 'Unknown Seller';
                            $lenderDisplay = $shopName ? $shopName : $lenderName;
                        }

                        $borrowedAt = (isset($loan->borrowed_at) && $loan->borrowed_at) ? $loan->borrowed_at : null;
                        $dueDate = (isset($loan->due_date) && $loan->due_date) ? $loan->due_date : null;
                        $borrowedFormatted = $borrowedAt ? (is_string($borrowedAt) ? $borrowedAt : $borrowedAt->format('M d, Y')) : 'N/A';
                        $dueFormatted = $dueDate ? (is_string($dueDate) ? $dueDate : $dueDate->format('M d, Y')) : 'N/A';

                        $lendingFee = (isset($loan->lending_fee) && $loan->lending_fee) ? $loan->lending_fee : 0;
                        $loanId = (isset($loan->id) && $loan->id) ? $loan->id : 0;
                    @endphp

                    <div class="loan-item {{ $isOverdue ? 'overdue' : 'active' }}">
                        <div class="loan-info">
                            <h4>{{ $productName }}</h4>
                            <p>🏪 {{ $lenderDisplay }}</p>
                            <p>📅 Borrowed: {{ $borrowedFormatted }} - Due: {{ $dueFormatted }}</p>
                            <p>💰 Fee: ₱{{ number_format($lendingFee, 2) }}</p>
                        </div>
                        <div>
                            <span class="status-badge {{ $isOverdue ? 'status-overdue' : 'status-active' }}">
                                {{ $isOverdue ? '⚠️ Overdue' : '🟢 Active' }}
                            </span>
                            <div class="action-buttons" style="margin-top:10px;">
                                @if(!$isOverdue)
                                    <form action="{{ route('lending.update-status', $loanId) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="returned">
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

                @php
                    $pendingList = (isset($pendingRequests) && $pendingRequests) ? $pendingRequests : collect();
                @endphp

                @forelse($pendingList as $request)
                    @php
                        $reqProduct = null;
                        $reqLender = null;

                        if (isset($request) && is_object($request)) {
                            if (isset($request->product)) {
                                $reqProduct = $request->product;
                            }
                            if (isset($request->lender)) {
                                $reqLender = $request->lender;
                            }
                        }

                        $reqProductName = 'Unknown Product';
                        if ($reqProduct && is_object($reqProduct)) {
                            $reqProductName = isset($reqProduct->name) ? $reqProduct->name : 'Unknown Product';
                        }

                        $reqLenderDisplay = 'Unknown Seller';
                        if ($reqLender && is_object($reqLender)) {
                            $reqShopName = isset($reqLender->shop_name) ? $reqLender->shop_name : null;
                            $reqLenderName = isset($reqLender->name) ? $reqLender->name : 'Unknown Seller';
                            $reqLenderDisplay = $reqShopName ? $reqShopName : $reqLenderName;
                        }

                        $reqBorrowedAt = (isset($request->borrowed_at) && $request->borrowed_at) ? $request->borrowed_at : null;
                        $reqDueDate = (isset($request->due_date) && $request->due_date) ? $request->due_date : null;
                        $reqBorrowedFormatted = $reqBorrowedAt ? (is_string($reqBorrowedAt) ? $reqBorrowedAt : $reqBorrowedAt->format('M d, Y')) : 'N/A';
                        $reqDueFormatted = $reqDueDate ? (is_string($reqDueDate) ? $reqDueDate : $reqDueDate->format('M d, Y')) : 'N/A';

                        $reqFee = (isset($request->lending_fee) && $request->lending_fee) ? $request->lending_fee : 0;
                        $reqId = (isset($request->id) && $request->id) ? $request->id : 0;
                    @endphp

                    <div class="loan-item pending">
                        <div class="loan-info">
                            <h4>{{ $reqProductName }}</h4>
                            <p>🏪 {{ $reqLenderDisplay }}</p>
                            <p>📅 Requested: {{ $reqBorrowedFormatted }} - {{ $reqDueFormatted }}</p>
                            <p>💰 Est. Fee: ₱{{ number_format($reqFee, 2) }}</p>
                        </div>
                        <div>
                            <span class="status-badge status-pending">⏳ Pending Approval</span>
                            <div style="margin-top:10px;">
                                <form action="{{ route('lending.update-status', $reqId) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
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

                @php
                    $historyList = (isset($loanHistory) && $loanHistory) ? $loanHistory : collect();
                @endphp

                @forelse($historyList as $loan)
                    @php
                        $histProduct = null;
                        $histLender = null;

                        if (isset($loan) && is_object($loan)) {
                            if (isset($loan->product)) {
                                $histProduct = $loan->product;
                            }
                            if (isset($loan->lender)) {
                                $histLender = $loan->lender;
                            }
                        }

                        $histProductName = 'Unknown Product';
                        if ($histProduct && is_object($histProduct)) {
                            $histProductName = isset($histProduct->name) ? $histProduct->name : 'Unknown Product';
                        }

                        $histLenderDisplay = 'Unknown Seller';
                        if ($histLender && is_object($histLender)) {
                            $histShopName = isset($histLender->shop_name) ? $histLender->shop_name : null;
                            $histLenderName = isset($histLender->name) ? $histLender->name : 'Unknown Seller';
                            $histLenderDisplay = $histShopName ? $histShopName : $histLenderName;
                        }

                        $histBorrowedAt = (isset($loan->borrowed_at) && $loan->borrowed_at) ? $loan->borrowed_at : null;
                        $histReturnedAt = (isset($loan->returned_at) && $loan->returned_at) ? $loan->returned_at : null;
                        $histDueDate = (isset($loan->due_date) && $loan->due_date) ? $loan->due_date : null;
                        $histBorrowedFormatted = $histBorrowedAt ? (is_string($histBorrowedAt) ? $histBorrowedAt : $histBorrowedAt->format('M d, Y')) : 'N/A';
                        $histEndFormatted = $histReturnedAt ? (is_string($histReturnedAt) ? $histReturnedAt : $histReturnedAt->format('M d, Y')) : ($histDueDate ? (is_string($histDueDate) ? $histDueDate : $histDueDate->format('M d, Y')) : 'N/A');

                        $histFee = (isset($loan->lending_fee) && $loan->lending_fee) ? $loan->lending_fee : 0;
                        $histStatus = (isset($loan->status) && $loan->status) ? $loan->status : 'unknown';
                    @endphp

                    <div class="loan-item">
                        <div class="loan-info">
                            <h4>{{ $histProductName }}</h4>
                            <p>🏪 {{ $histLenderDisplay }}</p>
                            <p>📅 {{ $histBorrowedFormatted }} - {{ $histEndFormatted }}</p>
                            <p>💰 Fee: ₱{{ number_format($histFee, 2) }}</p>
                        </div>
                        <div>
                            <span class="status-badge {{ $histStatus === 'returned' ? 'status-returned' : 'status-overdue' }}">
                                {{ $histStatus === 'returned' ? '✅ Returned' : '❌ ' . ucfirst($histStatus) }}
                            </span>
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
    </div>

</body>
</html>
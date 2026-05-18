<x-buyerDash>

<div class="min-h-screen bg-slate-50 p-6 md:p-8">

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- HERO HEADER (ADMIN STYLE MATCHED) --}}
        <div class="bg-gradient-to-r from-[#ba1124] via-[#d31c30] to-[#e6334a]
                    text-white rounded-3xl p-6 md:p-8 shadow-sm
                    flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                    <span class="text-xl">📚</span>
                </div>

                <div>
                    <h1 class="text-2xl font-bold tracking-tight">My Lending</h1>
                    <p class="text-white/70 text-xs uppercase tracking-wider">
                        Track your borrowed items and lending requests
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">

                <a href="{{ route('lending.index') }}"
                   class="bg-white text-red-600 font-bold text-xs px-4 py-2 rounded-xl hover:bg-slate-100 transition">
                    🔍 Browse Items
                </a>

                <a href="{{ route('buyer.home') }}"
                   class="bg-black/20 text-white font-bold text-xs px-4 py-2 rounded-xl hover:bg-black/30 transition">
                    ← Back
                </a>

            </div>
        </div>

        {{-- STATS (ADMIN CARD STYLE) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="gradient-border-wrapper rounded-3xl overflow-hidden shadow-sm">
                <div class="bg-white p-6 rounded-[23px] flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Active Loans</p>
                        <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $activeLoans->count() ?? 0 }}</h2>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center">📚</div>
                </div>
            </div>

            <div class="gradient-border-wrapper rounded-3xl overflow-hidden shadow-sm">
                <div class="bg-white p-6 rounded-[23px] flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Pending Requests</p>
                        <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $pendingRequests->count() ?? 0 }}</h2>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center">⏳</div>
                </div>
            </div>

            <div class="gradient-border-wrapper rounded-3xl overflow-hidden shadow-sm">
                <div class="bg-white p-6 rounded-[23px] flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Borrowed</p>
                        <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $allLoans->count() ?? 0 }}</h2>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">📜</div>
                </div>
            </div>

            <div class="gradient-border-wrapper rounded-3xl overflow-hidden shadow-sm">
                <div class="bg-white p-6 rounded-[23px] flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Fees</p>
                        <h2 class="text-2xl font-bold text-slate-800 mt-2">
                            ₱{{ number_format($totalFees ?? 0, 2) }}
                        </h2>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center">💰</div>
                </div>
            </div>

        </div>

        @php
            $activeList = (isset($activeLoans) && $activeLoans) ? $activeLoans : collect();
            $pendingList = (isset($pendingRequests) && $pendingRequests) ? $pendingRequests : collect();
            $historyList = (isset($loanHistory) && $loanHistory) ? $loanHistory : collect();
        @endphp

        {{-- ACTIVE LOANS --}}
        <div class="gradient-border-wrapper rounded-3xl overflow-hidden shadow-sm">
            <div class="bg-white rounded-[23px] p-6 space-y-4">

                <h2 class="text-lg font-bold text-slate-800">Active Loans</h2>

                @forelse($activeList as $loan)

                    @php
                        $loanProduct = $loan->product ?? null;
                        $loanLender = $loan->lender ?? null;

                        $isOverdue = false;
                        try {
                            $isOverdue = method_exists($loan, 'isOverdue') ? $loan->isOverdue() : false;
                        } catch (\Exception $e) {
                            $isOverdue = false;
                        }

                        $productName = $loanProduct->name ?? 'Unknown Product';
                        $lenderDisplay = $loanLender->shop_name ?? $loanLender->name ?? 'Unknown Seller';

                        $borrowedFormatted = isset($loan->borrowed_at)
                            ? (is_string($loan->borrowed_at) ? $loan->borrowed_at : $loan->borrowed_at->format('M d, Y'))
                            : 'N/A';

                        $dueFormatted = isset($loan->due_date)
                            ? (is_string($loan->due_date) ? $loan->due_date : $loan->due_date->format('M d, Y'))
                            : 'N/A';

                        $lendingFee = $loan->lending_fee ?? 0;
                        $loanId = $loan->id ?? 0;
                    @endphp

                <div class="bg-slate-50 rounded-2xl p-4 flex justify-between items-center flex-wrap gap-3">

                    <div>
                        <h4 class="font-bold text-slate-800">{{ $productName }}</h4>
                        <p class="text-xs text-slate-400">🏪 {{ $lenderDisplay }}</p>
                        <p class="text-xs text-slate-400">
                            📅 Borrowed: {{ $borrowedFormatted }} - Due: {{ $dueFormatted }}
                        </p>
                        <p class="text-xs text-slate-400">💰 Fee: ₱{{ number_format($lendingFee, 2) }}</p>
                    </div>

                    <div class="flex flex-col items-end gap-2">

                        <span class="text-xs font-bold px-3 py-1 rounded-full
                            {{ $isOverdue ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                            {{ $isOverdue ? '⚠️ Overdue' : '🟢 Active' }}
                        </span>

                        <div class="flex gap-2">

                            <a href="{{ route('lending.show', $loanId) }}"
                               class="text-xs bg-slate-800 text-white px-3 py-2 rounded-xl">
                                View
                            </a>

                            @if(!$isOverdue)
                            <form action="{{ route('lending.update-status', $loanId) }}" method="POST">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" value="returned">

                                <button class="text-xs bg-red-600 text-white px-3 py-2 rounded-xl">
                                    Return
                                </button>
                            </form>
                            @endif

                        </div>

                    </div>

                </div>

                @empty
                <p class="text-slate-400 text-sm">No active loans.</p>
                @endforelse

            </div>
        </div>

        {{-- PENDING REQUESTS --}}
        <div class="gradient-border-wrapper rounded-3xl overflow-hidden shadow-sm">
            <div class="bg-white rounded-[23px] p-6 space-y-4">

                <h2 class="text-lg font-bold text-slate-800">Pending Requests</h2>

                @forelse($pendingList as $request)

            @php
                $reqProduct = $request->product ?? null;
                $reqLender = $request->lender ?? null;

                $reqProductName = $reqProduct->name ?? 'Unknown Product';
                $reqLenderDisplay = $reqLender->shop_name ?? $reqLender->name ?? 'Unknown Seller';

                $reqBorrowedFormatted = isset($request->borrowed_at)
                    ? (is_string($request->borrowed_at) ? $request->borrowed_at : $request->borrowed_at->format('M d, Y'))
                    : 'N/A';

                $reqDueFormatted = isset($request->due_date)
                    ? (is_string($request->due_date) ? $request->due_date : $request->due_date->format('M d, Y'))
                    : 'N/A';

                $reqFee = $request->lending_fee ?? 0;
                $reqId = $request->id ?? 0;
            @endphp

                <div class="bg-slate-50 rounded-2xl p-4 flex justify-between items-center flex-wrap gap-3">

                    <div>
                        <h4 class="font-bold text-slate-800">{{ $reqProductName }}</h4>
                        <p class="text-xs text-slate-400">🏪 {{ $reqLenderDisplay }}</p>
                        <p class="text-xs text-slate-400">
                            📅 Requested: {{ $reqBorrowedFormatted }} - {{ $reqDueFormatted }}
                        </p>
                        <p class="text-xs text-slate-400">💰 Est. Fee: ₱{{ number_format($reqFee, 2) }}</p>
                    </div>

                    <div class="flex flex-col items-end gap-2">

                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-orange-100 text-orange-600">
                            ⏳ Pending
                        </span>

                        <form action="{{ route('lending.update-status', $reqId) }}" method="POST">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="status" value="rejected">

                            <button class="text-xs bg-slate-700 text-white px-3 py-2 rounded-xl">
                                Cancel
                            </button>
                        </form>

                    </div>

                </div>

                @empty
                <p class="text-slate-400 text-sm">No pending requests.</p>
                @endforelse

            </div>
        </div>

        {{-- HISTORY --}}
        <div class="gradient-border-wrapper rounded-3xl overflow-hidden shadow-sm">
            <div class="bg-white rounded-[23px] p-6 space-y-4">

                <h2 class="text-lg font-bold text-slate-800">Loan History</h2>

                @forelse($historyList as $loan)

                <div class="bg-slate-50 rounded-2xl p-4 flex justify-between items-center flex-wrap gap-3">

                    <div>
                        <h4 class="font-bold text-slate-800">{{ $histProductName }}</h4>
                        <p class="text-xs text-slate-400">🏪 {{ $histLenderDisplay }}</p>
                        <p class="text-xs text-slate-400">
                            📅 {{ $histBorrowedFormatted }} - {{ $histEndFormatted }}
                        </p>
                        <p class="text-xs text-slate-400">💰 ₱{{ number_format($histFee, 2) }}</p>
                    </div>

                    <span class="text-xs font-bold px-3 py-1 rounded-full
                        {{ $histStatus === 'returned' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        {{ ucfirst($histStatus) }}
                    </span>

                </div>

                @empty
                <p class="text-slate-400 text-sm">No history yet.</p>
                @endforelse

            </div>
        </div>

    </div>
</div>

</x-buyerDash>
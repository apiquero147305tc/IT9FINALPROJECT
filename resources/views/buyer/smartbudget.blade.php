<x-buyerDash>

<script src="https://unpkg.com/lucide@latest"></script>

<style>
    .glass {
        background: rgba(255,255,255,0.78);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.4);
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        border-radius: 18px;
    }

    .card-title {
        font-size: 13px;
        color: #78716c;
        margin-top: 6px;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-box {
        margin-top: 15px;
        padding: 14px 16px;
        border-radius: 14px;
        font-weight: 600;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #292524;
    }

    .value-text {
        margin-top: 8px;
        color: #1c1917;
    }

    /* NEW SAFE BUTTON STYLE */
    .back-btn {
        display:inline-flex;
        align-items:center;
        gap:8px;
        margin-top:12px;
        padding:8px 14px;
        background:#ffffff;
        border:1px solid rgba(0,0,0,0.08);
        border-radius:12px;
        text-decoration:none;
        color:#111827;
        font-weight:600;
        font-size:14px;
        width:fit-content;
        box-shadow:0 2px 6px rgba(0,0,0,0.05);
        transition:0.2s ease;
    }

    .back-btn:hover {
        transform: translateY(-1px);
        background:#f9fafb;
    }
</style>

<div style="
    min-height:100vh;
    padding:30px;
    background: radial-gradient(circle at top, #fff7e6, #f8fafc);
    font-family:'Segoe UI', sans-serif;
">

    {{-- HEADER --}}
    <div class="fade-in" style="margin-bottom:25px;">

        <h1 style="
            margin:0;
            font-size:36px;
            font-weight:900;
            display:flex;
            align-items:center;
            gap:12px;
        ">
            <span data-lucide="wallet" style="
                color:#d97706;
                width:34px;
                height:34px;
            "></span>

            <span style="
                background: linear-gradient(90deg,#fbbf24,#f59e0b,#d97706);
                -webkit-background-clip:text;
                -webkit-text-fill-color:transparent;
                letter-spacing:0.5px;
            ">
                Smart Budget Control
            </span>
        </h1>

        <p style="
            color:#78716c;
            margin-top:8px;
            font-size:15px;
        ">
            Financial overview of your spending behavior in real time!
        </p>

        {{-- ✅ BACK TO DASHBOARD (NEW, SAFE, NON-INTRUSIVE) --}}
        <a href="{{ route('buyer.home') }}" class="back-btn">
            ← Back to Dashboard
        </a>

    </div>

    {{-- SUMMARY CARDS --}}
    <div class="fade-in" style="
        display:grid;
        grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
        gap:16px;
        margin-bottom:25px;
    ">

        <div class="glass" style="padding:20px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <span data-lucide="banknote" style="color:#d97706;"></span>
                <div class="card-title">Total Budget</div>
            </div>
            <h2 class="value-text">₱{{ number_format($budget,2) }}</h2>
        </div>

        <div class="glass" style="padding:20px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <span data-lucide="trending-down" style="color:#dc2626;"></span>
                <div class="card-title">Total Spent</div>
            </div>
            <h2 class="value-text" style="color:#dc2626;">
                ₱{{ number_format($spent,2) }}
            </h2>
        </div>

        <div class="glass" style="padding:20px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <span data-lucide="piggy-bank" style="color:#059669;"></span>
                <div class="card-title">Remaining</div>
            </div>
            <h2 class="value-text" style="color:#059669;">
                ₱{{ number_format($remaining,2) }}
            </h2>
        </div>

        <div class="glass" style="padding:20px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <span data-lucide="percent" style="color:#f59e0b;"></span>
                <div class="card-title">Usage</div>
            </div>
            <h2 class="value-text">
                {{ round($percent,1) }}%
            </h2>
        </div>

    </div>

    {{-- ALERT --}}
    <div class="glass fade-in alert-box"
        style="
            background: {{ $percent >= 90 ? '#fee2e2' : ($percent >= 70 ? '#fef3c7' : '#dcfce7') }};
            color: {{ $percent >= 90 ? '#b91c1c' : ($percent >= 70 ? '#92400e' : '#166534') }};
        ">

        @if($percent >= 90)
            🚨 Critical: You exceeded your budget!
        @elseif($percent >= 70)
            ⚠ Warning: You're nearing your limit.
        @else
            ✔ Spending is under control.
        @endif

    </div>

    {{-- MAIN GRID --}}
    <div style="
        display:grid;
        grid-template-columns: 1.4fr 1fr;
        gap:20px;
        margin-top:20px;
    ">

        <div class="glass fade-in" style="padding:22px;">
            <h3 class="section-title" style="display:flex;align-items:center;gap:10px;">
                <span data-lucide="bar-chart-3" style="color:#d97706;"></span>
                Budget Flow
            </h3>

            <div style="
                margin-top:16px;
                height:14px;
                background:#e7e5e4;
                border-radius:999px;
                overflow:hidden;
            ">
                <div style="
                    width: {{ min($percent,100) }}%;
                    height:100%;
                    background: linear-gradient(90deg,#fbbf24,#f59e0b,#d97706);
                    border-radius:999px;
                "></div>
            </div>

            <p style="margin-top:12px;color:#78716c;font-size:14px;">
                Your monthly spending progress based on your budget.
            </p>
        </div>

        <div class="glass fade-in" style="padding:22px;">
            <h3 class="section-title" style="display:flex;align-items:center;gap:10px;">
                <span data-lucide="lightbulb" style="color:#f59e0b;"></span>
                Insight
            </h3>

            <p style="color:#78716c;margin-top:12px;line-height:1.6;">
                @if($spent > 0 && $spending->count())
                    You spent the most on
                    <b style="color:#92400e;">
                        {{ $spending->sortDesc()->keys()->first() }}
                    </b>.
                @else
                    No spending data available yet.
                @endif
            </p>
        </div>

    </div>

    {{-- PIE CHART --}}
    <div class="glass fade-in" style="margin-top:20px;padding:22px;">
        <h3 class="section-title" style="display:flex;align-items:center;gap:10px;">
            <span data-lucide="pie-chart" style="color:#d97706;"></span>
            Spending Distribution
        </h3>

        <div style="display:flex;justify-content:center;margin-top:20px;">
            <canvas id="spendingChart" style="max-width:420px;"></canvas>
        </div>
    </div>

    {{-- CATEGORY BREAKDOWN --}}
    <div class="glass fade-in" style="margin-top:20px;padding:22px;">
        <h3 class="section-title" style="display:flex;align-items:center;gap:10px;">
            <span data-lucide="layers" style="color:#d97706;"></span>
            Category Breakdown
        </h3>

        <div style="margin-top:18px;">
            @foreach($spending as $category => $amount)
                <div style="margin-bottom:18px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                        <b style="color:#292524;">{{ ucfirst($category) }}</b>
                        <span style="color:#57534e;">₱{{ number_format($amount,2) }}</span>
                    </div>

                    <div style="height:9px;background:#e7e5e4;border-radius:999px;overflow:hidden;">
                        <div style="
                            width: {{ $spent > 0 ? ($amount / $spent) * 100 : 0 }}%;
                            height:100%;
                            background: linear-gradient(90deg,#fbbf24,#f59e0b,#d97706);
                            border-radius:999px;
                        "></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

{{-- CHART --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('spendingChart');

if (ctx) {
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($spending->keys()) !!},
            datasets: [{
                data: {!! json_encode($spending->values()) !!},
                backgroundColor: [
                    '#fbbf24',
                    '#f59e0b',
                    '#d97706',
                    '#10b981',
                    '#ef4444',
                    '#92400e'
                ],
                borderWidth: 0
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}
</script>

<script>
    lucide.createIcons();
</script>

</x-buyerDash>
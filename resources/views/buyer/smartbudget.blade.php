<x-buyerDash>

<script src="https://unpkg.com/lucide@latest"></script>

<style>
    .glass {
        background: rgba(255,255,255,0.75);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.4);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-radius: 18px;
    }

    .card-title {
        font-size: 13px;
        color: #6b7280;
        margin-top: 6px;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-box {
        margin-top: 15px;
        padding: 12px 15px;
        border-radius: 12px;
        font-weight: 500;
    }
</style>

<div style="
    min-height:100vh;
    padding:30px;
    background: radial-gradient(circle at top, #eef2ff, #f8fafc);
    font-family: 'Segoe UI', sans-serif;
">

    {{-- HEADER --}}
    <div class="fade-in" style="margin-bottom:25px;">

        <h1 style="
            margin:0;
            font-size:34px;
            font-weight:900;
            display:flex;
            align-items:center;
            gap:12px;
            color:#111827;
        ">
            <span data-lucide="wallet" style="color:#4f46e5;"></span>

            <span style="
                background: linear-gradient(90deg,#4f46e5,#3b82f6);
                -webkit-background-clip:text;
                -webkit-text-fill-color:transparent;
            ">
                Smart Budget Control
            </span>
        </h1>

        <p style="color:#6b7280; margin-top:6px;">
            Financial overview of your spending behavior in real time!
        </p>
    </div>

    {{-- TOP SUMMARY STRIP --}}
    <div class="fade-in" style="
        display:grid;
        grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
        gap:16px;
        margin-bottom:25px;
    ">

        <div class="glass" style="padding:18px;">
            <span data-lucide="banknote" style="color:#4f46e5;"></span>
            <div class="card-title">Total Budget</div>
            <h2>₱{{ number_format($budget,2) }}</h2>
        </div>

        <div class="glass" style="padding:18px;">
            <span data-lucide="trending-down" style="color:#ef4444;"></span>
            <div class="card-title">Total Spent</div>
            <h2 style="color:#ef4444;">₱{{ number_format($spent,2) }}</h2>
        </div>

        <div class="glass" style="padding:18px;">
            <span data-lucide="piggy-bank" style="color:#10b981;"></span>
            <div class="card-title">Remaining</div>
            <h2 style="color:#10b981;">₱{{ number_format($remaining,2) }}</h2>
        </div>

        <div class="glass" style="padding:18px;">
            <span data-lucide="percent" style="color:#f59e0b;"></span>
            <div class="card-title">Usage</div>
            <h2>{{ round($percent,1) }}%</h2>
        </div>

    </div>

    {{-- ALERT SYSTEM (NEW) --}}
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

        {{-- LEFT: PROGRESS --}}
        <div class="glass fade-in" style="padding:22px;">

            <h3 style="display:flex;align-items:center;gap:10px;">
                <span data-lucide="bar-chart-3" style="color:#4f46e5;"></span>
                Budget Flow
            </h3>

            <div style="
                margin-top:15px;
                height:14px;
                background:#e5e7eb;
                border-radius:999px;
                overflow:hidden;
            ">
                <div style="
                    width: {{ min($percent,100) }}%;
                    height:100%;
                    background: linear-gradient(90deg,#4f46e5,#3b82f6);
                "></div>
            </div>

        </div>

        {{-- RIGHT: INSIGHT BOX --}}
        <div class="glass fade-in" style="padding:22px;">

            <h3 style="display:flex;align-items:center;gap:10px;">
                <span data-lucide="lightbulb" style="color:#f59e0b;"></span>
                Insight
            </h3>

            <p style="color:#6b7280; margin-top:10px;">
                @if($spent > 0 && $spending->count())
                    You spent the most on
                    <b>{{ $spending->sortDesc()->keys()->first() }}</b>.
                @else
                    No spending data available yet.
                @endif
            </p>

        </div>

    </div>

    {{-- PIE CHART --}}
    <div class="glass fade-in" style="margin-top:20px; padding:22px;">

        <h3>📊 Spending Distribution</h3>

        <canvas id="spendingChart" style="max-width:400px;margin-top:15px;"></canvas>

    </div>

    {{-- CATEGORY BREAKDOWN --}}
    <div class="glass fade-in" style="margin-top:20px; padding:22px;">

        <h3 style="display:flex;align-items:center;gap:10px;">
            <span data-lucide="layers" style="color:#4f46e5;"></span>
            Category Breakdown
        </h3>

        <div style="margin-top:15px;">

            @foreach($spending as $category => $amount)

                <div style="margin-bottom:14px;">

                    <div style="display:flex;justify-content:space-between;">
                        <b>{{ ucfirst($category) }}</b>
                        <span>₱{{ number_format($amount,2) }}</span>
                    </div>

                    <div style="
                        height:8px;
                        background:#e5e7eb;
                        border-radius:999px;
                        overflow:hidden;
                        margin-top:6px;
                    ">
                        <div style="
                            width: {{ $spent > 0 ? ($amount / $spent)*100 : 0 }}%;
                            height:100%;
                            background: linear-gradient(90deg,#6366f1,#3b82f6);
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
                    '#4f46e5',
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6'
                ]
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
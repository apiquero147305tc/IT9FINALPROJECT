<x-layout>

@php
    $budget = auth()->user()->monthly_budget ?? 0;
    $spent = auth()->user()->spent_amount ?? 0;
    $remaining = $budget - $spent;
    $percent = $budget > 0 ? ($spent / $budget) * 100 : 0;

    $spending = json_decode(auth()->user()->category_spending ?? '{}', true);
@endphp

<div style="padding: 30px; background:#f4f6f8; min-height:100vh;">

    <h1 style="margin-bottom: 20px;">📊 Smart Budget Dashboard</h1>

    {{-- TOP CARDS --}}
    <div style="display:flex; gap:15px; flex-wrap:wrap;">

        <div style="background:white; padding:15px; border-radius:10px; width:200px;">
            <h3>Budget</h3>
            <p>₱{{ $budget }}</p>
        </div>

        <div style="background:white; padding:15px; border-radius:10px; width:200px;">
            <h3>Spent</h3>
            <p>₱{{ $spent }}</p>
        </div>

        <div style="background:white; padding:15px; border-radius:10px; width:200px;">
            <h3>Remaining</h3>
            <p>₱{{ $remaining }}</p>
        </div>

    </div>

    {{-- PROGRESS BAR --}}
    <div style="margin-top:25px; background:white; padding:20px; border-radius:10px;">

        <h3>Budget Usage</h3>

        <div style="width:100%; height:18px; background:#ddd; border-radius:20px; overflow:hidden;">
            <div style="
                width: {{ min($percent, 100) }}%;
                height:100%;
                background:
                    @if($percent >= 90) #e74c3c
                    @elseif($percent >= 70) #f39c12
                    @else #2ecc71
                    @endif;
                transition:0.3s;">
            </div>
        </div>

        <p style="margin-top:10px;">
            {{ round($percent, 1) }}% used
        </p>

        @if($percent >= 90)
            <p style="color:red;"><b>🚨 Over budget warning!</b></p>
        @elseif($percent >= 70)
            <p style="color:orange;">⚠ Approaching limit</p>
        @else
            <p style="color:green;">✔ Spending is healthy</p>
        @endif

    </div>

    {{-- CATEGORY BREAKDOWN --}}
    <div style="margin-top:25px; background:white; padding:20px; border-radius:10px;">

        <h3>Category Breakdown</h3>

        @if($spending && count($spending))
            <ul>
                @foreach($spending as $category => $amount)
                    <li>
                        <b>{{ ucfirst($category) }}:</b> ₱{{ $amount }}

                        @if($amount > 1000)
                            <span style="color:red;">⚠ High spending</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>No category data yet.</p>
        @endif

    </div>

</div>

</x-layout>
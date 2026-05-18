@php
    $safePercent = min((float) $percent, 100);
    $barColor = $percent >= 90
        ? 'bg-red-600'
        : ($percent >= 70
            ? 'bg-yellow-500'
            : 'bg-green-600');
@endphp
    
    <section class="min-h-[85vh] bg-[#FDFCFB] px-6 py-20">
        <div class="max-w-[1440px] mx-auto">
            
            {{-- HEADER --}}
            <header class="mb-16 text-center">
                <span class="inline-block px-4 py-1.5 rounded-full bg-red-100 text-red-600 text-[10px] font-black uppercase tracking-[0.2em] mb-6 border border-red-200">
                    Financial Control
                </span>
                <h2 class="text-5xl md:text-6xl font-black uppercase tracking-tighter text-slate-900 leading-[0.9]">
                    Smart <span class="text-red-600">Budget.</span>
                </h2>
                <p class="mt-4 text-slate-400 font-bold uppercase text-[11px] tracking-[0.3em]">Financial overview of your spending behavior in real time!</p>
            </header>

            {{-- SUMMARY CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                
                <div class="bg-white p-8 rounded-[30px] border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Monthly Budget</p>
                    <h3 class="text-3xl font-black text-slate-900">₱{{ number_format($budget, 2) }}</h3>
                </div>

                <div class="bg-white p-8 rounded-[30px] border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Spent</p>
                    <h3 class="text-3xl font-black text-red-600">₱{{ number_format($spent, 2) }}</h3>
                </div>

                <div class="bg-white p-8 rounded-[30px] border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Remaining</p>
                    <h3 class="text-3xl font-black {{ $remaining >= 0 ? 'text-green-600' : 'text-red-600' }}">₱{{ number_format($remaining, 2) }}</h3>
                </div>

                <div class="bg-white p-8 rounded-[30px] border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Usage</p>
                    <h3 class="text-3xl font-black {{ $percent >= 90 ? 'text-red-600' : ($percent >= 70 ? 'text-yellow-500' : 'text-green-600') }}">{{ round($percent, 1) }}%</h3>
                </div>
            </div>

            {{-- ALERT --}}
            <div class="mb-12 p-6 rounded-2xl {{ $percent >= 90 ? 'bg-red-50 border-red-200 text-red-700' : ($percent >= 70 ? 'bg-yellow-50 border-yellow-200 text-yellow-700' : 'bg-green-50 border-green-200 text-green-700') }} border text-center font-bold uppercase text-[11px] tracking-widest">
                @if($percent >= 90)
                    🚨 Critical: You exceeded your budget!
                @elseif($percent >= 70)
                    ⚠️ Warning: You're nearing your limit.
                @else
                    ✔️ Spending is under control.
                @endif
            </div>

            {{-- MAIN GRID --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    {{-- PROGRESS BAR --}}
    <div class="bg-white p-8 rounded-[30px] border border-slate-100 shadow-sm">

        <h3 class="text-xl font-black text-slate-900 mb-6 uppercase tracking-tight">
            Budget Flow
        </h3>

        <p class="text-slate-500 text-sm font-medium mb-6">
            Your monthly spending progress based on your budget.
        </p>

       <div class="h-full rounded-full transition-all duration-1000 {{ $barColor }}"
     style="width: {{ $safePercent }}%;">
</div>

        </div>

        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-slate-400">
            <span>0%</span>
            <span>50%</span>
            <span>100%</span>
        </div>

    </div>

    {{-- INSIGHT --}}
    <div class="bg-white p-8 rounded-[30px] border border-slate-100 shadow-sm">

        <h3 class="text-xl font-black text-slate-900 mb-6 uppercase tracking-tight">
            Insight
        </h3>

        @if($spent > 0 && $spending->count())
            <p class="text-slate-600 font-medium leading-relaxed">
                You spent the most on
                <span class="font-black text-red-600">
                    {{ $spending->sortDesc()->keys()->first() }}
                </span>.
            </p>
        @else
            <p class="text-slate-400 font-medium">
                No spending data available yet.
            </p>
        @endif

    </div>

    {{-- CATEGORY BREAKDOWN --}}
    <div class="bg-white p-8 rounded-[30px] border border-slate-100 shadow-sm lg:col-span-2">

        <h3 class="text-xl font-black text-slate-900 mb-6 uppercase tracking-tight">
            Category Breakdown
        </h3>

        <div class="space-y-4">

            @forelse($spending as $category => $amount)

                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">

                    <div class="flex items-center gap-4">

                        <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
                            <i class="fa-solid fa-tag"></i>
                        </div>

                        <span class="font-black text-slate-900 uppercase text-sm tracking-tight">
                            {{ ucfirst($category) }}
                        </span>

                    </div>

                    <span class="font-black text-red-600">
                        ₱{{ number_format($amount, 2) }}
                    </span>

                </div>

            @empty

                <p class="text-slate-400 font-medium text-center py-8">
                    No spending by category yet.
                </p>

            @endforelse

        </div>

    </div>

</div>
</section>
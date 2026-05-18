<x-sellerDash>

<style>
    .gradient-border-card {
        position: relative;
        background: #fff;
        border-radius: 2rem;
        overflow: hidden;
    }

    .gradient-border-card::before {
        content: '';
        position: absolute;
        inset: 0;
        padding: 2px;
        border-radius: inherit;
        background: linear-gradient(135deg, #b91c1c, #ea580c, #f97316);
        -webkit-mask: 
            linear-gradient(#fff 0 0) content-box, 
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0.15;
        transition: 0.3s ease;
        pointer-events: none;
    }

    .gradient-border-card:hover::before {
        opacity: 0.35;
    }
</style>

<div class="max-w-6xl mx-auto px-6 py-10 space-y-8">

   {{-- HEADER --}}
<div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-red-700 via-rose-600 to-orange-500 p-8 shadow-xl shadow-red-600/10">

    {{-- BACKGROUND GLOW --}}
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 flex items-center justify-between flex-wrap gap-6">

        {{-- LEFT --}}
        <div class="flex items-center gap-5">

            <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 flex items-center justify-center text-white shadow-inner">
                <i class="fa-solid fa-book-open-reader text-2xl"></i>
            </div>

            <div>
                <span class="inline-block text-[10px] font-black uppercase tracking-[0.25em] text-red-100 mb-2">
                    Seller Operations
                </span>

                <h2 class="text-3xl font-black text-white tracking-tight leading-none">
                    Lending Management
                </h2>

                <p class="text-sm text-red-100/80 mt-2 font-medium">
                    Review, approve, and manage borrower requests efficiently
                </p>
            </div>

        </div>

        {{-- RIGHT STATUS --}}
        <div class="bg-black/20 backdrop-blur-md border border-white/10 rounded-2xl px-5 py-4 text-white min-w-[180px]">

            <p class="text-[10px] uppercase tracking-[0.2em] text-red-100 font-black">
                Active Requests
            </p>

            <h3 class="text-3xl font-black mt-1">
                {{ $lendings->count() }}
            </h3>

            <p class="text-[11px] text-red-100/70 font-medium mt-1">
                Borrowing transactions tracked
            </p>

        </div>

    </div>

</div>

    {{-- LENDING LIST --}}
    @forelse($lendings as $lending)

        <div class="gradient-border-card p-6 shadow-sm hover:shadow-lg transition">

            <div class="flex flex-col md:flex-row gap-6">

                {{-- IMAGE --}}
                <div class="flex-shrink-0">
                    @if($lending->product->images && $lending->product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $lending->product->images[0]->image_path) }}"
                             class="w-24 h-24 rounded-2xl object-cover border border-slate-100">
                    @else
                        <div class="w-24 h-24 rounded-2xl bg-slate-100 flex items-center justify-center text-3xl">
                            📦
                        </div>
                    @endif
                </div>

                {{-- INFO --}}
                <div class="flex-1 space-y-2">

                    <div class="flex justify-between flex-wrap gap-2">
                        <div>
                            <h3 class="font-black text-slate-800 text-lg">
                                {{ $lending->product->name }}
                            </h3>
                            <p class="text-xs text-slate-400">
                                👤 {{ $lending->borrower->name }} ({{ $lending->borrower->email }})
                            </p>
                        </div>

                        {{-- STATUS --}}
                        <span class="text-[10px] font-black uppercase px-3 py-1 rounded-full
                            @if($lending->status == 'pending') bg-amber-50 text-amber-600
                            @elseif($lending->status == 'approved') bg-emerald-50 text-emerald-600
                            @elseif($lending->status == 'rejected') bg-rose-50 text-rose-600
                            @elseif($lending->status == 'returned') bg-slate-100 text-slate-600
                            @elseif($lending->status == 'overdue') bg-red-50 text-red-600
                            @endif">
                            {{ ucfirst($lending->status) }}
                        </span>
                    </div>

                    {{-- DETAILS --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs">

                        <div class="bg-slate-50 p-3 rounded-xl">
                            <p class="text-slate-400">Duration</p>
                            <p class="font-bold">{{ $lending->duration_days }} days</p>
                        </div>

                        <div class="bg-slate-50 p-3 rounded-xl">
                            <p class="text-slate-400">Due</p>
                            <p class="font-bold">{{ $lending->due_date->format('M d, Y') }}</p>
                        </div>

                        <div class="bg-slate-50 p-3 rounded-xl">
                            <p class="text-slate-400">Fee</p>
                            <p class="font-bold text-red-600">₱{{ number_format($lending->lending_fee, 2) }}</p>
                        </div>

                        <div class="bg-slate-50 p-3 rounded-xl">
                            <p class="text-slate-400">Collateral</p>
                            <p class="font-bold text-green-600">₱{{ number_format($lending->collateral_value, 2) }}</p>
                        </div>

                    </div>

                    {{-- COLLATERAL --}}
                    <div class="bg-blue-50 text-blue-700 p-3 rounded-xl text-xs">
                        🔒 <b>Collateral:</b> {{ ucfirst($lending->collateral_type) }} - {{ $lending->collateral_description }}
                    </div>

                    @if($lending->purpose)
                        <div class="bg-slate-50 p-3 rounded-xl text-xs text-slate-600">
                            📝 {{ $lending->purpose }}
                        </div>
                    @endif

                    {{-- ACTIONS --}}
                    <div class="flex gap-2 flex-wrap pt-2">

                        @if($lending->status == 'pending')

                            <form action="{{ route('lending.update-status', $lending->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl">
                                    Approve
                                </button>
                            </form>

                            <form action="{{ route('lending.update-status', $lending->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button class="px-4 py-2 bg-rose-600 text-white text-xs font-bold rounded-xl">
                                    Reject
                                </button>
                            </form>

                        @elseif($lending->status == 'approved')

                            <form action="{{ route('lending.update-status', $lending->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="returned">
                                <button class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl">
                                    Mark Returned
                                </button>
                            </form>

                        @endif

                    </div>

                    @if($lending->isOverdue())
                        <div class="bg-red-50 text-red-600 p-3 rounded-xl text-xs mt-2">
                            ⚠ Overdue item detected
                        </div>
                    @endif

                </div>
            </div>

        </div>

    @empty

        <div class="text-center py-20 text-slate-400">
            <div class="text-5xl mb-4">📭</div>
            <p class="font-semibold">No Lending Requests</p>
        </div>

    @endforelse

</div>

</x-sellerDash>
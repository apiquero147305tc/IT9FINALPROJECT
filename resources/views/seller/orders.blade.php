<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Order Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Custom Scrollbar styled matching the new brand system */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #f97316; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen bg-slate-50/60 antialiased">

    {{-- ========================================================= --}}
    {{-- BRANDED GRADIENT NAVIGATION BAR                           --}}
    {{-- ========================================================= --}}
    <nav class="bg-gradient-to-r from-rose-600 via-orange-500 to-amber-500 w-full shadow-lg shadow-orange-500/10 border-b border-orange-600/20 sticky top-0 z-50 py-4 px-4 md:px-6">
        <div class="max-w-5xl mx-auto flex items-center justify-between text-white">
            
            <div class="flex items-center gap-3">
                <a href="{{ route('seller.dash') }}" class="bg-white/10 p-2 rounded-xl border border-white/10 flex items-center justify-center backdrop-blur-sm transition hover:bg-white/20">
                    <i class="fa-solid fa-store text-base text-orange-200"></i>
                </a>
                <div>
                    <h1 class="text-base font-black tracking-tight leading-none">Seller Studio</h1>
                    <p class="text-[10px] text-orange-100/70 font-medium mt-1">Incoming Operations Queue</p>
                </div>
            </div>

            <a href="{{ route('seller.dash') }}" class="inline-flex items-center gap-1.5 bg-black/15 backdrop-blur-md px-3 py-2 rounded-xl text-[10px] font-bold uppercase tracking-wider border border-white/10 text-white hover:bg-black/25 transition">
                <i class="fa-solid fa-arrow-left text-[9px]"></i> Dashboard
            </a>
        </div>
    </nav>

    {{-- ========================================================= --}}
    {{-- MAIN HUB CONTENT SPACE                                    --}}
    {{-- ========================================================= --}}
    <main class="max-w-5xl mx-auto p-4 md:p-8 space-y-8">
        
        {{-- Section Title Block --}}
        <div class="border-b border-slate-200/60 pb-5">
            <h2 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-bell-concierge text-orange-500"></i> Order Processing Hub
            </h2>
            <p class="text-xs text-slate-400 mt-1">Review checkout payloads, manage item permissions, and dispatch responses.</p>
        </div>

        {{-- Orders Pipeline Loop Container --}}
        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 md:p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 group transition-all duration-300 hover:shadow-md hover:border-orange-200/60">
                    
                    {{-- Left Component: Item Thumbnail & Detailed Registry Meta --}}
                    <div class="flex items-center gap-4 w-full flex-1">
                        <div class="w-20 h-20 bg-slate-50 rounded-xl flex-shrink-0 flex items-center justify-center border border-slate-100 overflow-hidden shadow-inner">
                             @if($order->product && $order->product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" class="w-full h-full object-cover">
                             @else
                                <div class="text-slate-300">
                                    <i class="fa-solid fa-box text-xl"></i>
                                </div>
                             @endif
                        </div>
                        
                        <div class="space-y-1.5 flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                {{-- Smart Badge Configuration --}}
                                @if($order->status == 'pending')
                                    <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-600 border border-amber-100">
                                        Pending Action
                                    </span>
                                @elseif($order->status == 'accepted' || $order->status == 'completed')
                                    <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        Accepted
                                    </span>
                                @else
                                    <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-600 border border-rose-100">
                                        Declined
                                    </span>
                                @endif

                                <span class="text-[11px] font-medium text-slate-400 flex items-center gap-1">
                                    <i class="fa-regular fa-clock text-[10px]"></i> {{ $order->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <h3 class="text-base font-bold text-slate-800 tracking-tight truncate">
                                {{ $order->product->name ?? 'Deleted Item Reference' }}
                            </h3>
                            
                            <p class="text-xs text-slate-500 font-medium">
                                Customer: <span class="text-slate-700 font-bold">{{ $order->user->name ?? 'Guest Account' }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Right Component: Pricing & Workflow State Decision buttons --}}
                    <div class="flex md:flex-col items-center md:items-end justify-between md:justify-center gap-4 w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 border-slate-100">
                        <div class="text-left md:text-right">
                            <p class="text-xl font-black text-slate-900 tracking-tight">₱{{ number_format($order->total_price, 2) }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">Total Gross Value</p>
                        </div>

                        <div class="flex items-center gap-2">
                            @if($order->status == 'pending')
                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-rose-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:opacity-95 active:scale-95 transition-all shadow-md shadow-orange-500/10">
                                        <i class="fa-solid fa-check"></i> Accept
                                    </button>
                                </form>

                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="declined">
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-slate-50 active:scale-95 transition-all shadow-sm">
                                        <i class="fa-solid fa-xmark"></i> Reject
                                    </button>
                                </form>
                            @else
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider border border-slate-200 px-4 py-2 bg-slate-50 rounded-xl flex items-center gap-1.5 select-none">
                                    <i class="fa-solid fa-box-archive text-[11px]"></i> {{ $order->status }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            @empty
                {{-- Empty Queue Branded State Placeholder --}}
                <div class="text-center py-24 bg-white border border-slate-100 rounded-2xl shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 text-slate-300 border border-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
                        <i class="fa-regular fa-inbox"></i>
                    </div>
                    <h3 class="text-slate-700 font-bold text-sm">No incoming orders in queue</h3>
                    <p class="text-slate-400 text-xs mt-1">When customers buy or request items, they will arrive here live.</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Order Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        body { background-color: #ffffff; font-family: 'Inter', sans-serif; color: #0f172a; }
        
        /* 🔴 Red Branded Navbar */
        .nav-branded { background-color: #dc2626; border-bottom: 1px solid rgba(0,0,0,0.05); }
        
        /* Status Badges */
        .badge-pending { background-color: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }
        .badge-accepted { background-color: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
        .badge-declined { background-color: #450a0a; color: #ffffff; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen bg-slate-50/50">

    <nav class="nav-branded px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <div class="flex items-center gap-2">
            <a href="{{ route('seller.dash') }}" class="bg-white p-1.5 rounded-xl shadow-sm hover:scale-110 transition-all">
                <span class="text-xl">🏪</span>
            </a>
            <h1 class="text-sm font-extrabold tracking-tight uppercase text-white">
                Seller Studio | <span class="opacity-60">Orders</span>
            </h1>
        </div>
        <a href="{{ route('seller.dash') }}" class="text-[10px] font-black uppercase tracking-widest text-rose-100 hover:text-white transition">
            Back to Dashboard
        </a>
    </nav>

    <main class="max-w-4xl mx-auto p-6 md:p-12">
        
        <div class="mb-12">
            <h2 class="text-6xl font-black tracking-tighter uppercase text-slate-900 leading-none">Incoming</h2>
            <p class="text-xs font-bold text-red-600 uppercase tracking-[0.3em] mt-2">Manage customer requests</p>
        </div>

        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-xl shadow-slate-900/5 p-8 flex flex-col md:flex-row justify-between items-center gap-6 group transition-all hover:border-red-200">
                    
                    <div class="flex items-center gap-6 w-full">
                        <div class="w-24 h-24 bg-slate-50 rounded-3xl flex items-center justify-center text-3xl border border-slate-100 overflow-hidden shadow-sm">
                             @if($order->product && $order->product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" class="w-full h-full object-cover">
                             @else
                                <span class="opacity-20 text-2xl">📦</span>
                             @endif
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full badge-{{ $order->status }}">
                                    {{ $order->status }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase italic">
                                    {{ $order->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-black text-slate-900 leading-tight">
                                {{ $order->product->name ?? 'Deleted Item' }}
                            </h3>
                            <p class="text-xs font-bold text-slate-400 uppercase mt-1">
                                Customer: <span class="text-slate-900">{{ $order->user->name ?? 'Guest' }}</span>
                            </p>
                            <p class="text-xl font-black text-red-600 mt-2">₱{{ number_format($order->total_price, 2) }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3 w-full md:w-auto">
                        @if($order->status == 'pending')
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="w-full md:px-8 py-4 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-slate-900 hover:scale-105 active:scale-95 transition-all shadow-lg shadow-red-600/20">
                                    Accept
                                </button>
                            </form>

                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="declined">
                                <button type="submit" class="w-full md:px-8 py-4 bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-red-600 hover:text-white hover:scale-105 active:scale-95 transition-all">
                                    Reject
                                </button>
                            </form>
                        @else
                            <div class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] italic border-2 border-slate-50 px-8 py-4 rounded-2xl">
                                {{ $order->status }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-32 bg-white border-4 border-dashed border-slate-100 rounded-[3rem]">
                    <p class="text-6xl mb-4 text-slate-200">📭</p>
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.5em]">No orders in the queue</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>
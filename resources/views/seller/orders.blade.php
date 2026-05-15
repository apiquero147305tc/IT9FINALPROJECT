<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Order Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        
        body { 
            background-color: #fffaf9; 
            font-family: 'Inter', sans-serif; 
            color: #1e1b1a; 
        }

        /* 🔴 Maximum Impact Red Navigation */
        .nav-branded { 
            background-color: #b91c1c; 
            border-bottom: 4px solid #7f1d1d; 
        }

        /* Status Badge Styling */
        .badge-pending { background-color: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }
        .badge-accepted { background-color: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
        .badge-declined { background-color: #450a0a; color: #fecaca; }

        ::selection {
            background: #991b1b;
            color: white;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50/30">

    <nav class="nav-branded px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-2xl">
        <div class="flex items-center gap-4">
            <a href="{{ route('seller.dash') }}" class="bg-white p-2 rounded-xl shadow-md hover:scale-110 transition-all group">
                <span class="text-xl group-hover:-translate-x-1 inline-block transition-transform">⬅️</span>
            </a>
            <h1 class="text-xs font-black tracking-widest uppercase text-white">
                Seller Studio | <span class="text-red-200">Order Hub</span>
            </h1>
        </div>
        <a href="{{ route('seller.dash') }}" class="text-[10px] font-black uppercase tracking-widest text-white/80 hover:text-white transition">
            Back to Dashboard
        </a>
    </nav>

    <main class="max-w-4xl mx-auto p-6 md:p-12">
        
        <div class="mb-12">
            <h2 class="text-6xl font-black tracking-tighter uppercase text-slate-900 leading-none">Incoming</h2>
            <div class="h-2 w-16 bg-red-700 mt-4 rounded-full"></div>
            <p class="text-[10px] font-bold text-red-700 uppercase tracking-[0.4em] mt-6">Manage customer requests</p>
        </div>

        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="bg-white border border-red-100 rounded-[2.5rem] shadow-xl shadow-red-900/5 p-8 flex flex-col md:flex-row justify-between items-center gap-6 group transition-all hover:border-red-300">
                    
                    <div class="flex items-center gap-6 w-full">
                        <div class="w-24 h-24 bg-red-50 rounded-3xl flex items-center justify-center text-3xl border border-red-100 overflow-hidden shadow-inner">
                             @if($order->product && $order->product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" class="w-full h-full object-cover">
                             @else
                                <span class="opacity-20 text-2xl">📦</span>
                             @endif
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full badge-{{ $order->status }}">
                                    {{ $order->status }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase italic">
                                    {{ $order->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-black text-slate-900 leading-tight uppercase tracking-tight">
                                {{ $order->product->name ?? 'Deleted Item' }}
                            </h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase mt-1">
                                Customer: <span class="text-red-700">{{ $order->user->name ?? 'Guest' }}</span>
                            </p>
                            <p class="text-2xl font-black text-red-700 mt-2">₱{{ number_format($order->total_price, 2) }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3 w-full md:w-auto">
                        @if($order->status == 'pending')
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="w-full md:px-10 py-4 bg-red-700 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-black hover:scale-105 active:scale-95 transition-all shadow-xl shadow-red-700/20">
                                    Accept
                                </button>
                            </form>

                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="declined">
                                <button type="submit" class="w-full md:px-10 py-4 bg-red-50 text-red-700 text-[10px] font-black uppercase tracking-widest rounded-2xl border-2 border-red-100 hover:bg-red-700 hover:text-white hover:scale-105 active:scale-95 transition-all">
                                    Reject
                                </button>
                            </form>
                        @else
                            <div class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] italic border-2 border-slate-100 px-10 py-4 rounded-2xl bg-slate-50">
                                {{ $order->status }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-32 bg-white border-4 border-dashed border-red-100 rounded-[4rem]">
                    <p class="text-7xl mb-6 grayscale opacity-20">📭</p>
                    <p class="text-[10px] font-black text-red-200 uppercase tracking-[0.6em]">No orders in the queue</p>
                </div>
            @endforelse
        </div>
        
        <p class="text-center mt-20 text-[9px] font-black text-slate-300 uppercase tracking-[0.5em]">CraveCart Student Marketplace</p>
    </main>
</body>
</html>
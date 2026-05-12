<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Seller Studio</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        
        body { 
            background-color: #ffffff; 
            font-family: 'Inter', sans-serif; 
            color: #0f172a;
        }

        /* ✅ Branded Solid Orange Navbar */
        .nav-branded { 
            background-color: #fb923c; 
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .stat-orange { background: linear-gradient(135deg, #f83600 0%, #f9d423 100%); }
        .stat-peach { 
            background-color: #fffaf5; 
            border: 1px solid #ffedd5; 
        }
        .stat-glass { 
            background: #ffffff; 
            border: 1px solid #f1f5f9;
        }

        @keyframes custom-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.7; }
        }
        .animate-notif { animation: custom-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</head>

<body class="min-h-screen">

    <nav class="nav-branded px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="bg-white p-1.5 rounded-xl shadow-sm">
                    <span class="text-xl">🏪</span>
                </div>
                <div>
                    <h1 class="text-sm font-extrabold tracking-tight uppercase text-orange-950 leading-none">
                        CraveCart | <span class="opacity-70">Seller Studio</span>
                    </h1>
                    <p class="text-[10px] text-orange-900/60 font-bold uppercase tracking-widest mt-1">
                        {{ Auth::user()->shop_name ?? 'My Shop' }} | Active
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-8">
            <div class="hidden md:flex items-center gap-8 text-xs font-black uppercase tracking-widest text-orange-950/80">
                <a href="{{ route('seller.orders') }}" class="relative hover:text-white transition flex items-center gap-2">
                    Notifications
                    @if($notifCount > 0)
                        <span class="flex h-2 w-2 rounded-full bg-white animate-notif"></span>
                    @endif
                </a>
                <a href="{{ route('messages.inbox') }}" class="hover:text-white transition">Lending</a>
            </div>
            
            <div class="flex items-center gap-4 pl-6 border-l border-orange-900/10">
                <a href="{{ route('seller.profile') }}" 
                   class="w-10 h-10 rounded-full bg-white/40 flex items-center justify-center text-[11px] font-black border border-white/20 uppercase text-orange-950 hover:bg-white/60 hover:scale-105 transition-all shadow-sm"
                   title="Edit Seller Profile">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </a>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-[10px] bg-orange-950 text-white px-6 py-2 rounded-lg hover:bg-black transition font-black uppercase tracking-widest">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto p-6 md:p-12">
        <div class="mb-12">
            <h2 class="text-6xl font-black tracking-tighter uppercase text-slate-900 leading-none"></h2>
            <p class="text-xs font-bold text-orange-400 uppercase tracking-[0.3em] mt-2">Store Overview & Performance</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="stat-orange rounded-[3rem] p-10 text-white relative overflow-hidden shadow-2xl shadow-orange-500/20 transition hover:scale-[1.02]">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-4">My Inventory</p>
                <h3 class="text-7xl font-black leading-none">{{ $products->count() }}</h3>
                <div class="absolute -right-4 -bottom-4 opacity-20 text-9xl">📦</div>
            </div>

            <div class="stat-peach rounded-[3rem] p-10 text-orange-950 relative overflow-hidden shadow-2xl shadow-orange-200/50 transition hover:scale-[1.02]">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-4">Total Revenue</p>
                <h3 class="text-6xl font-black italic text-orange-900 leading-none">₱{{ number_format($totalEarnings, 2) }}</h3>
                <div class="absolute -right-4 -bottom-4 opacity-10 text-9xl">💰</div>
            </div>

            <a href="{{ route('seller.orders') }}" class="stat-glass rounded-[3rem] p-10 text-slate-900 relative overflow-hidden shadow-2xl shadow-orange-900/5 transition hover:scale-[1.02] group">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Pending Orders</p>
                <h3 class="text-7xl font-black group-hover:text-orange-600 transition-colors leading-none">{{ $notifCount }}</h3>
                <div class="absolute -right-4 -bottom-4 opacity-5 text-9xl text-orange-600">📊</div>
            </a>
        </div>

        <div class="flex justify-between items-end mb-8 px-2">
            <div>
                <h3 class="text-3xl font-black uppercase tracking-tight text-slate-900">Active Inventory</h3>
                <div class="h-2 w-16 bg-orange-500 mt-2 rounded-full"></div>
            </div>
            <a href="{{ route('products.create') }}" class="bg-orange-600 text-white px-10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-700 transition-all shadow-lg shadow-orange-600/20">
                + Add Product
            </a>
        </div>

        <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-2xl shadow-slate-900/5 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Product Details</th>
                        <th class="px-10 py-8 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-10 py-10">
                            <div class="flex items-center gap-8">
                                <div class="w-24 h-24 bg-orange-50 rounded-3xl flex items-center justify-center text-3xl border border-transparent group-hover:border-orange-100 transition-all overflow-hidden shadow-sm">
                                    @if($product->images && $product->images->isNotEmpty())
                                        {{-- Accessing the first image from the collection --}}
                                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <span class="opacity-50">🛒</span>
                                    @endif
                                </div>

                                <div>
                                    <p class="text-2xl font-black text-slate-900 leading-none mb-3">{{ $product->name }}</p>
                                    <div class="flex items-center gap-4">
                                        <span class="text-lg font-black text-orange-600 italic">₱{{ number_format($product->price, 2) }}</span>
                                        <span class="text-slate-200">|</span>
                                        <span class="text-xs text-slate-400 font-bold uppercase tracking-widest">Stock: {{ $product->stock }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-10 text-right">
                            <a href="{{ route('products.edit', $product->id) }}" class="inline-block border-2 border-slate-100 px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-orange-600 hover:border-orange-200 hover:bg-orange-50 transition-all">Edit Product</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="p-32 text-center">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">No products currently in studio</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <a href="{{ route('messages.inbox') }}" class="fixed bottom-10 right-10 bg-orange-600 text-white flex items-center gap-4 px-10 py-6 rounded-[2.5rem] shadow-2xl shadow-orange-600/40 hover:scale-110 transition-all font-black text-[10px] uppercase tracking-widest z-50">
        <span class="text-lg">💬</span> INBOX
    </a>
</body>
</html>
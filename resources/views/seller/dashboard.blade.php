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
            background-color: #fffaf9; 
            font-family: 'Inter', sans-serif; 
            color: #1e1b1a;
        }

        /* 🔴 Maximum Impact Red Navigation */
        .nav-branded { 
            background-color: #b91c1c; /* Sharp Crimson Red */
            border-bottom: 4px solid #7f1d1d; /* Deep Blood Red base */
        }
        
        /* 🔥 Deep Lava Gradient for Stats */
        .stat-orange { 
            background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%); 
            box-shadow: 0 20px 40px -15px rgba(153, 27, 27, 0.4);
        }

        /* 🍑 Soft Rose hue for middle card */
        .stat-peach { 
            background-color: #fef2f2; 
            border: 1px solid #fee2e2; 
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
        
        ::selection {
            background: #991b1b;
            color: white;
        }
    </style>
</head>

<body class="min-h-screen">

    <nav class="nav-branded px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-2xl">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="bg-white p-1.5 rounded-xl shadow-sm">
                    <span class="text-xl">🏪</span>
                </div>
                <div>
                    <h1 class="text-sm font-black tracking-tight uppercase text-white leading-none">
                        CraveCart | <span class="text-red-200">Seller Studio</span>
                    </h1>
                    <p class="text-[10px] text-red-100 font-bold uppercase tracking-widest mt-1">
                        {{ Auth::user()->shop_name ?? 'My Shop' }} | <span class="text-white decoration-red-300 underline">Active</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-8">
            <div class="hidden md:flex items-center gap-8 text-[10px] font-black uppercase tracking-[0.2em] text-white">
                <a href="{{ route('seller.orders') }}" class="relative hover:text-red-100 transition flex items-center gap-2">
                    Notifications
                    @if($notifCount > 0)
                        <span class="flex h-2.5 w-2.5 rounded-full bg-white animate-notif border border-red-800"></span>
                    @endif
                </a>
                <a href="{{ route('seller.messages') }}" class="hover:text-red-100 transition">Messages</a>
            </div>
            
            <div class="flex items-center gap-4 pl-6 border-l border-white/20">
                @if(Route::has('seller.profile'))
                    <a href="{{ route('seller.profile') }}" 
                       class="w-10 h-10 rounded-full bg-white text-red-700 flex items-center justify-center text-[11px] font-black border-2 border-red-900/10 uppercase hover:scale-105 transition-all shadow-md">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </a>
                @else
                    <div class="w-10 h-10 rounded-full bg-white text-red-700 flex items-center justify-center text-[11px] font-black border-2 border-red-900/10 uppercase shadow-md">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                @endif
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-[10px] bg-red-950 text-white px-6 py-2.5 rounded-xl hover:bg-black transition-all font-black uppercase tracking-widest">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto p-6 md:p-12">
        <div class="mb-12">
            <h2 class="text-5xl font-black tracking-tighter uppercase text-slate-900 leading-none">
                Welcome back, {{ explode(' ', Auth::user()->name)[0] }}
            </h2>
            <p class="text-[10px] font-black text-red-700 uppercase tracking-[0.4em] mt-4">Store Overview & Performance</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="stat-orange rounded-[2.5rem] p-10 text-white relative overflow-hidden transition hover:scale-[1.02]">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-4">Inventory</p>
                <h3 class="text-7xl font-black leading-none">{{ $products->count() }}</h3>
                <div class="absolute -right-4 -bottom-4 opacity-20 text-9xl text-white">📦</div>
            </div>

            <div class="stat-peach rounded-[2.5rem] p-10 text-red-950 relative overflow-hidden shadow-2xl shadow-red-100 transition hover:scale-[1.02]">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-4">Total Revenue</p>
                <h3 class="text-6xl font-black italic text-red-800 leading-none">₱{{ number_format($totalEarnings, 2) }}</h3>
                <div class="absolute -right-4 -bottom-4 opacity-[0.05] text-9xl text-red-900">💰</div>
            </div>

            <a href="{{ route('seller.orders') }}" class="stat-glass rounded-[2.5rem] p-10 text-slate-900 relative overflow-hidden shadow-lg transition hover:border-red-300 group hover:scale-[1.02]">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Pending Orders</p>
                <h3 class="text-7xl font-black group-hover:text-red-700 transition-colors leading-none">{{ $notifCount }}</h3>
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-9xl text-red-700">📊</div>
            </a>
        </div>

        <div class="flex justify-between items-end mb-10 px-2">
            <div>
                <h3 class="text-3xl font-black uppercase tracking-tight text-slate-900">Active Inventory</h3>
                <div class="h-2 w-16 bg-red-700 mt-2 rounded-full"></div>
            </div>
            <a href="{{ route('products.create') }}" class="bg-red-700 text-white px-10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-red-700/20">
                + Add Product
            </a>
        </div>

        <div class="bg-white border border-red-100 rounded-[2rem] shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-red-50/50 border-b border-red-100">
                    <tr>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-red-900/40">Product Details</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-red-900/40 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-red-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-red-50/30 transition-colors group">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-20 bg-white rounded-2xl overflow-hidden border border-red-100 shadow-sm">
                                    @if($product->images && $product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-2xl bg-red-50/50">🛒</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-slate-900 mb-1">{{ $product->name }}</p>
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-black text-red-700">₱{{ number_format($product->price, 2) }}</span>
                                        <span class="text-red-200">|</span>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Stock: {{ $product->stock }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <a href="{{ route('products.edit', $product->id) }}" class="inline-block border-2 border-slate-100 px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-700 hover:border-red-200 hover:bg-red-50 transition-all">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="py-24 text-center">
                            <p class="text-[10px] font-black text-red-200 uppercase tracking-widest">No products currently in studio</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <a href="{{ route('seller.messages') }}" class="fixed bottom-8 right-8 bg-red-700 text-white flex items-center gap-3 px-8 py-5 rounded-full shadow-2xl hover:bg-black transition-all font-black text-[10px] uppercase tracking-widest z-50">
        <span class="text-lg">💬</span> Messages
    </a>

</body>
</html>
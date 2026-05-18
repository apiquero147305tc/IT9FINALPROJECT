<x-sellerDash>
    {{-- ========================================================= --}}
    {{-- SYSTEM STYLE OVERRIDE TO FORCE A SINGLE NAVBAR            --}}
    {{-- ========================================================= --}}
    <style>
        header, 
        .bg-white.shadow-sm.sticky,
        div[class*="sticky"][class*="bg-white"] { 
            display: none !important; 
        }

        /* Fluent Gradient Border Effect Masking */
        .gradient-border-card {
            position: relative;
            background: #ffffff;
            border: 2px solid transparent;
            background-clip: padding-box;
        }
        .gradient-border-card::after {
            content: '';
            position: absolute;
            top: -2px; bottom: -2px; left: -2px; right: -2px;
            background: linear-gradient(135deg, #b91c1c 0%, #ea580c 50%, #f97316 100%);
            border-radius: inherit;
            z-index: -1;
            opacity: 0.15;
            transition: opacity 0.3s ease;
        }
        .gradient-border-card:hover::after {
            opacity: 0.35;
        }
    </style>

    {{-- ========================================================= --}}
    {{-- PILL-SHAPE STUDIO HERO BANNER                             --}}
    {{-- ========================================================= --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-red-700 via-rose-600 to-red-600 rounded-[2rem] p-6 -mt-4 mb-8 text-white shadow-xl shadow-red-700/10">
        <div class="relative z-10 flex items-center justify-between gap-4">
            
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/10 shadow-inner">
                    <i class="fa-solid fa-store text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight leading-none">Seller Studio</h1>
                    <p class="text-xs font-bold text-red-200/80 uppercase tracking-widest mt-1.5">Control Panel & Performance</p>
                </div>
            </div>

            <div class="bg-black/20 backdrop-blur-md pl-4 pr-2 py-2 rounded-2xl border border-white/10 flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-black tracking-wide leading-none text-white">Seller Account</p>
                    <span class="text-[9px] text-red-200 font-black uppercase tracking-widest block mt-1">Verified Merchant</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-white text-red-600 font-black text-sm flex items-center justify-center shadow-md uppercase">
                    {{ substr(Auth::user()->shop_name ?? 'S', 0, 1) }}
                </div>
            </div>

        </div>
    </div>

    {{-- ========================================= --}}
    {{-- MAIN CONFIGURATION CONTROL HUB WORKSPACE  --}}
    {{-- ========================================= --}}
    <div class="space-y-8">

        {{-- 4-COLUMN STATS GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Metric 1: My Inventory --}}
            <div class="gradient-border-card rounded-[2rem] p-6 shadow-xl shadow-slate-900/5 flex flex-col justify-between min-h-[160px] group transition-all duration-300">
                <div class="flex justify-between items-start w-full">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">My Inventory</span>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tight leading-none">{{ $products->count() }}</h2>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-sm shadow-inner group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 font-medium leading-relaxed mt-4">Total catalog items tracked inside your storefront window.</p>
            </div>

            {{-- Metric 2: Active Borrowing --}}
            <div class="gradient-border-card rounded-[2rem] p-6 shadow-xl shadow-slate-900/5 flex flex-col justify-between min-h-[160px] group transition-all duration-300">
                <div class="flex justify-between items-start w-full">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">Active Lease</span>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tight leading-none">
                            {{ $products->where('is_lendable', true)->count() }}
                        </h2>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-sm shadow-inner group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 font-medium leading-relaxed mt-4">Storefront catalog objects actively toggled inside lendable loops.</p>
            </div>

            {{-- Metric 3: Total Earnings --}}
            <div class="gradient-border-card rounded-[2rem] p-6 shadow-xl shadow-slate-900/5 flex flex-col justify-between min-h-[160px] group transition-all duration-300">
                <div class="flex justify-between items-start w-full">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">Total Revenue</span>
                        <h2 class="text-3xl font-black text-slate-800 tracking-tight leading-none">₱{{ number_format($totalEarnings, 0) }}</h2>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-sm shadow-inner group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-peso-sign"></i>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 font-medium leading-relaxed mt-4">Gross capital generated from fulfilled buyouts & borrow contracts.</p>
            </div>

            {{-- Metric 4: Pending Operations Queue --}}
            <div class="gradient-border-card rounded-[2rem] p-6 shadow-xl shadow-slate-900/5 flex flex-col justify-between min-h-[160px] group transition-all duration-300">
                <div class="flex justify-between items-start w-full">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">Pending Orders</span>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tight leading-none">{{ $notifCount }}</h2>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-sm shadow-inner group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 font-medium leading-relaxed mt-4">Active checkout requests requiring immediate routing approvals.</p>
            </div>
        </div>

        {{-- ACTIVE INVENTORY DATA MATRIX LAYER --}}
        <section class="gradient-border-card rounded-[2rem] shadow-xl shadow-slate-900/5 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
                <div>
                    <h2 class="font-extrabold text-xl text-slate-800 tracking-tight">Active Inventory</h2>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Manage your storefront listings and item options entries.</p>
                </div>
                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-red-700 via-red-600 to-orange-500 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider hover:opacity-95 transition shadow-md shadow-red-600/10">
                    <i class="fa-solid fa-plus text-xs"></i> Add Product
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="px-8 py-4">Product Info & Visibility Type</th>
                            <th class="px-6 py-4">Financials & Stock Status</th>
                            <th class="px-8 py-4 text-right">Actions Area Options</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-start gap-4">
                                        @if($product->images && $product->images->isNotEmpty())
                                            <img src="{{ asset('storage/'.$product->images[0]->image_path) }}" alt="" class="w-14 h-14 object-cover rounded-xl border border-slate-100 shadow-sm flex-shrink-0">
                                        @else
                                            <div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 border border-slate-200/60 flex-shrink-0">
                                                <i class="fa-solid fa-image text-sm"></i>
                                            </div>
                                        @endif
                                        <div class="space-y-1">
                                            <p class="font-bold text-slate-800 text-base tracking-tight leading-tight">{{ $product->name }}</p>
                                            
                                            @if($product->is_lendable)
                                                <div>
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black tracking-wide bg-orange-50 text-orange-600 border border-orange-100/50">
                                                        📚 Borrowable
                                                    </span>
                                                    <p class="text-[11px] text-slate-400 mt-0.5 font-medium">Customers can reserve or rent this asset item temporarily.</p>
                                                </div>
                                            @else
                                                <div>
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black tracking-wide bg-slate-100 text-slate-500">
                                                        🛍️ Sale Only
                                                    </span>
                                                    <p class="text-[11px] text-slate-400 mt-0.5 font-medium">Standard fixed retail checkout format. Cannot be borrowed.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 align-top">
                                    <div class="space-y-1">
                                        <p class="font-black text-slate-900 text-lg tracking-tight leading-none">₱{{ number_format($product->price, 2) }}</p>
                                        @if($product->is_lendable)
                                            <p class="text-[11px] text-orange-600 font-bold">Lending baseline rate / cycle</p>
                                        @else
                                            <p class="text-[11px] text-slate-400 font-medium">Fixed marketplace retail price</p>
                                        @endif
                                        <p class="text-[12px] text-slate-500 pt-1 font-medium">Stock Available: <span class="font-bold text-slate-700">{{ $product->stock }} units</span></p>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    {{-- ========================================== --}}
                                    {{-- ACTIONS COLUMN WITH EXPLICIT ACCENT LABELS  --}}
                                    {{-- ========================================== --}}
                                    <div class="flex items-center justify-end gap-3">
                                        
                                        {{-- Contextual Visibility Mode Flag Descriptions --}}
                                        <div class="text-right hidden md:block">
                                            @if($product->is_lendable)
                                                <span class="text-[10px] font-black uppercase text-orange-600 tracking-wider">Borrowable</span>
                                                <p class="text-[9px] text-slate-400 font-medium -mt-0.5">Toggle configuration mode</p>
                                            @else
                                                <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Retail Sale Only</span>
                                                <p class="text-[9px] text-slate-400 font-medium -mt-0.5">Lending functions locked</p>
                                            @endif
                                        </div>

                                        {{-- Interactive Function Button Core Array --}}
                                        <div class="flex items-center gap-1.5 bg-slate-50 border border-slate-100 rounded-xl p-1 shadow-inner">
                                            <form action="{{ route('products.toggle-lendable', $product->id) }}" method="POST">
                                                @csrf @method('patch')
                                                <button type="submit" class="p-2 rounded-lg bg-white border border-slate-200/80 text-slate-400 hover:text-orange-500 shadow-sm transition" title="{{ $product->is_lendable ? 'Switch to Sale Only' : 'Switch to Borrowable Mode' }}">
                                                    <i class="fa-solid {{ $product->is_lendable ? 'fa-toggle-on text-orange-500' : 'fa-toggle-off' }} text-base"></i>
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('products.edit', $product->id) }}" class="p-2 rounded-lg bg-white border border-slate-200/80 text-slate-500 hover:text-slate-800 shadow-sm transition" title="Edit Product Details">
                                                <i class="fa-regular fa-pen-to-square text-sm"></i>
                                            </a>
                                            
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product entry?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg bg-rose-50/50 border border-rose-100 text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition" title="Purge Record">
                                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-8 py-16 text-center text-slate-400">
                                    <i class="fa-solid fa-box-open text-3xl mb-3 opacity-40"></i>
                                    <p class="text-sm font-semibold">No active storefront listings available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- RECENT ORDERS CHRONOLOGICAL LEDGER --}}
        <section class="gradient-border-card rounded-[2rem] shadow-xl shadow-slate-900/5 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                <h2 class="font-extrabold text-xl text-slate-800 tracking-tight">Recent Orders</h2>
                <p class="text-xs text-slate-400 mt-1 font-medium">Live transaction operations and tracking pipeline ledger.</p>
            </div>
            
            <div class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <div class="px-8 py-5 hover:bg-slate-50/20 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1.5 text-sm">
                                <p><span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] mr-2">Buyer:</span> <span class="font-semibold text-slate-700">{{ $order->user->name ?? 'Unknown Profile' }}</span></p>
                                <p><span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] mr-2">Item:</span> <span class="font-medium text-slate-800">{{ $order->product->name ?? 'Registry Asset Terminated' }}</span></p>
                                <p class="text-xs text-slate-400 pt-0.5 flex items-center gap-1 font-medium"><i class="fa-regular fa-clock"></i>{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex sm:flex-col items-baseline sm:items-end justify-between sm:justify-center gap-2 border-t sm:border-0 pt-3 sm:pt-0 border-slate-100">
                                <p class="text-xl font-black text-slate-900 tracking-tight">₱{{ number_format($order->total_price, 2) }}</p>
                                <span class="text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wide border
                                    {{ $order->status == 'completed' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 
                                       ($order->status == 'cancelled' ? 'bg-rose-50 border-rose-100 text-rose-600' : 'bg-amber-50 border-amber-100 text-amber-600') }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-8 py-16 text-center text-slate-400">
                        <i class="fa-solid fa-inbox text-3xl mb-3 opacity-40"></i>
                        <p class="text-sm font-semibold">No system orders captured yet</p>
                    </div>
                @endforelse
            </div>
            
            @if($orders->count())
                <div class="px-8 py-5 border-t border-slate-100 text-center bg-slate-50/30">
                    <a href="{{ route('seller.orders') }}" class="inline-flex items-center gap-1.5 text-slate-500 hover:text-slate-800 text-xs font-bold uppercase tracking-wider transition">
                        View Complete Logs Registry <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            @endif
        </section>

    </div>
</x-sellerDash>
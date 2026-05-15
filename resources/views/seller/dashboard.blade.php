<x-sellerDash>

<div style="padding: 20px; max-width: 1200px; margin: 0 auto;">

<<<<<<< HEAD
    <!-- HEADER SECTION -->
    <div style="background: linear-gradient(135deg, #dd0d22 0%, #b30b1b 100%); color: white; padding: 30px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="margin: 0 0 10px 0; font-size: 1.8rem;">🍱 CraveCart | Seller Studio</h2>
        <p style="margin: 0; opacity: 0.9; font-size: 1rem;">Store Overview & Performance</p>

        <div style="margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('seller.profile') }}" style="padding: 10px 20px; background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 0.9rem;">🚁 Edit Profile</a>
            <a href="{{ route('seller.orders') }}" style="padding: 10px 20px; background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 0.9rem;">📊 Order Hub</a>
            <a href="{{ route('lending.seller') }}" style="padding: 10px 20px; background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 0.9rem;">📚 Lending Management</a>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
            <h3 style="margin: 0 0 15px 0; color: #666; font-size: 1rem;">My Inventory</h3>
            <div style="font-size: 2.5rem; font-weight: bold; color: #dd0d22; margin-bottom: 10px;">{{ $products->count() }}</div>
            <div style="font-size: 2rem;">📦</div>
        </div>
        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
            <h3 style="margin: 0 0 15px 0; color: #666; font-size: 1rem;">Total Revenue</h3>
            <div style="font-size: 2.5rem; font-weight: bold; color: #dd0d22; margin-bottom: 10px;">₱{{ number_format($totalEarnings, 2) }}</div>
            <div style="font-size: 2rem;">💰</div>
        </div>
        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
            <h3 style="margin: 0 0 15px 0; color: #666; font-size: 1rem;">Pending Orders</h3>
            <div style="font-size: 2.5rem; font-weight: bold; color: #dd0d22; margin-bottom: 10px;"><strong>{{ $notifCount }}</strong></div>
            <div style="font-size: 2rem;">📊</div>
        </div>
    </div>

    <!-- PRODUCTS SECTION -->
    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 style="margin: 0; color: #333; font-size: 1.5rem;">🛍️ Active Inventory</h2>
            <a href="{{ route('products.create') }}" style="padding: 10px 20px; background: #dd0d22; color: white; text-decoration: none; border-radius: 25px; font-weight: bold;">+ Add Product</a>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #f3e3cb;">
                    <th style="text-align: left; padding: 15px; color: #666; font-size: 0.9rem;">Product Details</th>
                    <th style="text-align: left; padding: 15px; color: #666; font-size: 0.9rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                @if($product->images && $product->images->isNotEmpty())
                                    <img src="{{ asset('storage/'.$product->images[0]->image_path) }}" alt="Product Image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                                @else
                                    <div style="width: 60px; height: 60px; background: #f3e3cb; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🛒</div>
                                @endif
                                <div>
                                    <div style="font-weight: bold; color: #333; margin-bottom: 5px;">{{ $product->name }}</div>
                                    <div style="color: #dd0d22; font-weight: bold; margin-bottom: 3px;">₱{{ number_format($product->price, 2) }}</div>
                                    <div style="color: #666; font-size: 0.85rem;">Stock: {{ $product->stock }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <!-- ✅ LENDABLE TOGGLE BUTTON WITH INLINE CSS -->
                            <form action="{{ route('products.toggle-lendable', $product->id) }}" method="POST" style="display: inline; margin-right: 5px;">
                                @csrf
                                @method('patch')
                                <button type="submit" 
                                        style="padding: 6px 12px; border-radius: 5px; border: none; cursor: pointer; font-size: 0.8rem; font-weight: bold;
                                        @if($product->is_lendable) background: #d4edda; color: #155724;
                                        @else background: #f8f9fa; color: #666; border: 1px solid #ddd;
                                        @endif">
                                    {{ $product->is_lendable ? '📚 Borrowable' : '📚 Not Borrowable' }}
                                </button>
                            </form>

                            <a href="{{ route('products.edit', $product->id) }}" 
                               style="padding: 6px 12px; background: #ffc107; color: #333; text-decoration: none; border-radius: 5px; font-size: 0.8rem; font-weight: bold; display: inline-block; margin-right: 5px;">Edit Product</a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="padding: 6px 12px; background: #dc3545; color: white; border: none; border-radius: 5px; font-size: 0.8rem; font-weight: bold; cursor: pointer;"
                                        onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center; padding: 60px 20px;">
                            <div style="font-size: 3rem; margin-bottom: 15px;">📦</div>
                            <p style="color: #666; margin-bottom: 15px;">No products currently in studio</p>
                            <a href="{{ route('products.create') }}" style="padding: 10px 20px; background: #dd0d22; color: white; text-decoration: none; border-radius: 25px; font-weight: bold;">+ Add Your First Product</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<<<<<<< HEAD
</x-sellerDash>
=======
    <div class="sidebar">
    <div class="card">
        <h2>Recent Orders</h2>

        @forelse($orders as $order)
            <div class="order-item"
                 style="
                    border-left: 4px solid #ff4a00;
                    padding: 12px;
                    margin-bottom: 12px;
                    background: #fffaf6;
                    border-radius: 8px;
                    transition: 0.2s;
                 "
                 onmouseover="this.style.transform='scale(1.01)'"
                 onmouseout="this.style.transform='scale(1)'">

                <p style="margin:4px 0;">
                    <strong>👤 Customer:</strong>
                    {{ $order->user->name ?? 'Unknown' }}
                </p>

                <p style="margin:4px 0;">
                    <strong>📦 Item:</strong>
                    {{ $order->product->name ?? 'Deleted Product' }}
                </p>

                <p style="margin:4px 0; color:#dd0d22;">
                    <strong>💰 Total:</strong>
                    ₱{{ number_format($order->total_price, 2) }}
                </p>

                <p style="margin:4px 0;">
                    <strong>Status:</strong>
                    <span class="
                    status
                    @if($order->status == 'completed') status-completed
                    @elseif($order->status == 'cancelled') status-cancelled
                    @else status-pending
                    @endif
                ">
                    {{ ucfirst($order->status) }}
                </span>
                </p>

                <small style="color:#888;">
                    🕒 {{ $order->created_at->diffForHumans() }}
                </small>

            </div>
        @empty
            <div style="text-align:center; padding:25px;">
                <p style="color:#999; font-size:0.9rem;">
                    📭 No orders yet.<br>
                    Keep promoting your products!
                </p>
            </div>
        @endforelse

        @if($orders->count())
            <a href="{{ route('seller.orders') }}"
               style="
                    display:block;
                    text-align:center;
                    font-size:0.85rem;
                    color:#dd0d22;
                    text-decoration:none;
                    margin-top:10px;
                    font-weight:bold;
               ">
                View All Orders →
            </a>
        @endif

    </div>
</div>

<x-messui/>

<!-- <div class="bg-white p-4 rounded-xl shadow mb-6">
    <h2 class="text-lg font-bold mb-2">Notifications</h2>

    @forelse($notifications as $note)

        <div class="border-b py-2">
            <h3 class="font-semibold">{{ $note->subject }}</h3>
            <p class="text-gray-600">{{ $note->message }}</p>
        </div>

    @empty
        <p class="text-gray-400">No notifications yet.</p>
    @endforelse
</div>

IBUTANG DAW NIS DASHBOARD SA BUYER SA NOTIF NIYA-->

=======
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        
        body { 
            background-color: #fcfcfc; 
            font-family: 'Inter', sans-serif; 
            color: #0f172a;
        }

        /* 🔴 RED BRANDED NAVIGATION */
        .nav-branded { 
            background-color: #dc2626; 
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        /* 🎨 RED GRADIENTS */
        .stat-red { background: linear-gradient(135deg, #991b1b 0%, #ef4444 100%); }
        .stat-rose { 
            background-color: #fffafb; 
            border: 1px solid #ffe4e6; 
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

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 10px; }
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
                    <h1 class="text-sm font-extrabold tracking-tight uppercase text-white leading-none">
                        CraveCart | <span class="opacity-70">Seller Studio</span>
                    </h1>
                    <p class="text-[10px] text-rose-100/70 font-bold uppercase tracking-widest mt-1">
                        {{ Auth::user()->shop_name ?? 'My Shop' }} | <span class="text-rose-200">Active</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-8">
            <div class="hidden md:flex items-center gap-8 text-xs font-black uppercase tracking-widest text-rose-50">
                <a href="{{ route('seller.orders') }}" class="relative hover:text-white transition flex items-center gap-2">
                    Notifications
                    @if($notifCount > 0)
                        <span class="flex h-2 w-2 rounded-full bg-white animate-notif"></span>
                    @endif
                </a>
                <a href="{{ route('seller.messages') }}" class="hover:text-white transition">Lending</a>
            </div>
            
            <div class="flex items-center gap-4 pl-6 border-l border-white/10">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-[11px] font-black border border-white/20 uppercase text-white cursor-default">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-[10px] bg-slate-950 text-white px-6 py-2 rounded-lg hover:bg-white hover:text-red-600 transition font-black uppercase tracking-widest">
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
            <p class="text-xs font-bold text-red-600 uppercase tracking-[0.3em] mt-3">Store Overview & Performance</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="stat-red rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl shadow-red-500/20 transition hover:scale-[1.02]">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-4">Inventory</p>
                <h3 class="text-7xl font-black leading-none">{{ $products->count() }}</h3>
                <div class="absolute -right-4 -bottom-4 opacity-20 text-9xl">📦</div>
            </div>

            <div class="stat-rose rounded-[2.5rem] p-10 text-slate-900 relative overflow-hidden shadow-2xl shadow-rose-200/50 transition hover:scale-[1.02]">
                <p class="text-[10px] font-black uppercase tracking-widest text-red-600/60 mb-4">Total Revenue</p>
                <h3 class="text-6xl font-black italic text-slate-950 leading-none">₱{{ number_format($totalEarnings, 2) }}</h3>
                <div class="absolute -right-4 -bottom-4 opacity-10 text-9xl text-red-600">💰</div>
            </div>

            <a href="{{ route('seller.orders') }}" class="stat-glass rounded-[2.5rem] p-10 text-slate-900 relative overflow-hidden shadow-lg transition hover:border-red-200 group hover:scale-[1.02]">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Pending Orders</p>
                <h3 class="text-7xl font-black group-hover:text-red-600 transition-colors leading-none">{{ $notifCount }}</h3>
                <div class="absolute -right-4 -bottom-4 opacity-5 text-9xl text-red-600">📊</div>
            </a>
        </div>

        <div class="flex justify-between items-end mb-8 px-2">
            <div>
                <h3 class="text-3xl font-black uppercase tracking-tight text-slate-900">Active Inventory</h3>
                <div class="h-1.5 w-12 bg-red-600 mt-2 rounded-full"></div>
            </div>
            <a href="{{ route('products.create') }}" class="bg-red-600 text-white px-10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-950 transition-all shadow-lg shadow-red-600/20">
                + Add Product
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Product Details</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-20 bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                                    @if($product->images && $product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-2xl bg-rose-50">🛒</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-slate-900 mb-1">{{ $product->name }}</p>
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-black text-red-600">₱{{ number_format($product->price, 2) }}</span>
                                        <span class="text-slate-200">|</span>
                                        <span class="text-xs text-slate-400 font-bold uppercase tracking-widest">Stock: {{ $product->stock }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <a href="{{ route('products.edit', $product->id) }}" class="inline-block border-2 border-slate-100 px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-rose-50 transition-all">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="py-24 text-center">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No products currently in studio</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <a href="{{ route('seller.messages') }}" class="fixed bottom-8 right-8 bg-red-600 text-white flex items-center gap-3 px-8 py-5 rounded-full shadow-2xl hover:scale-105 transition-all font-black text-[10px] uppercase tracking-widest z-50">
        <span class="text-lg">💬</span> Messages
    </a>

>>>>>>> origin/SellerStartup2.0
</body>
</html>
>>>>>>> origin/almostfinal

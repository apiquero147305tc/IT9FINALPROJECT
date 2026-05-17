<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CraveCart | Seller Studio</title>

    <script src="https://cdn.tailwindcss.com"></script>

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

        /* Notification dropdown scrollbar */
        #notif-list::-webkit-scrollbar { width: 6px; }
        #notif-list::-webkit-scrollbar-thumb { background: #fecaca; border-radius: 10px; }
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

                <!-- 🔔 NOTIFICATION DROPDOWN -->
                <div class="relative" id="notif-box">
                    <button onclick="toggleNotif()" class="relative hover:text-white transition flex items-center gap-2 outline-none">
                        Notifications
                        <span id="notif-badge" class="hidden flex h-2.5 w-2.5 rounded-full bg-white animate-notif"></span>
                    </button>

                    <div id="notif-dropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl z-50 overflow-hidden border border-gray-100">
                        <div class="bg-red-600 px-4 py-3 flex justify-between items-center">
                            <span class="text-white font-bold text-[10px] uppercase tracking-widest">Notifications</span>
                            <button onclick="markAllRead()" class="text-white text-[10px] hover:underline font-bold">Mark all read</button>
                        </div>
                        <div id="notif-list" class="max-h-80 overflow-y-auto">
                            <div class="px-4 py-8 text-center text-gray-400 text-[10px] font-black uppercase tracking-widest">Loading...</div>
                        </div>
                        <a href="{{ route('seller.notifications') }}" class="block text-center py-3 text-red-600 text-[10px] font-black hover:bg-gray-50 uppercase tracking-widest transition">
                            View All
                        </a>
                    </div>
                </div>

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

    <a href="{{ route('seller.messages') }}" class="fixed bottom-8 right-8 bg-red-600 text-white flex items-center gap-3 px-8 py-5 rounded-full shadow-2xl hover:scale-105 transition-all font-black text-[10px] uppercase tracking-widest z-40">
        <span class="text-lg">💬</span> Messages
    </a>

    <script>
    let notifs = [];

    function toggleNotif() {
        const dropdown = document.getElementById('notif-dropdown');
        dropdown.classList.toggle('hidden');
        if (!dropdown.classList.contains('hidden')) {
            loadNotifs();
        }
    }

    async function loadNotifs() {
        try {
            const res = await fetch('/notifications/unread');
            const data = await res.json();
            notifs = data.notifications;

            // Update badge
            const badge = document.getElementById('notif-badge');
            if (data.count > 0) {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }

            // Build list
            const list = document.getElementById('notif-list');
            if (notifs.length === 0) {
                list.innerHTML = '<div class="px-4 py-8 text-center text-gray-400 text-[10px] font-black uppercase tracking-widest">No new notifications</div>';
                return;
            }

            list.innerHTML = notifs.map(n => `
                <a href="${n.link || '#'}" onclick="handleClick(${n.id}, '${n.link || '#'}', event)" 
                   class="block px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition ${n.is_read ? '' : 'bg-red-50'}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg flex-shrink-0
                            ${n.type === 'new_order' ? 'bg-green-100' : n.type === 'buyer_message' ? 'bg-blue-100' : 'bg-purple-100'}">
                            ${n.type === 'new_order' ? '🛒' : n.type === 'buyer_message' ? '💬' : '📧'}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">${escapeHtml(n.subject)}</p>
                            <p class="text-xs text-gray-600 truncate">${escapeHtml(n.message)}</p>
                            <p class="text-[10px] text-gray-400 mt-1 font-bold uppercase tracking-wider">${timeAgo(n.created_at)}</p>
                        </div>
                        ${!n.is_read ? '<span class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0 mt-2"></span>' : ''}
                    </div>
                </a>
            `).join('');
        } catch (e) {
            document.getElementById('notif-list').innerHTML = '<div class="px-4 py-8 text-center text-gray-400 text-[10px] font-black uppercase tracking-widest">Failed to load</div>';
        }
    }

    async function handleClick(id, link, event) {
        event.preventDefault();
        await fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        window.location.href = link;
    }

    async function markAllRead() {
        await fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        loadNotifs();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function timeAgo(dateString) {
        const date = new Date(dateString);
        const seconds = Math.floor((new Date() - date) / 1000);
        if (seconds < 60) return 'Just now';
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return minutes + 'm ago';
        const hours = Math.floor(minutes / 60);
        if (hours < 24) return hours + 'h ago';
        const days = Math.floor(hours / 24);
        return days + 'd ago';
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const box = document.getElementById('notif-box');
        if (box && !box.contains(e.target)) {
            document.getElementById('notif-dropdown').classList.add('hidden');
        }
    });

    // Load on page start + refresh every 30 seconds
    loadNotifs();
    setInterval(loadNotifs, 30000);
    </script>

</body>
</html>
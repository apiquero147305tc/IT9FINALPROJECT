<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - CraveCart</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/50 min-h-screen antialiased">

<div class="flex min-h-screen">

    {{-- ========================================================= --}}
    {{-- MODERN LIGHT MODE SIDEBAR MENU PANEL                      --}}
    {{-- ========================================================= --}}
    <aside class="w-64 bg-white border-r border-slate-100 fixed h-full z-40 overflow-y-auto flex flex-col justify-between">
        
        <div>
            <div class="p-6 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-rose-600 via-orange-500 to-amber-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-orange-500/10">
                        <i class="fa-solid fa-store text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base text-slate-800 tracking-tight leading-none">CraveCart</h2>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mt-1">Seller Studio</span>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('seller.dash') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('seller.dash') ? 'bg-orange-50/80 text-orange-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-chart-line text-sm w-5"></i> Dashboard
                </a>
                <a href="{{ route('seller.orders') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('seller.orders') ? 'bg-orange-50/80 text-orange-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-box text-sm w-5"></i> Orders
                </a>
                <a href="{{ route('seller.products.create') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('seller.products.create') ? 'bg-orange-50/80 text-orange-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-plus text-sm w-5"></i> Add Product
                </a>
                <a href="{{ route('seller.profile') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('seller.profile') ? 'bg-orange-50/80 text-orange-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-user text-sm w-5"></i> Profile
                </a>
                <a href="{{ route('lending.seller') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('lending.seller') ? 'bg-orange-50/80 text-orange-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-book text-sm w-5"></i> Lending
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-slate-50">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-rose-500 hover:bg-rose-50 transition-all">
                <i class="fa-solid fa-right-from-bracket text-sm w-5"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    {{-- ========================================================= --}}
    {{-- WORKSPACE LAYER CONTENT REGISTRY RECEPTACLE              --}}
    {{-- ========================================================= --}}
    <main class="flex-1 ml-64 relative min-w-0">
        
        <div class="bg-white/80 backdrop-blur-md px-8 py-4.5 flex items-center justify-between sticky top-0 z-30 transition-all">
            <h1 class="text-lg font-black text-slate-800 tracking-tight">@yield('page-title', 'Overview Console')</h1>
            
            <div class="flex items-center gap-4">
                <button class="relative p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-slate-400 hover:text-slate-600 hover:bg-slate-100/80 transition shadow-sm">
                    <i class="fa-solid fa-bell text-sm"></i>
                    @if(isset($notifCount) && $notifCount > 0)
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    @endif
                </button>
                
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-xl p-1.5 pr-3 shadow-sm select-none">
                    <div class="w-7 h-7 bg-gradient-to-r from-rose-500 via-orange-500 to-amber-500 rounded-lg flex items-center justify-center text-white font-extrabold text-xs shadow-sm uppercase">
                        {{ substr(auth()->user()->name ?? 'S', 0, 1) }}
                    </div>
                    <span class="font-bold text-xs text-slate-700 tracking-wide hidden sm:inline-block">{{ auth()->user()->name ?? 'Studio Operator' }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-8">
            {{ $slot }}
        </div>
    </main>
</div>

</body>
</html>
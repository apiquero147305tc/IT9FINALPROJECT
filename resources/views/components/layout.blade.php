<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Curated Studio Essentials</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #FDFCFB;
        }
        .nav-blur { 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px); 
        }
        .text-stroke { 
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.1); 
        }
        /* Custom scrollbar for boutique feel */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-900 antialiased overflow-x-hidden">
<nav class="sticky top-0 z-[100] bg-gradient-to-r from-red-600 via-red-500 to-orange-500 transition-all duration-500 shadow-2xl shadow-orange-900/10">
    
    <!-- TOP BAR: Logo | Nav Links | Search | Profile -->
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-3 flex items-center justify-between">
        
        <!-- LEFT: Logo -->
        <a href="{{ route('home') }}" class="group flex items-center gap-3 no-underline shrink-0">
            <div class="bg-white p-2 rounded-xl shadow-lg shadow-black/10">
                <span class="text-xl">🛒</span>
            </div>
            <div class="flex flex-col leading-none">
                <h2 class="text-white font-black text-xl tracking-tighter uppercase">CRAVE<span class="text-orange-200">CART</span></h2>
                <span class="text-[8px] font-bold text-orange-100 uppercase tracking-[0.25em]">CURATED STUDIO ESSENTIALS</span>
            </div>
        </a>

        <!-- CENTER: Navigation Links -->
        <ul class="hidden lg:flex items-center gap-8 list-none mb-0 mx-8">
            <li><a href="{{ route('shop') }}" class="text-[11px] font-black uppercase tracking-[0.15em] text-white/90 hover:text-white transition-all no-underline">THE SHOP</a></li>
            <li><a href="{{ route('bestSeller') }}" class="text-[11px] font-black uppercase tracking-[0.15em] text-white/90 hover:text-white transition-all no-underline">OUR PRODUCTS</a></li>
            <li><a href="{{ route('about') }}" class="text-[11px] font-black uppercase tracking-[0.15em] text-white/90 hover:text-white transition-all no-underline">ABOUT US</a></li>
            <li><a href="{{ route('contact') }}" class="text-[11px] font-black uppercase tracking-[0.15em] text-white/90 hover:text-white transition-all no-underline">CONTACT US</a></li>
        </ul>

        <!-- RIGHT: Search + Profile -->
        <div class="flex items-center gap-4">
            <!-- Search -->
            <div class="relative hidden xl:block">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-white/50 text-sm"></i>
                <input type="text" placeholder="Find essentials..." class="pl-9 pr-4 py-2 bg-white/20 border border-white/20 rounded-full text-sm font-medium text-white placeholder-white/60 focus:outline-none focus:bg-white/30 w-48 transition-all">
            </div>

            
           <div class="flex items-center gap-4">
    @guest
        <a href="{{ route('login') }}"
           class="hidden sm:block text-[10px] font-black uppercase tracking-[0.2em] text-white hover:text-red-100 transition-colors no-underline">
            LOG IN
        </a>

        <a href="{{ route('chooseRole') }}"
           class="bg-white text-red-600 px-8 py-3.5 rounded-[1.2rem] font-black uppercase text-[10px] tracking-widest shadow-2xl shadow-red-900/10 hover:bg-slate-900 hover:text-white hover:-translate-y-1 transition-all active:scale-95 no-underline">
            SIGN IN
        </a>
    @else
        <div class="flex items-center gap-3 bg-white/10 p-1.5 pr-4 rounded-2xl border border-white/10">
            <div class="bg-white w-9 h-9 rounded-xl flex items-center justify-center text-red-600 shadow-inner">
                <i class="fa-solid fa-user-astronaut"></i>
            </div>

            <span class="text-[10px] font-black uppercase tracking-widest text-white">
                {{ Auth::user()->name }}
            </span>
        </div>

        {{-- ✅ SELLER ONLY LOGOUT --}}
       @if(Auth::user()->role === 'seller' || Auth::user()->role === 'buyer')
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="text-[10px] font-black uppercase tracking-widest bg-black/20 hover:bg-black/40 text-white px-4 py-2 rounded-xl transition">
            LOGOUT
        </button>
    </form>
@endif
    @endguest
</div>

        </div>
    </div>
</nav>

<main class="min-h-[85vh]">
    {{ $slot }}
</main>

<footer class="bg-slate-950 pt-32 pb-12 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 opacity-10 pointer-events-none select-none">
        <h1 class="text-[22rem] font-black leading-none text-stroke translate-x-1/3 -translate-y-1/4 italic">CRAVE</h1>
    </div>

    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-8 relative z-10">
        
        <div class="lg:col-span-5 space-y-8">
            <div class="flex items-center gap-4">
                <div class="bg-red-600 p-3 rounded-2xl shadow-xl shadow-red-600/20">
                    <span class="text-2xl text-white">🛒</span>
                </div>
                <h3 class="font-black text-3xl tracking-tighter uppercase italic">CraveCart<span class="text-red-500">.</span></h3>
            </div>
            <p class="text-slate-400 leading-relaxed font-medium text-lg max-w-md">
                Engineered for the modern student ecosystem. Curating premium necessities with a focus on speed, reliability, and technical excellence.
            </p>
            <div class="flex gap-4">
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center hover:bg-red-600 hover:border-red-600 transition-all group">
                    <i class="fa-brands fa-instagram text-lg group-hover:scale-110 transition"></i>
                </a>
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center hover:bg-red-600 hover:border-red-600 transition-all group">
                    <i class="fa-brands fa-facebook-f text-lg group-hover:scale-110 transition"></i>
                </a>
            </div>
        </div>
        
        <div class="lg:col-span-1 hidden lg:block"></div>

       

        <div class="lg:col-span-3">
            <h4 class="uppercase tracking-[0.4em] text-[10px] font-black mb-10 text-red-500">The Studio</h4>
            <div class="space-y-6 text-slate-400 font-bold text-xs">
                <div class="flex items-start gap-4">
                    <span class="text-red-500 font-black text-lg leading-none">/</span>
                    <p class="leading-relaxed uppercase tracking-widest">UM Tagum College<br><span class="text-slate-600 font-medium normal-case">Davao Region, PH</span></p>
                </div>
                <div class="flex items-start gap-4">
                    <span class="text-red-500 font-black text-lg leading-none">/</span>
                    <p class="leading-relaxed uppercase tracking-widest">support@cravecart.io<br><span class="text-slate-600 font-medium normal-case">+63 9XX XXX XXXX</span></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 mt-32 border-t border-white/5 pt-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <p class="text-slate-600 text-[10px] font-black uppercase tracking-[0.3em]">
            © {{ date('Y') }} CraveCart Logic. Built by Alindajao Group.
        </p>
        <div class="flex gap-10">
            <a href="#" class="text-slate-600 text-[10px] font-black uppercase tracking-[0.3em] hover:text-white no-underline transition-colors">Privacy Protocol</a>
            <a href="#" class="text-slate-600 text-[10px] font-black uppercase tracking-[0.3em] hover:text-white no-underline transition-colors">Terms of Use</a>
        </div>
    </div>
</footer>

</body>
</html>
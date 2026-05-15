<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>CraveCart | Studio Hub</title>

=======
    <title>CraveCart | Curated Studio Essentials</title>
    
>>>>>>> origin/SellerStartup2.0
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
        
        /* 🚀 FLOATING ANIMATIONS FOR IMAGES */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-float-delayed { animation: float 4s ease-in-out infinite; animation-delay: 2s; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-900 antialiased overflow-x-hidden">

<<<<<<< HEAD
<<nav class="sticky top-0 z-[100] border-b border-orange-500/10 bg-orange-600/90 nav-blur transition-all duration-500 shadow-2xl shadow-orange-900/5">
=======
<!-- RED NAVIGATION BAR -->
<nav class="sticky top-0 z-[100] border-b border-red-500/10 bg-red-600 nav-blur transition-all duration-500 shadow-2xl shadow-red-900/10">
>>>>>>> origin/SellerStartup2.0
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-4 flex items-center justify-between">
        
        <div class="flex items-center gap-10">
            <a href="{{ route('home') }}" class="group flex items-center gap-3 no-underline">
                <div class="bg-white p-2.5 rounded-2xl rotate-3 group-hover:rotate-0 transition-all duration-500 shadow-lg">
                    <span class="text-xl">🛒</span>
                </div>
                <div class="flex flex-col leading-none">
                    <h2 class="text-white font-black text-2xl tracking-tighter uppercase mb-0">Crave<span class="text-rose-200 italic">Cart</span></h2>
                    <span class="text-[9px] font-bold text-rose-100 uppercase tracking-[0.3em] opacity-80">Studio Hub</span>
                </div>
            </a>

            <ul class="hidden lg:flex items-center gap-8 list-none mb-0 p-0">
                <li><a href="{{ route('shop') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-50/80 hover:text-white transition-all no-underline">The Shop</a></li>
                <li><a href="{{ route('bestSeller') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-50/80 hover:text-white transition-all no-underline">Best Sellers</a></li>
                <li><a href="{{ route('about') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-50/80 hover:text-white transition-all no-underline">About</a></li>
                <li><a href="{{ route('contact') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-50/80 hover:text-white transition-all no-underline">Contact</a></li>
            </ul>
        </div>

        <div class="flex items-center gap-6">
            <!-- SEARCH BAR -->
            <div class="relative hidden xl:block group">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-rose-200/60 group-focus-within:text-white transition-colors"></i>
                <input type="text" placeholder="Find essentials..." class="pl-11 pr-4 py-2.5 bg-white/10 border border-white/10 rounded-2xl text-sm font-semibold text-white placeholder-rose-100/50 focus:outline-none focus:bg-white/20 w-44 focus:w-64 transition-all duration-500">
            </div>
            
            <div class="flex items-center gap-4">
                @auth
                    <!-- CART -->
                    <a href="{{ route('cart.index') }}" class="text-white hover:text-rose-200 transition-all relative p-2">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        <span class="absolute top-0 right-0 w-4 h-4 bg-white text-red-600 text-[9px] font-black rounded-full flex items-center justify-center shadow-sm">0</span>
                    </a>

                    <!-- USER DROPDOWN-STYLE INFO -->
                    <div class="flex items-center gap-3 bg-white/10 p-1.5 pr-4 rounded-2xl border border-white/10 group transition-all">
                        <div class="bg-white w-9 h-9 rounded-xl flex items-center justify-center text-red-600 shadow-inner">
                            <i class="fa-solid fa-user-astronaut"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black uppercase tracking-widest text-white">{{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="text-rose-200 hover:text-white text-[8px] font-black uppercase tracking-tighter transition-colors block text-left">
                                    [Logout]
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block text-[10px] font-black uppercase tracking-[0.2em] text-white hover:text-rose-100 transition-colors no-underline">Log In</a>
                    <a href="{{ route('chooseRole') }}" class="bg-white text-red-600 px-8 py-3.5 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-slate-900 hover:text-white hover:-translate-y-1 transition-all active:scale-95 no-underline">
                        GET STARTED
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<<<<<<< HEAD
<<main class="min-h-[85vh]">
    {{ $slot }}
</main>

<<footer class="bg-slate-950 pt-32 pb-12 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 opacity-10 pointer-events-none select-none">
        <h1 class="text-[22rem] font-black leading-none text-stroke translate-x-1/3 -translate-y-1/4 italic">CRAVE</h1>
=======
<!-- MAIN CONTENT -->
<main class="min-h-[85vh] relative">
    {{ $slot }}
</main>

<!-- FOOTER -->
<footer class="bg-slate-950 pt-32 pb-12 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 opacity-5 pointer-events-none select-none">
        <h1 class="text-[22rem] font-black leading-none translate-x-1/3 -translate-y-1/4 italic uppercase">Crave</h1>
>>>>>>> origin/SellerStartup2.0
    </div>

    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-8 relative z-10">
        <div class="lg:col-span-5 space-y-8">
            <div class="flex items-center gap-4">
                <div class="bg-red-600 p-3 rounded-2xl shadow-xl">
                    <span class="text-2xl text-white">🛒</span>
                </div>
                <h3 class="font-black text-3xl tracking-tighter uppercase italic text-white">CraveCart<span class="text-red-500">.</span></h3>
            </div>
            <p class="text-slate-400 leading-relaxed font-medium text-lg max-w-md">
                Engineered for the modern student ecosystem. Curating premium necessities with a focus on speed, reliability, and technical excellence.
            </p>
            <div class="flex gap-4">
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center hover:bg-red-600 hover:border-red-600 transition-all group text-white no-underline">
                    <i class="fa-brands fa-instagram text-lg group-hover:scale-110 transition"></i>
                </a>
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center hover:bg-red-600 hover:border-red-600 transition-all group text-white no-underline">
                    <i class="fa-brands fa-facebook-f text-lg group-hover:scale-110 transition"></i>
                </a>
            </div>
        </div>
        
        <div class="lg:col-span-1 hidden lg:block"></div>

        <div class="lg:col-span-3">
            <h4 class="uppercase tracking-[0.4em] text-[10px] font-black mb-10 text-red-500">System Nav</h4>
            <ul class="space-y-5 text-slate-400 font-bold text-xs list-none p-0">
                <li><a href="#" class="hover:text-white transition-colors block no-underline uppercase tracking-widest">Marketplace Hub</a></li>
                <li><a href="#" class="hover:text-white transition-colors block no-underline uppercase tracking-widest">Seller Management</a></li>
                <li><a href="#" class="hover:text-white transition-colors block no-underline uppercase tracking-widest">Logic & Logistics</a></li>
            </ul>
        </div>

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
            © {{ date('Y') }} CRAVECART STUDIO HUB
        </p>
        <div class="flex gap-10">
            <a href="#" class="text-slate-600 text-[10px] font-black uppercase tracking-[0.3em] hover:text-white no-underline transition-colors">Privacy</a>
            <a href="#" class="text-slate-600 text-[10px] font-black uppercase tracking-[0.3em] hover:text-white no-underline transition-colors">Terms</a>
        </div>
    </div>
</footer>

</body>
</html>
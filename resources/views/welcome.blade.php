<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                /* ... (Your existing Tailwind CSS variables) ... */

                /* 🚀 ADDED FLOATING ANIMATIONS */
                @keyframes float {
                    0%, 100% { transform: translateY(0px); }
                    50% { transform: translateY(-20px); }
                }

                .animate-float {
                    animation: float 4s ease-in-out infinite;
                }

                .animate-float-delayed {
                    animation: float 4s ease-in-out infinite;
                    animation-delay: 2s;
                }
            </style>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center justify-center min-h-screen flex-col p-6 lg:p-8">
        
        <!-- Navigation Header -->
        <header class="w-full lg:max-w-6xl text-sm mb-6">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-black border text-[#1b1b18] dark:border-[#3E3E3A] rounded-sm transition-all">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm transition-all">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-black border text-[#1b1b18] dark:border-[#3E3E3A] rounded-sm transition-all">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Hero Section -->
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow">
            <main class="flex w-full max-w-[335px] flex-col-reverse lg:max-w-6xl lg:flex-row items-center gap-12">
                
                <!-- LEFT SIDE: Text Content -->
                <div class="flex-1 text-[13px] leading-[20px] p-8 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl">
                    <p class="text-orange-500 font-bold uppercase tracking-widest text-xs mb-4">CRAVECART | ESSENTIALS</p>
                    
                    <h1 class="text-4xl lg:text-6xl font-black text-slate-900 dark:text-white leading-tight uppercase mb-6">
                        Essentials and necessities, <br>
                        <span class="text-orange-500">Delivered to your door!</span>
                    </h1>
                    
                    <p class="mb-8 text-[#706f6c] dark:text-[#A1A09A] text-lg lg:max-w-md">
                        Shop a wide range of essential products for yourself and your family.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="inline-block bg-orange-500 text-white px-10 py-4 rounded-xl font-bold uppercase tracking-wider hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 text-center">
                            Get Started
                        </a>
                        <a href="#shop" class="inline-block bg-[#1b1b18] dark:bg-white dark:text-black text-white px-10 py-4 rounded-xl font-bold uppercase tracking-wider hover:opacity-90 transition-all text-center">
                            Shop Now
                        </a>
                    </div>
                </div>

                <!-- RIGHT SIDE: Moving Pictures (Reference: image_ca7a7c.png) -->
                <div class="flex-1 relative flex justify-center items-center h-[400px] lg:h-[550px] w-full">
                    
                    <!-- Background Glow -->
                    <div class="absolute w-64 h-64 bg-orange-500/10 blur-3xl rounded-full"></div>

                    <!-- Main Delivery Image -->
                    <div class="animate-float z-10">
                        <img src="{{ asset('images/hero-package.png') }}" alt="Delivery Essentials" class="w-64 lg:w-96 h-auto drop-shadow-2xl rounded-3xl">
                    </div>
                    
                    <!-- Floating Badge 1 (Top Right) -->
                    <div class="absolute top-10 right-0 lg:-right-4 animate-float-delayed z-20">
                        <div class="bg-white dark:bg-[#1b1b18] p-4 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                            <span class="text-2xl">📦</span>
                            <div>
                                <p class="font-black text-[10px] uppercase tracking-widest text-slate-700 dark:text-slate-300">Fast Delivery</p>
                                <p class="text-[8px] text-slate-400 uppercase">Door to Door</p>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge 2 (Bottom Left) -->
                    <div class="absolute bottom-10 left-0 lg:-left-4 animate-float z-20">
                        <div class="bg-white dark:bg-[#1b1b18] p-4 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                            <span class="text-2xl">🍎</span>
                            <div>
                                <p class="font-black text-[10px] uppercase tracking-widest text-slate-700 dark:text-slate-300">Fresh Stock</p>
                                <p class="text-[8px] text-slate-400 uppercase">Daily Updates</p>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>

        <!-- Footer Note -->
        <footer class="py-12 text-center">
            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400">© {{ date('Y') }} CraveCart Studio Hub</p>
        </footer>
    </body>
</html>
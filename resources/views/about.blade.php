<x-layout>
    <section class="max-w-7xl mx-auto px-6 py-24 md:py-32 bg-white">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-32 items-end">
            <div class="lg:col-span-8">
                <p class="font-black uppercase tracking-[0.3em] text-orange-600 mb-8 text-xs">/ About</p>
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-black uppercase tracking-tighter leading-[0.8] text-slate-900">
                    Crave<br><span class="text-orange-600">Cart.</span>
                </h1>
            </div>
            <div class="lg:col-span-4 border-l-4 border-slate-900 pl-8">
                <p class="text-lg font-bold text-slate-900 uppercase leading-tight mb-4">
                    Essentials and Necessities, Delivered to Your Door!
                </p>
                <p class="text-slate-500 font-medium leading-relaxed">
                    CraveCart is your modern essential marketplace built for fast, affordable, and reliable shopping experience.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 lg:gap-24">
            
            <div class="relative pt-12 border-t-2 border-slate-100">
                <span class="absolute -top-4 left-0 bg-white pr-4 font-black text-4xl">01</span>
                <div class="flex items-center gap-4 mb-8">
                    <span class="text-4xl">🎯</span>
                    <h3 class="text-3xl font-black uppercase tracking-tighter text-slate-900">Mission</h3>
                </div>
                <p class="text-2xl font-medium text-slate-500 leading-snug">
                    To <span class="text-slate-900 font-bold italic">simplify</span> online shopping for everyday essentials.
                </p>
            </div>

            <div class="relative pt-12 border-t-2 border-orange-600">
                <span class="absolute -top-4 left-0 bg-white pr-4 font-black text-4xl text-orange-600">02</span>
                <div class="flex items-center gap-4 mb-8">
                    <span class="text-4xl">🚀</span>
                    <h3 class="text-3xl font-black uppercase tracking-tighter text-slate-900">Vision</h3>
                </div>
                <p class="text-2xl font-medium text-slate-500 leading-snug">
                    To become the <span class="text-orange-600 font-bold italic">leading</span> essentials marketplace in the Philippines.
                </p>
            </div>

        </div>

        <div class="mt-40 bg-slate-900 rounded-[3rem] p-12 md:p-24 text-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            <div class="relative z-10">
                <p class="text-orange-500 font-black uppercase tracking-[0.4em] text-[10px] mb-8">Ready to browse?</p>
                <h2 class="text-white text-4xl md:text-6xl font-black uppercase tracking-tighter mb-12">
                    Experience the <br>Marketplace.
                </h2>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('chooseRole') }}" class="bg-orange-600 text-white px-10 py-5 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-white hover:text-orange-600 transition-all shadow-xl shadow-orange-900/20">
                        Get Started
                    </a>
                    <a href="{{ route('shop') }}" class="bg-transparent border-2 border-white/20 text-white px-10 py-5 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-white hover:text-slate-900 transition-all">
                        View Products
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-20 flex justify-between items-center text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">
            <p>UM Tagum College</p>
            <p>Prototype v1.0.4</p>
        </div>

    </section>
</x-layout>
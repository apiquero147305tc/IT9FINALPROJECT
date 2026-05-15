<x-layout>
    <section class="min-h-[85vh] flex items-center justify-center bg-[#FDFCFB] px-6 py-20 relative overflow-hidden">
        
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none">
            <h1 class="text-[20rem] font-black uppercase tracking-tighter italic">STUDIO</h1>
        </div>

        <div class="relative z-10 w-full max-w-5xl text-center">
            <header class="mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-600 text-[10px] font-black uppercase tracking-[0.4em] mb-6 border border-orange-200">
                    Role              
                </span>
                <h2 class="text-5xl md:text-7xl font-black uppercase tracking-tighter text-slate-900 leading-[0.9]">
                    Select <span class="text-orange-600">Interface.</span>
                </h2>
                <p class="mt-6 text-slate-400 font-bold uppercase text-[11px] tracking-[0.3em]">CraveCart Essentials Hub</p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <a href="{{ route('chooseRole', ['role' => 'buyer']) }}" 
                   class="group relative bg-white p-12 rounded-[45px] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200 hover:-translate-y-4 transition-all duration-500 no-underline text-center overflow-hidden">
                    
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-slate-900 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

                    <div class="mb-8 inline-flex items-center justify-center w-24 h-24 bg-slate-50 rounded-3xl group-hover:bg-slate-900 group-hover:rotate-12 transition-all duration-500 shadow-inner">
                        <span class="text-5xl group-hover:scale-110 transition-transform">🎒</span>
                    </div>

                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-4">Crave Buyer</h3>
                    <p class="text-slate-500 font-medium leading-relaxed mb-10 text-sm">
                        Experience the marketplace. Browse essentials, manage your student budget.
                    </p>
                    
                    <div class="inline-flex items-center gap-3 bg-slate-900 text-white px-8 py-4 rounded-2xl font-black uppercase text-[11px] tracking-widest group-hover:bg-orange-600 transition-colors shadow-lg">
                        Buyer Access
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </a>

                <a href="{{ route('chooseRole', ['role' => 'seller']) }}" 
                   class="group relative bg-white p-12 rounded-[45px] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-orange-100 hover:-translate-y-4 transition-all duration-500 no-underline text-center overflow-hidden">
                    
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-orange-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

                    <div class="mb-8 inline-flex items-center justify-center w-24 h-24 bg-orange-50 rounded-3xl group-hover:bg-orange-600 group-hover:-rotate-12 transition-all duration-500 shadow-inner">
                        <span class="text-5xl group-hover:scale-110 transition-transform">📊</span>
                    </div>

                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-4">Studio Seller</h3>
                    <p class="text-slate-500 font-medium leading-relaxed mb-10 text-sm">
                        Control the inventory. Manage sales analytics, update product listings.
                    </p>
                    
                    <div class="inline-flex items-center gap-3 bg-orange-600 text-white px-8 py-4 rounded-2xl font-black uppercase text-[11px] tracking-widest group-hover:bg-slate-900 transition-colors shadow-lg">
                        Seller Hub
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </a>

            </div>

            <footer class="mt-16 flex flex-col items-center gap-4">
                <p class="text-slate-400 font-bold uppercase text-[11px] tracking-[0.2em]">
                    
                </p>
                <a href="{{ route('login') }}" class="text-slate-900 font-black no-underline border-b-2 border-orange-600 transition-all hover:text-orange-600">
                    Existing Account? Log in
                </a>
            </footer>
        </div>
    </section>
</x-layout>
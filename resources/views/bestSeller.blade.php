<x-layout>
    <section class="max-w-[1440px] mx-auto px-6 lg:px-12 py-20 bg-[#FDFCFB]">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 border-b border-slate-100 pb-12">
            <div>
                <p class="text-orange-600 font-black text-[10px] uppercase tracking-[0.4em] mb-4">/best sellers</p>
                <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                    Best <span class="text-orange-600">Sellers.</span>
                </h1>
            </div>
            <p class="text-slate-400 font-bold uppercase text-[11px] tracking-[0.2em] max-w-[200px] leading-relaxed">
                Most loved essentials from our studio vendors.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            @forelse($products as $product)
                <div class="group relative bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200 hover:-translate-y-2 transition-all duration-500">
                    
                    <div class="absolute top-6 left-6 bg-slate-900 text-white px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest z-10">
                        Top Pick
                    </div>
                    
                    <div class="absolute top-6 right-6 text-slate-200 text-2xl cursor-pointer hover:text-red-500 transition-colors z-10">
                        ❤
                    </div>
                    
                    <div class="h-52 flex items-center justify-center mb-8 overflow-hidden rounded-3xl bg-slate-50 group-hover:bg-white transition-colors">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-full w-auto group-hover:scale-110 transition-transform duration-500">
                        @else
                            <span class="text-5xl opacity-20">📦</span>
                        @endif
                    </div>

                    <div class="space-y-2 mb-8">
                        <h3 class="text-sm font-black uppercase tracking-tight text-slate-900 leading-tight">
                            {{ $product->name }}
                        </h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                            {{ $product->category }}
                        </p>
                        <p class="text-2xl font-black text-orange-600">
                            ₱{{ number_format($product->price, 2) }}
                        </p>
                    </div>

                    <button class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-orange-600 transition-all shadow-lg shadow-slate-100 border-none cursor-pointer active:scale-95">
                        Add to Cart
                    </button>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[40px] border-2 border-dashed border-slate-100">
                    <p class="text-slate-400 font-black uppercase tracking-widest text-xs">No products currently listed by sellers.</p>
                </div>
            @endforelse
 
        </div>

        <div class="mt-20 flex justify-between items-center text-slate-300 font-black uppercase text-[9px] tracking-[0.4em]">
            <p>CraveCart Marketplace System</p>
            <p>UM Tagum College v1.0</p>
        </div>
    </section>
</x-layout>
<x-layout title="My Cart - CraveCart">
<x-buyerDash>
    <section class="min-h-[85vh] bg-[#FDFCFB] px-6 py-20">
        <div class="max-w-[1440px] mx-auto">
            
            {{-- HEADER --}}
            <header class="mb-16 text-center">
                <span class="inline-block px-4 py-1.5 rounded-full bg-red-100 text-red-600 text-[10px] font-black uppercase tracking-[0.2em] mb-6 border border-red-200">
                    Marketplace
                </span>
                <h2 class="text-5xl md:text-6xl font-black uppercase tracking-tighter text-slate-900 leading-[0.9]">
                    Browse <span class="text-red-600">Essentials.</span>
                </h2>
                <a href="{{ route('lending.index') }}" class="nav-link">
                📚 Lending Hub
                </a>
                <a href="{{ route('lending.my-requests') }}" class="nav-link">
                📋 My Borrowings
            </a>
            </header>

            <!-- {{-- SORTING & FILTER UI --}}
            <div class="flex flex-wrap gap-4 mb-10 justify-center">
                <form method="GET" action="{{ route('buyer.home') }}" class="flex flex-wrap gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." 
                        class="px-6 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-red-600 outline-none w-64">
                    
                    <select name="category" class="px-6 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-red-600 outline-none">
                        <option value="All" {{ request('category') == 'All' ? 'selected' : '' }}>All Categories</option>
                        <option value="Food" {{ request('category') == 'Food' ? 'selected' : '' }}>Food</option>
                        <option value="School Supplies" {{ request('category') == 'School Supplies' ? 'selected' : '' }}>School Supplies</option>
                        <option value="Electronics" {{ request('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                        <option value="Others" {{ request('category') == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>

                    <select name="sort" class="px-6 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-red-600 outline-none">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>

                    <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-2xl font-black uppercase text-[11px] tracking-widest hover:bg-slate-900 transition-all">
                        Filter
                    </button>
                </form>
            </div> -->

            @php
                $user = auth()->user();
                $favorites = $user ? ($user->favoriteProducts ?? collect()) : collect();
            @endphp

            {{-- PRODUCT GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($products as $product)
                    @php
                        $ratings = $product->ratings ?? collect();
                        $avgRating = $ratings->avg('rating') ?? 0;
                        $ratingCount = $ratings->count() ?? 0;
                        $fullStars = floor($avgRating);
                        $isFavorited = $favorites->contains($product->id);
                    @endphp

                    <a href="{{ route('products.show', $product->id) }}"
   class="block group bg-white rounded-[30px] border border-slate-100 overflow-hidden hover:shadow-2xl hover:shadow-red-100/50 hover:-translate-y-2 transition-all duration-500">
                        {{-- IMAGE --}}
                        <div class="relative h-56 overflow-hidden bg-slate-100">
                            @if($product->images && $product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                    alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-image text-4xl"></i>
                                </div>
                            @endif

                            {{-- FAVORITE BUTTON --}}
                            @auth
                                <form action="{{ route('favorite.toggle', $product->id) }}" method="POST" class="absolute top-4 right-4">
                                    @csrf
                                    <button type="submit" class="w-10 h-10 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-lg hover:scale-110 transition-all">
                                        <i class="fa-{{ $isFavorited ? 'solid' : 'regular' }} fa-heart text-{{ $isFavorited ? 'red-500' : 'slate-400' }}"></i>
                                    </button>
                                </form>
                            @endauth

                            {{-- CATEGORY BADGE --}}
                            <div class="absolute bottom-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur rounded-full text-[10px] font-black uppercase tracking-widest text-slate-600">
                                    {{ $product->category }}
                                </span>
                            </div>
                        </div>
                        {{-- LENDABLE BADGE --}}
                        @if($product->is_lendable && $product->stock > 0)
                            <span class="badge-lendable">📚 Lendable</span>
                        @endif

                        {{-- CONTENT --}}
                        <div class="p-6">
                            <h3 class="font-black text-lg text-slate-900 mb-2 group-hover:text-red-600 transition-colors">{{ $product->name }}</h3>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-red-600 font-black text-xl">₱{{ number_format($product->price, 2) }}</span>
                                
                                {{-- RATING --}}
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $fullStars)
                                            <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                        @else
                                            <i class="fa-regular fa-star text-slate-300 text-xs"></i>
                                        @endif
                                    @endfor
                                    <span class="text-[10px] font-bold text-slate-400 ml-1">{{ number_format($avgRating, 1) }} ({{ $ratingCount }})</span>
                                </div>
                            </div>

                            {{-- ACTIONS --}}
                            @auth
                                @if(auth()->user()->role === 'buyer')
                                    {{-- ADD TO CART BUTTON (existing) --}}
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-cart">🛒 Add to Cart</button>
                                    </form>

                                    {{-- BORROW BUTTON (NEW) --}}
                                    @if($product->is_lendable && $product->stock > 0)
                                        <a href="{{ route('lending.create', $product) }}" class="btn-borrow">
                                            📚 Borrow
                                        </a>
                                    @endif
                                @endif
                            @endauth
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <i class="fa-solid fa-box-open text-6xl text-slate-200 mb-4"></i>
                        <h3 class="text-2xl font-black text-slate-400 mb-2">No products found</h3>
                        <p class="text-slate-400 font-medium">Try adjusting your search or category filter.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <script>
    let timeout = null;

    const searchInput = document.querySelector('input[name="search"]');
    const form = searchInput.closest('form');

    searchInput.addEventListener('input', function () {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            form.submit();
        }, 500); // waits 0.5s after typing stops
    });
</script>
</x-buyerDash>
</x-layout>
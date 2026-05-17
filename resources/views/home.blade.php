<x-layout>
    <section class="max-w-7xl mx-auto flex flex-col md:flex-row items-center py-24 px-6 lg:px-12 gap-16">
        <div class="flex-[1.2]">
            <p class="font-extrabold uppercase tracking-widest text-red-600 mb-5 text-sm">
                CRAVECART | ESSENTIALS
            </p>
            
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter leading-[1.1] mb-6 text-slate-900">
                Essentials and Necessities, <span class="block text-red-600">Delivered to Your Door!</span>
            </h1>

            <p class="text-slate-500 max-w-md mb-10 leading-relaxed font-medium text-lg">
                Shop a wide range of essential products for yourself and your family.
            </p>
            
            <a href="{{ route('chooseRole') }}" class="inline-block bg-slate-900 text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-slate-200 hover:-translate-y-1 hover:bg-red-600 transition-all duration-300 no-underline">
                Shop Now
            </a>
        </div>

        <div class="flex-1 flex justify-end">
            <img src="{{ asset('images/hero.png') }}" alt="Delivery Essentials" class="w-full max-w-lg drop-shadow-2xl brightness-105">
        </div>
    </section>

    <!-- Categories -->
    <section class="bg-[#fff0f0] py-24">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <h2 class="mb-14 text-4xl font-black uppercase tracking-tighter text-center text-slate-900">
                Shop by Category
            </h2>
            
            <div class="flex flex-wrap justify-center gap-6">
                @php 
                    $cats = [
                        ['emoji' => '✏️', 'name' => 'Stationary'], 
                        ['emoji' => '🍎', 'name' => 'Groceries'], 
                        ['emoji' => '💻', 'name' => 'Electronics'], 
                        ['emoji' => '📚', 'name' => 'Books']
                    ]; 
                @endphp

                @foreach($cats as $cat)
                <div class="bg-white w-52 h-52 rounded-[40px] flex flex-col items-center justify-center shadow-sm border border-slate-100 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                    <span class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">{{ $cat['emoji'] }}</span>
                    <span class="font-extrabold uppercase tracking-widest text-[11px] text-slate-900">{{ $cat['name'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Products Section — DYNAMIC -->
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-24">
        <div class="flex flex-col sm:flex-row sm:items-center gap-6 mb-14">
            <h2 class="text-4xl md:text-6xl font-black uppercase tracking-tighter text-slate-900">Our Products</h2>
            <div class="hidden sm:block h-3 bg-red-600 rounded-full w-32 flex-shrink-0"></div>
            <a href="{{ route('shop') }}" class="sm:ml-auto text-red-600 font-extrabold uppercase tracking-widest text-xs border-b-2 border-red-600 pb-1 no-underline transition-colors hover:text-red-700 hover:border-red-700">
                View All →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
            <div class="relative bg-white rounded-[35px] p-8 border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 group">
                
                <!-- Hot Badge -->
                <div class="absolute top-6 left-6 bg-slate-900 text-white px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest z-10">
                    Hot
                </div>
                
                <!-- Wishlist -->
                <div class="absolute top-6 right-6 text-slate-300 text-2xl cursor-pointer hover:text-red-500 transition-colors z-10">
                    ❤
                </div>
                
                <!-- Product Image -->
                <div class="h-48 flex items-center justify-center mb-6 overflow-hidden bg-slate-50 rounded-2xl">
                    @if($product->images && $product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="max-h-full w-auto group-hover:scale-105 transition-transform duration-500 object-cover">
                    @else
                        <div class="text-4xl">🛒</div>
                    @endif
                </div>

                <!-- Product Info -->
                <h3 class="text-sm font-black uppercase mb-1 text-slate-900 leading-tight">{{ $product->name }}</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">
                    by {{ $product->user->shop_name ?? $product->user->name }}
                </p>
                <p class="text-2xl font-black text-red-600 mb-6">₱{{ number_format($product->price, 2) }}</p>
                
                <!-- Add to Cart Button -->
                @auth
                    @if(auth()->user()->role === 'buyer')
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-red-600 transition-colors shadow-lg shadow-slate-100 border-none cursor-pointer">
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-slate-200 text-slate-400 py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] cursor-not-allowed border-none">
                            Buyers Only
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block w-full bg-slate-900 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-red-600 transition-colors shadow-lg text-center no-underline">
                        Login to Buy
                    </a>
                @endauth

            </div>
            @empty
            <div class="col-span-4 text-center py-20">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">📦</span>
                </div>
                <p class="text-slate-300 font-black uppercase tracking-widest text-sm">No products available yet</p>
                <p class="text-slate-400 text-xs mt-2">Check back soon!</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Promo Banner -->
    <div class="max-w-7xl mx-auto px-6 lg:px-12 pb-24">
        <section class="bg-gradient-to-br from-slate-900 to-slate-800 text-white py-20 px-8 rounded-[50px] text-center overflow-hidden relative">
            <p class="font-extrabold uppercase tracking-[4px] text-red-500 mb-5 text-sm">Limited Time Offer</p>
            <h2 class="text-6xl md:text-8xl font-black uppercase tracking-tighter leading-none mb-6">50% OFF</h2>
            <p class="text-slate-400 max-w-xl mx-auto mb-10 font-medium text-lg">
                Unlock massive savings on your first delivery. Join the community and experience CraveCart today.
            </p>
            <a href="{{ route('chooseRole') }}" class="inline-block bg-white text-red-600 px-14 py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-2xl hover:-translate-y-1 transition-all no-underline">
                Claim Discount
            </a>
        </section>
    </div>
</x-layout>
<x-layout title="My Cart - CraveCart">
    <section class="min-h-screen bg-slate-50 py-12 px-6 lg:px-12">
        <div class="max-w-[1440px] mx-auto">
            <div class="flex items-center gap-4 mb-10">
                <div class="bg-orange-600 p-3 rounded-2xl shadow-lg">
                    <span class="text-2xl text-white">🛒</span>
                </div>
                <h1 class="text-4xl font-black italic uppercase tracking-tighter text-slate-900">
                    My <span class="text-orange-600">Cart</span>
                </h1>
            </div>

            @if(count($cartItems) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- Items List -->
                    <div class="lg:col-span-8 space-y-4">
                        @foreach($cartItems as $item)
                        <div class="bg-white border border-slate-200 rounded-3xl p-6 flex flex-col md:flex-row items-center gap-6 shadow-sm">
                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/placeholder.jpg') }}" 
                                 class="w-32 h-32 object-cover rounded-2xl shadow-inner bg-slate-100">
                            
                            <div class="flex-1 text-center md:text-left">
                                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">{{ $item->product->name }}</h3>
                                <p class="text-orange-600 font-black text-lg">₱{{ number_format($item->product->price, 2) }}</p>
                            </div>

                            <div class="flex items-center bg-slate-100 p-1.5 rounded-2xl border border-slate-200">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0 flex items-center">
                                    @csrf @method('PATCH')
                                    <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" 
                                            class="w-10 h-10 flex items-center justify-center font-black hover:bg-white rounded-xl transition-all"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                    
                                    <span class="px-4 font-black text-slate-900">{{ $item->quantity }}</span>
                                    
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" 
                                            class="w-10 h-10 flex items-center justify-center font-black hover:bg-white rounded-xl transition-all">+</button>
                                </form>
                            </div>

                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-12 h-12 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-2xl transition-all">
                                    🗑️
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>

                    <!-- Simplified Summary Sidebar -->
                    <div class="lg:col-span-4">
                        <div class="bg-slate-900 rounded-[2rem] p-8 text-white sticky top-24 shadow-2xl">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.4em] text-orange-500 mb-8">Order Summary</h3>
                            
                            <div class="space-y-4 mb-8 text-sm font-bold uppercase tracking-widest">
                                <div class="flex justify-between items-end border-t border-white/10 pt-4">
                                    <span class="text-[10px] text-orange-500">Total Amount</span>
                                    <!-- Total is now just the subtotal -->
                                    <span class="text-3xl font-black italic tracking-tighter text-white">₱{{ number_format($subtotal, 2) }}</span>
                                </div>
                            </div>

                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-5 rounded-2xl font-black uppercase tracking-widest shadow-xl transition-all hover:-translate-y-1">
                                    🚀 Place Order Now
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-300">
                    <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">Your cart is empty</h2>
                    <a href="{{ route('buyer.home') }}" class="inline-block mt-10 bg-slate-900 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest">Start Shopping</a>
                </div>
            @endif
        </div>
    </section>
</x-layout>
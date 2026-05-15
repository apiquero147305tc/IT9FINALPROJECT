<<<<<<< HEAD
<x-buyerDash>

<div style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #333; margin-bottom: 10px;">🛒 My Cart</h2>
    <p style="color: #666; margin-bottom: 30px;">Review your items before checkout</p>

    @if($cartItems->isEmpty())
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 4rem; margin-bottom: 20px;">🛒</div>
            <h3 style="color: #666;">Your Cart is Empty</h3>
            <p style="color: #999;">Browse products and add them to your cart.</p>
            <a href="{{ route('buyer.home') }}" 
               style="display: inline-block; margin-top: 15px; padding: 12px 25px; background: #dd0d22; color: white; text-decoration: none; border-radius: 25px; font-weight: bold;">
                Browse Products
            </a>
        </div>
    @else
        <div style="display: grid; gap: 15px; margin-bottom: 30px;">
            @foreach($cartItems as $item)
                <div style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; gap: 20px; align-items: center;">

                    <div style="flex-shrink: 0;">
                        @if($item->product->images && $item->product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->product->images[0]->image_path) }}" 
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                        @else
                            <div style="width: 100px; height: 100px; background: #f3e3cb; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                📦
                            </div>
                        @endif
                    </div>

                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 5px 0; color: #333;">{{ $item->product->name }}</h3>
                        <p style="margin: 0; color: #666; font-size: 0.9rem;">
                            🏪 {{ $item->product->user->shop_name ?? $item->product->user->name }}
                        </p>
                        <p style="margin: 5px 0 0 0; color: #dd0d22; font-weight: bold; font-size: 1.1rem;">
                            ₱{{ number_format($item->product->price, 2) }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px;">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: flex; align-items: center; gap: 8px;">
                            @csrf
                            @method('PATCH')

                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}"
                                    style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #ddd; background: white; cursor: pointer; font-weight: bold; color: #666;">
                                −
                            </button>

                            <span style="font-weight: bold; color: #333; min-width: 30px; text-align: center;">
                                {{ $item->quantity }}
                            </span>

                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                    style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #ddd; background: white; cursor: pointer; font-weight: bold; color: #666;">
                                +
                            </button>
                        </form>
                    </div>

                    <div style="text-align: right; min-width: 100px;">
                        <p style="margin: 0; color: #dd0d22; font-weight: bold; font-size: 1.1rem;">
                            ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                        </p>
                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST" style="margin-top: 8px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 0.85rem; text-decoration: underline;">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h3 style="margin: 0; color: #333;">Cart Summary</h3>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9rem;">{{ $cartItems->count() }} item(s)</p>
                </div>
                <div style="text-align: right;">
                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Total</p>
                    <p style="margin: 0; color: #dd0d22; font-size: 1.5rem; font-weight: bold;">
                        ₱{{ number_format($total, 2) }}
                    </p>
                </div>
            </div>

            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" 
                        style="width: 100%; padding: 15px; background: #dd0d22; color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: bold; cursor: pointer;">
                    🛒 Proceed to Checkout
                </button>
            </form>

            <a href="{{ route('buyer.home') }}" 
               style="display: block; text-align: center; margin-top: 15px; color: #dd0d22; text-decoration: none; font-weight: bold;">
                ← Continue Shopping
            </a>
        </div>
    @endif
</div>

</x-buyerDash>
=======
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
>>>>>>> origin/SellerStartup2.0

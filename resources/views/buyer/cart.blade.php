<x-buyerDash>

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

        @if($cartItems->count() > 0)

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Items -->
                <div class="lg:col-span-8 space-y-4">

                    @foreach($cartItems as $item)

                        <div class="bg-white border border-slate-200 rounded-3xl p-6 flex items-center gap-6 shadow-sm">

                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/placeholder.jpg') }}"
                                 class="w-32 h-32 object-cover rounded-2xl">

                            <div class="flex-1">
                                <h3 class="text-xl font-black uppercase">
                                    {{ $item->product->name }}
                                </h3>

                                <p class="text-orange-600 font-black">
                                    ₱{{ number_format($item->product->price, 2) }}
                                </p>
                            </div>

                            <!-- Quantity -->
                            <form action="{{ route('cart.update', $item->id) }}"
                                  method="POST"
                                  class="flex items-center gap-2">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        name="quantity"
                                        value="{{ $item->quantity - 1 }}">
                                    -
                                </button>

                                <span class="font-black">
                                    {{ $item->quantity }}
                                </span>

                                <button type="submit"
                                        name="quantity"
                                        value="{{ $item->quantity + 1 }}">
                                    +
                                </button>

                            </form>

                            <!-- Delete -->
                            <form action="{{ route('cart.destroy', $item->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit">
                                    🗑️
                                </button>

                            </form>

                        </div>

                    @endforeach

                </div>

                <!-- Summary -->
                <div class="lg:col-span-4">

                    <div class="bg-slate-900 rounded-[2rem] p-8 text-white sticky top-24">

                        <h3 class="text-orange-500 text-xs font-black uppercase mb-6">
                            Order Summary
                        </h3>

                        <div class="flex justify-between items-end mb-6">

                            <span class="text-orange-500 text-xs">
                                Total
                            </span>

                            <span class="text-3xl font-black">
                                ₱{{ number_format($total, 2) }}
                            </span>

                        </div>

                        <form action="{{ route('cart.checkout') }}" method="POST">

                            @csrf

                            <button type="submit"
                                    class="w-full bg-orange-600 py-4 rounded-2xl font-black uppercase">

                                🚀 Checkout

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @else

            <div class="text-center py-32 bg-white rounded-3xl">

                <h2 class="text-3xl font-black">
                    Your cart is empty
                </h2>

                <a href="{{ route('buyer.home') }}"
                   class="mt-10 inline-block bg-slate-900 text-white px-10 py-4 rounded-2xl">

                    Start Shopping

                </a>

            </div>

        @endif

    </div>
</section>
</x-buyerDash>

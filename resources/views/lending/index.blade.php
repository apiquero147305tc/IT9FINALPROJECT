<x-buyerDash>

<main class="p-6 md:p-8 max-w-7xl mx-auto space-y-6">

   {{-- HEADER --}}
<div class="bg-gradient-to-r from-red-700 via-red-600 to-orange-500 text-white rounded-3xl p-6 shadow-sm">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        {{-- LEFT TEXT --}}
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Product Lending Hub</h2>
            <p class="text-white/80 text-xs mt-1 uppercase tracking-wider">
                Browse items available for borrowing
            </p>
        </div>

        {{-- RIGHT BUTTON --}}
        <a href="{{ route('buyer.home') }}"
           class="bg-white text-red-600 hover:bg-slate-100 text-xs font-bold px-4 py-2 rounded-xl shadow-md transition flex items-center gap-2 w-fit">

            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>

    </div>

</div>


    {{-- GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        @forelse($products as $product)

        <div class="gradient-border-wrapper rounded-3xl shadow-sm hover:shadow-md transition overflow-hidden hover:scale-[1.02]">

            <div class="bg-white rounded-[23px] overflow-hidden h-full flex flex-col">

                {{-- IMAGE --}}
                <div class="h-44 bg-slate-100 overflow-hidden">
                    @if($product->images && $product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images[0]->image_path) }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl text-slate-300">
                            📦
                        </div>
                    @endif
                </div>

                {{-- CONTENT --}}
                <div class="p-5 flex flex-col gap-3 flex-1">

                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-slate-800 text-sm">
                            {{ $product->name }}
                        </h3>

                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                            Lendable
                        </span>
                    </div>

                    <p class="text-xs text-slate-400">
                        🏪 {{ $product->user->shop_name ?? $product->user->name }}
                    </p>

                    <div class="flex justify-between text-xs">
                        <span class="text-red-600 font-bold">
                            ₱{{ number_format($product->price, 2) }}
                        </span>
                        <span class="text-emerald-600 font-semibold">
                            Stock: {{ $product->stock }}
                        </span>
                    </div>

                    <div class="bg-orange-50 border border-orange-100 rounded-xl p-2 text-[11px] text-orange-700">
                        💰 Est. fee: ₱{{ number_format($product->price * 0.10, 2) }}/week
                    </div>

                    <a href="{{ route('lending.create', $product->id) }}"
                       class="mt-auto text-center bg-gradient-to-r from-red-600 to-orange-500 text-white text-xs font-bold py-3 rounded-xl shadow-sm hover:opacity-90 transition">
                        Request to Borrow
                    </a>

                </div>
            </div>
        </div>

        @empty

        <div class="col-span-full text-center py-16 text-slate-400">
            <div class="text-5xl mb-4">📭</div>
            <p class="text-sm font-semibold">No lendable products available</p>
        </div>

        @endforelse

    </div>

</main>

</x-buyerDash>
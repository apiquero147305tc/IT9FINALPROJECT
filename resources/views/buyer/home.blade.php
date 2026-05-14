<x-buyerDash>

@section('title', 'Buyer Home - CraveCart')

{{-- Category Menu --}}
<div id="category-menu" style="display:none; background:white; padding:15px; border-radius:15px; position:absolute; right:5%; top:60px; box-shadow:0 5px 15px rgba(0,0,0,0.1); text-align:center; z-index: 100;">
    <p style="margin-top:0; font-weight:bold; color:#555;">Filter by Category</p>
    <div style="display:flex; flex-wrap:wrap; gap:8px; justify-content:center;">
        <button onclick="setCategory('')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">All</button>
        <button onclick="setCategory('Food')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">Food</button>
        <button onclick="setCategory('Cooking')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">Cooking</button>
        <button onclick="setCategory('Accessories')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">Accessories</button>
        <button onclick="setCategory('School Supplies')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">School Supplies</button>
    </div>
</div>

<h2 style="color: #1f2937; margin-bottom: 25px;">Shop Products</h2>

{{-- PRODUCT GRID --}}
<div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px;">

    @forelse($products as $product)

        <div class="card" style="background: white; border-radius: 15px; padding: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: 0.3s;">

            {{-- CLICKABLE PRODUCT AREA --}}
            <a href="{{ route('products.show', $product->id) }}" style="text-decoration:none; color:inherit; display:block;">
                
                @if($product->images->count() > 0)
                    <img src="{{ asset('storage/'.$product->images[0]->image_path) }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                @else
                    <img src="https://via.placeholder.com/150" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                @endif

                <h3 style="margin: 10px 0 5px; color: #1f2937; font-size: 1rem;">{{ $product->name }}</h3>
                <div class="price" style="color: #dd0d22; font-weight: bold; font-size: 1.1rem;">₱{{ number_format($product->price, 2) }}</div>
                <div class="stock" style="color: #666; font-size: 0.9rem;">Stock: {{ $product->stock }}</div>
            </a>

            {{-- ACTION BUTTONS --}}
            @if($product->stock <= 0)
                <span class="sold-out" style="display: block; text-align: center; padding: 10px; background: #fee2e2; color: #dd0d22; border-radius: 25px; margin-top: 10px; font-weight: bold;">Sold Out</span>
            @else
                <div style="display: flex; gap: 10px; margin-top: 12px;">
                    
                    {{-- 🛒 ADD TO CART --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" style="width: 100%; background: #f3e3cb; color: #dd0d22; border: 2px solid #dd0d22; padding: 10px; border-radius: 25px; cursor: pointer; font-weight: bold; transition: 0.3s;">
                            🛒 Add to Cart
                        </button>
                    </form>

                    {{-- ⚡ BUY NOW --}}
                    <form action="{{ route('orders.store') }}" method="POST" style="flex: 1;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="buy-btn" style="width: 100%; background: linear-gradient(to right, #dd0d22, #ff6a00); color: white; border: none; padding: 10px; border-radius: 25px; cursor: pointer; font-weight: bold;">
                            Buy Now
                        </button>
                    </form>
                </div>
            @endif

        </div>

    @empty
        <div style="text-align:center; grid-column: 1/-1; padding: 50px;">
            <p style="color: #666; font-size: 1.2rem;">No items found in this category.</p>
            <a href="{{ route('buyer.home') }}" style="color: #dd0d22;">Clear all filters</a>
        </div>
    @endforelse

</div>

<script>
    function toggleFilter() {
        var menu = document.getElementById("category-menu");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }

    function setCategory(category) {
        let url = new URL(window.location.href);
        if (category === '') {
            url.searchParams.delete('category');
        } else {
            url.searchParams.set('category', category);
        }
        window.location.href = url.toString();
    }
</script>

@endsection
</x-buyerDash>
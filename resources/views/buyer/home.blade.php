<x-buyerDash>

   <!-- Category Menu -->
   <div id="category-menu"
     style="
        display:none;
        background:white;
        padding:15px;
        border-radius:15px;
        position:absolute;
        right:5%;
        top:60px;
        box-shadow:0 5px 15px rgba(0,0,0,0.1);
        text-align:center;
     ">

    <p style="margin-top:0; font-weight:bold; color:#555;">Filter by Category</p>

    <!-- CHIPS STYLE BUTTONS -->
    <div style="display:flex; flex-wrap:wrap; gap:8px; justify-content:center;">

        <button onclick="setCategory('')"
            style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">
            All
        </button>

        <button onclick="setCategory('Food')"
            style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">
            Food
        </button>

        <button onclick="setCategory('Cooking')"
            style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">
            Cooking
        </button>

        <button onclick="setCategory('Accessories')"
            style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">
            Accessories
        </button>

        <button onclick="setCategory('School Supplies')"
            style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">
            School Supplies
        </button>

    </div>
</div>

   <h2>Shop Products</h2>

<!-- PRODUCT GRID -->
<div class="grid">

    @forelse($products as $product)

        <div class="card">

            <!-- CLICKABLE PRODUCT AREA -->
            <a href="{{ route('products.show', $product->id) }}" 
               style="text-decoration:none; color:inherit; display:block;">

                {{-- IMAGE --}}
                @if($product->images->count() > 0)
                    <img src="{{ asset('storage/'.$product->images[0]->image_path) }}">
                @else
                    <img src="https://via.placeholder.com/150">
                @endif

                <h3>{{ $product->name }}</h3>

                <div class="price">₱{{ number_format($product->price, 2) }}</div>
                <div class="stock">Stock: {{ $product->stock }}</div>

            </a>

            {{-- STOCK / BUY BUTTON --}}
            @if($product->stock <= 0)
                <span class="sold-out">Sold Out</span>
            @else
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">

                    <button type="submit" class="buy-btn">
                        Buy Now
                    </button>
                </form>
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

</x-buyerDash>
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


    <div class="product-grid">
        @forelse($products as $product)
            <div class="product-card">
                <!-- image_2ac475.png fix: Ensure correct storage path concatenation -->
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p class="price">₱{{ number_format($product->price, 2) }}</p>
                <button style="background:#ff4a00; color:white; border:none; padding:8px 15px; border-radius:10px; width:100%; cursor:pointer;">Add to Cart</button>
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
    </script>

<x-messui/>


</x-buyerDash>
<x-buyerDash>

    <!-- 🔔 Success/Error Notifications -->
    <div style="width: 90%; margin: 10px auto;">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; border: 1px solid #c3e6cb; margin-bottom: 15px; text-align: center;">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; border: 1px solid #f5c6cb; margin-bottom: 15px; text-align: center;">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif
    </div>

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
            z-index: 1000;
            text-align:center;
         ">
        <p style="margin-top:0; font-weight:bold; color:#555;">Filter by Category</p>
        <div style="display:flex; flex-wrap:wrap; gap:8px; justify-content:center;">
            <button onclick="setCategory('')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">All</button>
            <button onclick="setCategory('Food')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">Food</button>
            <button onclick="setCategory('Cooking')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">Cooking</button>
            <button onclick="setCategory('Accessories')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">Accessories</button>
            <button onclick="setCategory('School Supplies')" style="padding:6px 12px; border-radius:20px; border:none; background:#f3e3cb; color:#dd0d22; cursor:pointer; font-weight:bold;">School Supplies</button>
        </div>
    </div>

    <div class="product-grid">
        @forelse($products as $product)
            <div class="product-card">
                <!-- image_8504f7.png fix: Correct storage pathing -->
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%; height:180px; object-fit:cover; border-radius:10px;">
                
                <h3 style="margin: 10px 0 5px;">{{ $product->name }}</h3>
                <p class="price" style="font-weight:bold; color:#dd0d22; font-size:1.1rem; margin-bottom:10px;">
                    ₱{{ number_format($product->price, 2) }}
                </p>

                <!-- 🛒 THE FIX: Wrap button in a POST form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" style="background:#ff4a00; color:white; border:none; padding:10px 15px; border-radius:10px; width:100%; cursor:pointer; font-weight:bold; transition: 0.3s;">
                        Add to Cart
                    </button>
                </form>
            </div>
        @empty
            <div style="text-align:center; grid-column: 1/-1; padding: 50px;">
                <p style="color: #666; font-size: 1.2rem;">No items found in this category.</p>
                <a href="{{ route('buyer.home') }}" style="color: #dd0d22; font-weight:bold;">Clear all filters</a>
            </div>
        @endforelse
    </div>

    <script>
        function toggleFilter() {
            var menu = document.getElementById("category-menu");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }

        // Example setCategory function if you haven't implemented the JS logic yet
        function setCategory(category) {
            window.location.href = "{{ route('buyer.home') }}?category=" + category;
        }
    </script>

    <x-messui/>

</x-buyerDash>
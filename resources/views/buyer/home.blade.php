<x-buyerDash>

    {{-- Notifications --}}
    <div style="width: 90%; margin: 10px auto;">
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:12px; border-radius:8px; text-align:center;">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:8px; text-align:center;">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- CATEGORY FILTER (optional UI) --}}
    <div id="category-menu"
         style="display:none; background:white; padding:15px; border-radius:15px;
                position:absolute; right:5%; top:60px; box-shadow:0 5px 15px rgba(0,0,0,0.1);
                z-index:1000; text-align:center;">

        <p style="margin-top:0; font-weight:bold;">Filter by Category</p>

        <div style="display:flex; flex-wrap:wrap; gap:8px; justify-content:center;">
            <button onclick="setCategory('')" style="padding:6px 12px;">All</button>
            <button onclick="setCategory('Food')" style="padding:6px 12px;">Food</button>
            <button onclick="setCategory('Cooking')" style="padding:6px 12px;">Cooking</button>
            <button onclick="setCategory('Accessories')" style="padding:6px 12px;">Accessories</button>
            <button onclick="setCategory('School Supplies')" style="padding:6px 12px;">School Supplies</button>
        </div>
    </div>

    {{-- PRODUCT GRID --}}
    <div class="product-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(180px,1fr)); gap:15px; padding:20px;">

        @forelse($products as $product)

            <div class="product-card" style="background:white; padding:15px; border-radius:15px; text-align:center;">

                {{-- IMAGE --}}
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     style="width:100%; height:160px; object-fit:cover; border-radius:10px;">

                {{-- NAME --}}
                <h3 style="margin:10px 0 5px;">{{ $product->name }}</h3>

                {{-- PRICE --}}
                <p style="font-weight:bold; color:#dd0d22;">
                    ₱{{ number_format($product->price, 2) }}
                </p>

                {{-- ADD TO CART --}}
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            style="background:#ff4a00; color:white; border:none; padding:10px;
                                   border-radius:10px; width:100%; cursor:pointer;">
                        Add to Cart
                    </button>
                </form>

            </div>

        @empty
            <div style="text-align:center; grid-column:1/-1;">
                <p>No products found.</p>
                <a href="{{ route('buyer.home') }}">Clear filters</a>
            </div>
        @endforelse

    </div>

    {{-- SCRIPT --}}
    <script>
        function toggleFilter() {
            let menu = document.getElementById("category-menu");
            menu.style.display = menu.style.display === "block" ? "none" : "block";
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
<!DOCTYPE html>
<html>
<head>
    <title>CraveCart | Shop</title>
    <style>
        /* Base Colors & Layout */
        body { background: #f3e3cb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding-bottom: 50px; }
        
        /* Navbar Styling */
        nav { 
            background: #dd0d22; 
            padding: 10px 5%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            color: white; 
            position: sticky; 
            top: 0; 
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { color: white; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .nav-links a:hover { color: #f3e3cb; }

        /* Search & Filter Container */
        .search-container { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 20px; 
            gap: 10px; 
            max-width: 600px; 
            margin: 0 auto; 
        }
        .search-form { display: flex; flex: 1; gap: 10px; }
        .search-bar { 
            flex: 1; 
            padding: 12px 20px; 
            border-radius: 25px; 
            border: 2px solid #ff9b9e; 
            outline: none; 
        }
        .filter-btn { 
            background: white; 
            border: 2px solid #ff9b9e; 
            border-radius: 50%; 
            width: 45px; 
            height: 45px; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            cursor: pointer; 
            font-size: 1.2rem;
            transition: 0.3s;
        }
        .filter-btn:hover { background: #ff9b9e; color: white; }

        /* Category Filter Menu */
        #category-menu {
            display: none;
            background: white;
            border-radius: 15px;
            margin: 0 auto 20px;
            max-width: 500px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .cat-chip {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            background: #f3e3cb;
            border-radius: 20px;
            text-decoration: none;
            color: #dd0d22;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .cat-chip:hover, .cat-chip.active { background: #dd0d22; color: white; }

        /* Product Grid */
        .product-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); 
            gap: 20px; 
            padding: 0 5%; 
        }
        .product-card { background: white; padding: 15px; border-radius: 20px; text-align: center; transition: 0.3s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .product-card img { width: 100%; height: 140px; object-fit: cover; border-radius: 15px; }
        .product-card h3 { font-size: 1rem; margin: 10px 0; }
        .price { color: #dd0d22; font-weight: bold; }
    </style>
</head>
<body>

    <nav>
        <h2 style="margin:0;">CraveCart</h2>
        <div class="nav-links">
            <a href="{{ route('buyer.home') }}">Shop</a>
            <a href="#">Lending</a>
            <a href="#">Messages</a>
            <a href="#">Cart (0)</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none; border:1px solid white; color:white; padding: 5px 10px; border-radius:5px; cursor:pointer;">Logout</button>
            </form>
        </div>
    </nav>

    <div class="search-container">
        <!-- Wrap in a form to make search actually work -->
        <form action="{{ route('buyer.home') }}" method="GET" class="search-form">
            <input type="text" name="search" class="search-bar" placeholder="Search for snacks, gifts..." value="{{ request('search') }}">
            <button type="submit" style="display:none;">Search</button>
        </form>
        <div class="filter-btn" onclick="toggleFilter()" title="Filter by Category">
            <span>📂</span> 
        </div>
    </div>

    <!-- Category Menu logic using query strings -->
    <div id="category-menu" style="{{ request('category') ? 'display:block;' : '' }}">
        <p style="margin-top:0; font-weight:bold; color:#555;">Filter by Category</p>
        <a href="{{ route('buyer.home') }}" class="cat-chip {{ !request('category') || request('category') == 'All' ? 'active' : '' }}">All</a>
        <a href="?category=Flowers" class="cat-chip {{ request('category') == 'School Supplies' ? 'active' : '' }}">School Supples</a>
        <a href="?category=Plants" class="cat-chip {{ request('category') == 'Cooking' ? 'active' : '' }}">Cooking</a>
        <a href="?category=Gifts" class="cat-chip {{ request('category') == 'Accesories' ? 'active' : '' }}">Accesories</a>
        <a href="?category=Food" class="cat-chip {{ request('category') == 'Food' ? 'active' : '' }}">Food</a>
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
</body>
</html>
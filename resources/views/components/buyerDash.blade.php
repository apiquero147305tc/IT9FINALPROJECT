<!DOCTYPE html>
<html>
<head>
    <title>CraveCart | Shop</title>

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-bottom: 50px;
        }

        nav {
            background: linear-gradient(90deg, #e11d48, #f97316);
            padding: 12px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }

        .nav-right-container {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .nav-links {
            display: flex;
            gap: 18px;
            align-items: center;
        }

        .icon-link {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;

            width: 40px;
            height: 40px;
            flex-shrink: 0;

            color: white;
            cursor: pointer;

            border-radius: 10px;
            transition: 0.15s ease;
        }

        .icon-link:hover {
            opacity: 0.85;
            transform: scale(1.05);
        }

        .badge {
            position: absolute;
            top: -6px;
            right: -6px;

            background: #111 !important;
            color: #fff !important;

            min-width: 18px;
            height: 18px;
            padding: 0 6px;

            border-radius: 999px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 10px;
            font-weight: 800;

            border: 2px solid #fff;
            z-index: 999;
            pointer-events: none;
        }

        /* SEARCH */
        .search-box {
            padding: 7px 10px;
            border-radius: 20px;
            border: none;
            outline: none;
            width: 170px;
        }

        .search-btn,
        .clear-btn {
            width: 36px;
            height: 36px;

            border: none;
            border-radius: 50%;
            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255,255,255,0.2);
            color: white;

            transition: 0.2s ease;
        }

        .search-btn:hover,
        .clear-btn:hover {
            transform: scale(1.05);
            background: rgba(255,255,255,0.35);
        }

        .search-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* FILTER */
        .filter-wrapper {
            position: relative;
        }

        .filter-btn {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.3);

            color: white;
            border-radius: 10px;
            cursor: pointer;
        }

        .dropdown-menu {
            position: absolute;
            top: 50px;
            right: 0;

            background: white;
            color: black;

            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);

            padding: 8px;
            display: none;
            min-width: 180px;
            z-index: 999;
        }

        .dropdown-menu button {
            width: 100%;
            padding: 8px;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-menu button:hover {
            background: #f3f4f6;
        }

        .logout-btn {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.5);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .product-container {
            padding: 20px 5%;
        }
    </style>
</head>

<body>

<nav>

    <a href="{{ route('buyer.home') }}" style="text-decoration:none; color:white;">
        <h2 style="margin:0;">CraveCart</h2>
    </a>

    <div class="nav-right-container">

        {{-- SEARCH + CLEAR --}}
        <form action="{{ route('buyer.home') }}" method="GET"
              class="search-group">

            <input type="text"
                   name="search"
                   class="search-box"
                   placeholder="Search products..."
                   value="{{ request('search') }}">

            {{-- SEARCH --}}
            <button type="submit" class="search-btn">
                <i data-lucide="search"></i>
            </button>

            {{-- CLEAR --}}
            <a href="{{ route('buyer.home') }}" class="clear-btn">
                <i data-lucide="x"></i>
            </a>

        </form>

        {{-- FILTER (3-line icon) --}}
        <div class="filter-wrapper">

            <button type="button" class="filter-btn" onclick="toggleDropdown()">
                <i data-lucide="menu"></i>
            </button>

            <div id="dropdown" class="dropdown-menu">
                <button type="button" onclick="setCategory('')">All</button>
                <button type="button" onclick="setCategory('Food')">Food</button>
                <button type="button" onclick="setCategory('Cooking')">Cooking</button>
                <button type="button" onclick="setCategory('Accessories')">Accessories</button>
                <button type="button" onclick="setCategory('School Supplies')">School Supplies</button>
            </div>

        </div>

        {{-- NAV ICONS --}}
        <div class="nav-links">

            <a href="{{ route('buyer.home') }}" class="icon-link">
                <i data-lucide="home"></i>
            </a>

            <a href="{{ route('cart.index') }}" class="icon-link">
                <i data-lucide="shopping-cart"></i>

                @php
                    $cartCount = auth()->user()->cartItems->count() ?? 0;
                @endphp

                @if($cartCount > 0)
                    <span class="badge">{{ $cartCount }}</span>
                @endif
            </a>

            <a href="{{ route('buyer.profile') }}" class="icon-link">
                <i data-lucide="user"></i>
            </a>

        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>

    </div>
</nav>

<div class="product-container">
    {{ $slot }}
</div>

<script>
    lucide.createIcons();

    function toggleDropdown() {
        const menu = document.getElementById("dropdown");
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

    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById("dropdown");
        if (!e.target.closest('.filter-wrapper')) {
            dropdown.style.display = "none";
        }
    });
</script>

</body>
</html>
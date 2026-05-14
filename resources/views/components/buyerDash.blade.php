<!DOCTYPE html>
<html>
<head>
    <title>CraveCart | Shop</title>

    <style>
        body {
            background: #f3e3cb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-bottom: 50px;
        }

        nav {
            background: #dd0d22;
            padding: 10px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .nav-right-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .nav-links {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .search-box {
            padding: 6px 12px;
            border-radius: 20px;
            border: none;
            outline: none;
            width: 160px;
        }

        .logout-btn {
            background: none;
            border: 1px solid white;
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        .product-container {
            padding: 20px 5%;
        }

        /* FILTER */
        .filter-dropdown {
            position: relative;
        }

        .filter-btn {
            background: white;
            border: none;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .dropdown-menu {
            position: absolute;
            top: 40px;
            right: 0;
            background: white;
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
            border-radius: 6px;
        }

        .dropdown-menu button:hover {
            background: #f3f4f6;
        }

        .active-filter {
            font-size: 0.75rem;
            margin-left: 5px;
            background: #fff;
            color: #dd0d22;
            padding: 2px 6px;
            border-radius: 8px;
        }

        /* 🔥 RESET FILTER CHIP */
        .reset-filter {
            font-size: 0.75rem;
            margin-left: 8px;
            background: #ffffff;
            color: #111;
            padding: 3px 8px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .reset-filter:hover {
            background: #f3f4f6;
        }

        /* SEARCH BUTTON (kept your upgraded version) */
        .search-btn {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 50%;
            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: center;

            background: linear-gradient(135deg, #ff4a00, #dd0d22);
            color: white;

            box-shadow: 0 6px 15px rgba(221, 13, 34, 0.25);
            transition: 0.2s ease;
        }

        .search-btn:hover {
            transform: translateY(-2px) scale(1.05);
        }

        .search-btn svg {
            width: 18px;
            height: 18px;
            stroke: white;
        }
    </style>
</head>

<body>

<nav>

    {{-- LOGO --}}
    <a href="{{ route('buyer.home') }}" style="text-decoration:none; color:white;">
        <h2 style="margin:0;">🛒 CraveCart</h2>
    </a>

    <div class="nav-right-container">

        {{-- SEARCH + FILTER --}}
        <form action="{{ route('buyer.home') }}" method="GET"
              style="display:flex; align-items:center; gap:8px;">

            {{-- SEARCH --}}
            <input type="text"
                   name="search"
                   class="search-box"
                   placeholder="Search products..."
                   value="{{ request('search') }}">

            <button type="submit" class="search-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="M21 21l-4.3-4.3"></path>
                </svg>
            </button>

            {{-- FILTER --}}
            <div class="filter-dropdown">

                <button type="button" class="filter-btn" onclick="toggleDropdown()">
                    Filter ▾

                    @if(request('category'))
                        <span class="active-filter">
                            {{ request('category') }}
                        </span>
                    @endif
                </button>

                {{-- RESET FILTER (SAFE + CLEAN UX) --}}
                @if(request('category') || request('search'))
                    <button type="button"
                            class="reset-filter"
                            onclick="window.location.href='{{ route('buyer.home') }}'">
                        Clear
                    </button>
                @endif

                <div id="dropdown" class="dropdown-menu">

                    <button type="button" onclick="setCategory('')">All</button>
                    <button type="button" onclick="setCategory('Food')">Food</button>
                    <button type="button" onclick="setCategory('Cooking')">Cooking</button>
                    <button type="button" onclick="setCategory('Accessories')">Accessories</button>
                    <button type="button" onclick="setCategory('School Supplies')">School Supplies</button>

                </div>

            </div>

        </form>

        {{-- LINKS --}}
        <div class="nav-links">
            <a href="{{ route('buyer.smartbudgetcontrol') }}">SmartBudget</a>
            <a href="#">Lending</a>
            <a href="{{ route('cart.index') }}">
                Cart {{ auth()->user()->cartItems->count() }}
            </a>
        </div>

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>

    </div>
</nav>

{{-- CONTENT --}}
<div class="product-container">
    {{ $slot }}
</div>

<x-messui/>

<script>
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
        if (!e.target.closest('.filter-dropdown')) {
            dropdown.style.display = "none";
        }
    });
</script>

</body>
</html>
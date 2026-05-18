<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Buyer Dashboard</title>

    {{-- TAILWIND --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- LUCIDE --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- FONT AWESOME --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    {{-- GOOGLE FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <style>

        body{
            font-family:'Plus Jakarta Sans',sans-serif;
            background:#f8fafc;
            margin:0;
        }

        /* NAVBAR */
        nav{
            position:sticky;
            top:0;
            z-index:999;
            background:linear-gradient(to right,#dc2626,#ea580c);
            padding:14px 5%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
            box-shadow:0 8px 25px rgba(0,0,0,0.12);
        }

        .brand{
            display:flex;
            align-items:center;
            gap:12px;
            text-decoration:none;
            color:white;
        }

        .brand-logo{
            width:48px;
            height:48px;
            border-radius:16px;
            background:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
        }

        .brand-text h2{
            margin:0;
            font-size:24px;
            font-weight:900;
            line-height:1;
        }

        .brand-text p{
            margin:0;
            font-size:10px;
            letter-spacing:2px;
            text-transform:uppercase;
            opacity:0.8;
        }

        .nav-right{
            display:flex;
            align-items:center;
            gap:14px;
            flex-wrap:wrap;
        }

        /* SEARCH */
        .search-group{
            display:flex;
            align-items:center;
            gap:8px;
            background:rgba(255,255,255,0.12);
            padding:6px;
            border-radius:18px;
        }

        .search-box{
            width:220px;
            border:none;
            outline:none;
            padding:10px 14px;
            border-radius:14px;
            background:white;
            color:#111827;
            font-weight:600;
        }

        .search-box::placeholder{
            color:#9ca3af;
        }

        .search-btn,
        .clear-btn,
        .filter-btn{
            width:42px;
            height:42px;
            border:none;
            border-radius:14px;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            background:rgba(255,255,255,0.18);
            color:white;
            transition:0.2s;
        }

        .search-btn:hover,
        .clear-btn:hover,
        .filter-btn:hover{
            transform:translateY(-1px);
            background:rgba(255,255,255,0.28);
        }

        /* DROPDOWN */
        .filter-wrapper{
            position:relative;
        }

        .dropdown-menu{
            position:absolute;
            top:55px;
            right:0;
            width:220px;
            background:white;
            border-radius:16px;
            box-shadow:0 12px 30px rgba(0,0,0,0.15);
            overflow:hidden;
            display:none;
        }

        .dropdown-menu button{
            width:100%;
            padding:14px;
            border:none;
            background:none;
            text-align:left;
            cursor:pointer;
            font-weight:700;
        }

        .dropdown-menu button:hover{
            background:#f3f4f6;
        }

        /* ICON LINKS */
        .nav-links{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .icon-link{
            width:44px;
            height:44px;
            border-radius:14px;
            background:rgba(255,255,255,0.14);
            display:flex;
            align-items:center;
            justify-content:center;
            color:white;
            position:relative;
            transition:0.2s;
            text-decoration:none;
        }

        .icon-link:hover{
            transform:translateY(-2px);
            background:rgba(255,255,255,0.24);
        }

        .badge{
            position:absolute;
            top:-5px;
            right:-5px;
            background:#111827;
            color:white;
            min-width:20px;
            height:20px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:10px;
            font-weight:800;
            border:2px solid white;
        }

        /* MESSAGES BUTTON */
        .message-btn{
            background:#be123c;
            color:white;
            text-decoration:none;
            padding:10px 16px;
            border-radius:14px;
            font-weight:800;
            display:flex;
            align-items:center;
            gap:8px;
            transition:0.2s;
        }

        .message-btn:hover{
            background:#9f1239;
        }

        /* LOGOUT */
        .logout-btn{
            border:none;
            background:white;
            color:#dc2626;
            padding:10px 18px;
            border-radius:14px;
            font-weight:800;
            cursor:pointer;
            transition:0.2s;
        }

        .logout-btn:hover{
            transform:translateY(-1px);
        }

        .product-container{
            padding:25px 5%;
        }

        @media(max-width:900px){

            nav{
                flex-direction:column;
                align-items:flex-start;
            }

            .nav-right{
                width:100%;
                justify-content:space-between;
            }

            .search-box{
                width:160px;
            }
        }

    </style>
</head>

<body>

<nav>

    {{-- BRAND --}}
    <a href="{{ route('buyer.home') }}" class="brand">

        <div class="brand-logo">
            🛒
        </div>

        <div class="brand-text">
            <h2>CraveCart</h2>
            <p>Buyer Dashboard</p>
        </div>

    </a>

    <div class="nav-right">

        {{-- SEARCH --}}
        <form class="search-group"
              onsubmit="event.preventDefault(); submitSearch();">

            <input type="text"
                   id="searchInput"
                   class="search-box"
                   placeholder="Search products or shop..."
                   value="{{ request('search') }}">

            <input type="hidden"
                   id="categoryInput"
                   value="{{ request('category') }}">

            <input type="hidden"
                   id="sortInput"
                   value="{{ request('sort','latest') }}">

            {{-- SEARCH --}}
            <button type="submit" class="search-btn">
                <i data-lucide="search"></i>
            </button>

            {{-- CLEAR --}}
            <a href="{{ route('buyer.home') }}" class="clear-btn">
                <i data-lucide="x"></i>
            </a>

        </form>

        {{-- FILTER --}}
        <div class="filter-wrapper">

            <button class="filter-btn"
                    onclick="toggleDropdown()"
                    type="button">

                <i data-lucide="sliders-horizontal"></i>

            </button>

            <div class="dropdown-menu" id="dropdown">

                <button onclick="setCategory('')">
                    All Categories
                </button>

                <button onclick="setCategory('Food')">
                    Food
                </button>

                <button onclick="setCategory('Electronics')">
                    Electronics
                </button>

                <button onclick="setCategory('School Supplies')">
                    School Supplies
                </button>

                <button onclick="setCategory('Others')">
                    Others
                </button>

            </div>

        </div>

        {{-- LENDING NAV --}}
<div class="flex items-center gap-2">

    <a href="{{ route('lending.index') }}"
       class="px-3 py-2 rounded-xl text-xs font-bold border border-white/30
              bg-white/10 text-white transition
              hover:bg-white/20 hover:border-white/60 hover:-translate-y-0.5">

        📚 Lending Hub
    </a>

    <a href="{{ route('lending.my-requests') }}"
       class="px-3 py-2 rounded-xl text-xs font-bold border border-white/30
              bg-white/10 text-white transition
              hover:bg-white/20 hover:border-white/60 hover:-translate-y-0.5">

        📋 My Borrowings
    </a>

</div>

       <a href="{{ route('messages.inbox') }}"
   class="px-3 py-2 rounded-xl text-xs font-bold border border-white/30
          bg-white/10 text-white transition
          hover:bg-white/20 hover:border-white/60 hover:-translate-y-0.5
          flex items-center gap-2">

    <i class="fa-solid fa-message"></i>
    Messages

</a>

        {{-- NAV ICONS --}}
        <div class="nav-links">

            <a href="{{ route('buyer.home') }}"
               class="icon-link">

                <i data-lucide="home"></i>

            </a>

            <a href="{{ route('cart.index') }}"
               class="icon-link">

                <i data-lucide="shopping-cart"></i>

                @php
                    $cartCount = auth()->user()->cartItems->count() ?? 0;
                @endphp

                @if($cartCount > 0)
                    <span class="badge">
                        {{ $cartCount }}
                    </span>
                @endif

            </a>

            <a href="{{ route('buyer.profile') }}"
               class="icon-link">

                <i data-lucide="user"></i>

            </a>

        </div>

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="logout-btn">
                Logout
            </button>
        </form>

    </div>

</nav>

{{-- PAGE CONTENT --}}
<div class="product-container">
    {{ $slot }}
</div>

<script>

    lucide.createIcons();

    // DROPDOWN
    const dropdown = document.getElementById('dropdown');

    function toggleDropdown(){

        if(dropdown.style.display === 'block'){
            dropdown.style.display = 'none';
        }else{
            dropdown.style.display = 'block';
        }
    }

    // CLOSE DROPDOWN
    document.addEventListener('click', function(e){

        const wrapper = document.querySelector('.filter-wrapper');

        if(wrapper && !wrapper.contains(e.target)){
            dropdown.style.display = 'none';
        }

    });

    // CATEGORY FILTER
    function setCategory(category){

        const url = new URL(window.location.href);

        if(category){
            url.searchParams.set('category', category);
        }else{
            url.searchParams.delete('category');
        }

        window.location.href = url.toString();
    }

    // SEARCH BUTTON ONLY
    function submitSearch(){

        const search = document.getElementById('searchInput').value.trim();

        const category = document.getElementById('categoryInput').value;

        const sort = document.getElementById('sortInput').value;

        const url = new URL(window.location.href);

        if(search){
            url.searchParams.set('search', search);
        }else{
            url.searchParams.delete('search');
        }

        if(category){
            url.searchParams.set('category', category);
        }

        if(sort){
            url.searchParams.set('sort', sort);
        }

        window.location.href = url.toString();
    }

</script>

</body>
</html>
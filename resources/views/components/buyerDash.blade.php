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
    align-items: center; 
    color: white; 
    position: sticky; 
    top: 0; 
    z-index: 1000;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* IMPORTANT: REMOVE automatic spacing behavior */
.nav-links { 
    display: flex; 
    gap: 20px; 
    align-items: center;
}
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

    <!-- LEFT -->
   <a href="{{ route('buyer.home') }}" style="text-decoration:none; color:white;">
    <h2 style="margin:0;">🛒CraveCart</h2>
</a>
    <!-- RIGHT (CONTROLLED ORDER) -->
    <div style="margin-left:auto; display:flex; align-items:center; gap:15px;">
        <!-- SEARCH -->
       <form action="{{ route('buyer.home') }}" method="GET"
      style="display:flex; align-items:center; gap:8px;">

    <!-- SEARCH -->
    <input type="text"
           name="search"
           placeholder="Search..."
           value="{{ request('search') }}"
           style="
                padding:6px 12px;
                border-radius:20px;
                border:none;
                outline:none;
           ">

    <!-- HIDDEN CATEGORY (IMPORTANT) -->
    <input type="hidden" name="category" id="categoryInput" value="{{ request('category') }}">

    <!-- FILTER BUTTON -->
    <button type="button"
            onclick="toggleFilter()"
            style="
                width:35px;
                height:35px;
                border-radius:50%;
                border:none;
                background:white;
                cursor:pointer;
            ">
        📂
    </button>
</form>

        <!-- LINKS FIRST -->
        <div class="nav-links">
            <a href="#">SmartBudget</a> <!-- i modify lang ni for buyer -->
            <a href="#">Lending</a> <!-- same here -->
        </div>


            <!-- FLOATING CART BUTTON -->
        <a href="{{ route('cart.index') }}" style="text-decoration: none; color: white;" id="floatingCartBtn">
            Cart
            <span id="cartCount">0</span>
        </a>
        
        <div style="display:flex; align-items:center; gap:15px;">
        <a href="{{ route('messages.inbox') }}"
   style="
        display:inline-block;
        background:#dd0d22;
        color:white;
        padding:8px 14px;
        border-radius:8px;
        text-decoration:none;
        font-weight:bold;
        position:relative;
   ">
    💬 Messages
        </a>
</div>
        
        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit"
            style="background:none; border:1px solid white; color:white; padding:5px 10px; border-radius:5px; cursor:pointer;">
            Logout
        </button>
    </form>
    
</div>
</nav>
<div id="chatBox" style="
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 300px;
    height: 400px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    display: none;
    flex-direction: column;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 9999;
">
    
    <div style="padding:10px; background:#dd0d22; color:white;">
        💬 Chat
        <span onclick="closeChat()" style="float:right; cursor:pointer;">✖</span>
    </div>

    <div id="chatMessages" style="flex:1; padding:10px; overflow-y:auto;">
        <!-- messages load here -->
    </div>

    <form id="chatForm" style="display:flex; border-top:1px solid #eee;">
        <input type="text" id="messageInput" placeholder="Type..." style="flex:1; border:none; padding:10px;">
        <button type="submit" style="background:#dd0d22; color:white; border:none; padding:10px;">Send</button>
    </form>

</div>


{{ $slot }}


<script>
function toggleFilter() {
    let menu = document.getElementById("category-menu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

function setCategory(value) {
    document.getElementById("categoryInput").value = value;
    document.querySelector('form').submit();
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("floatingCartBtn");
    const popup = document.getElementById("cartPopup");

    if (!btn || !popup) return;

    btn.addEventListener("click", function (e) {
        e.preventDefault();

        popup.style.display =
            popup.style.display === "block" ? "none" : "block";
    });

});
</script>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>CraveCart | Shop</title>
    <style>
        /* Base Colors & Layout */
        body { background: #f3e3cb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding-bottom: 50px; }
        
        /* Navbar Styling - Matches image_784994.png exactly */
        nav { 
            background: #dd0d22; 
            padding: 10px 5%; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; /* This pushes the right side to the right */
            color: white; 
            position: sticky; 
            top: 0; 
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .nav-right-container {
            display: flex;
            align-items: center;
            gap: 15px;
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

        /* Search Input Fix */
        .search-box {
            padding: 6px 15px;
            border-radius: 20px;
            border: none;
            outline: none;
            width: 180px;
        }

        /* Logout Button */
        .logout-btn {
            background: none;
            border: 1px solid white;
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        /* PRODUCT CARD FIX: This prevents the 'Add to Cart' button from being long */
        .product-container {
            padding: 20px 5%;
        }

        .product-card { 
            background: white; 
            padding: 15px; 
            border-radius: 20px; 
            text-align: center; 
            width: 180px; /* Limits width to match image_784994.png */
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .add-to-cart-btn {
            background: #ff5100;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            width: 100%; /* Fills only the 180px card, not the whole screen */
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav>
    <!-- LEFT: Logo -->
    <a href="{{ route('buyer.home') }}" style="text-decoration:none; color:white;">
        <h2 style="margin:0;">🛒 CraveCart</h2>
    </a>

    <!-- RIGHT: Controls -->
    <div class="nav-right-container">
        <!-- SEARCH -->
        <form action="{{ route('buyer.home') }}" method="GET" style="display:flex; align-items:center; gap:8px;">
            <input type="text" name="search" class="search-box" placeholder="Search..." value="{{ request('search') }}">
            <button type="button" onclick="toggleFilter()" style="background:white; border:none; border-radius:50%; width:30px; height:30px; cursor:pointer; display:flex; align-items:center; justify-content:center;">📂</button>
        </form>

        <div class="nav-links">
            <a href="#">SmartBudget</a> 
            <a href="#">Lending</a>
            <a href="{{ route('cart.index') }}">Cart {{ auth()->user()->cartItems->count() }}</a>
        </div>

        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<!-- This wrapper ensures content doesn't stretch full-width -->
<div class="product-container">
    {{ $slot }}
</div>

<x-messui/>

</body>
</html>
<nav class="navbar">
    <div class="logo">
        <a href="{{ route('home') }}" class="cravecartlogo">
            <h2 class="h22">🛒 CraveCart</h2>
        </a>
    </div>

    <ul>
        <li><a href="{{ route('shop') }}" class="cravecartlogo">Shop</a></li>
        <li><a href="{{ route('bestSeller') }}" class="cravecartlogo">Best Sellers</a></li>
        <li><a href="{{ route('about') }}" class="cravecartlogo">About Us</a></li>
        <li><a href="{{ route('contact') }}" class="cravecartlogo">Contact</a></li>
    </ul>

    <div class="nav-right">
        <input type="text" placeholder="Search for essentials...">
        
        <!-- Check if a user is logged in -->
        @auth
            <!-- Icons/Links seen in image_78af4a.png -->
            <a href="#" class="nav-icon-link">📁</a> 
            <a href="#" class="nav-text-link">SmartBudget</a>
            <a href="#" class="nav-text-link">Lending</a>

            <!-- The Dynamic Cart Link -->
            <a href="{{ route('cart.index') }}" class="nav-text-link">
                Cart {{ auth()->user()->cartItems()->count() }}
            </a>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @else
            <!-- Show Login/Signup if not logged in -->
            <button class="login">
                <a href="{{ route('login') }}" class="login-btn authpart" style="color: white;">Login</a>
            </button>

            <button class="signup">
                <a href="{{ route('chooseRole') }}" class="signup-btn authpart" style="color: darkred;">Sign up</a>
            </button>
        @endauth
    </div>
</nav>
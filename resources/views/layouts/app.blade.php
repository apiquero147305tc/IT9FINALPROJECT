<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart Marketplace</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .nav-icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .nav-link {
            text-decoration: none;
            color: white;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: opacity 0.2s;
        }
        .nav-link:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <nav class="navbar" style="background-color: var(--crave-red, #e74c3c); padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; color: white;">
        <div style="font-size: 1.5rem; font-weight: bold;">
            <a href="{{ url('/') }}" style="color: white; text-decoration: none; letter-spacing: 1px;">CraveCart</a>
        </div>

        <div class="nav-icons">
            <a href="{{ url('/') }}" class="nav-link">🛍️ Shop</a>

            @guest
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ url('/choose-role') }}" class="nav-link">Sign Up</a>
            @else
                @if(Auth::user()->isSeller())
                    <a href="{{ route('seller.dashboard') }}" class="nav-link">💼 Seller Studio</a>
                @endif

                @if(Auth::user()->isBuyer())
                    <a href="{{ route('buyer.dashboard') }}" class="nav-link">🏠 My Dashboard</a>
                @endif

                <a href="#" class="nav-link" title="Lending Center">🤝 Lending</a>
                <a href="#" class="nav-link">💬 Messages</a>
                <a href="{{ route('cart') }}" class="nav-link">🛒 Cart</a>

                <a href="{{ route('logout') }}" 
                   class="nav-link" 
                   style="color: var(--crave-yellow, #f1c40f); font-weight: bold; border-left: 1px solid rgba(255,255,255,0.3); padding-left: 15px;"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout ({{ Auth::user()->name }})
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </div>
    </nav>

    <div class="container" style="padding: 30px; max-width: 1200px; margin: 0 auto;">
        @yield('content')
    </div>
</body>
</html>
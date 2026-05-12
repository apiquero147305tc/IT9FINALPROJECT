<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CraveCart</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}">
                <h2>🛒 CraveCart</h2>
            </a>
        </div>

        <ul>
            <li><a href="{{ route('shop') }}">Shop</a></li>
            <li><a href="{{ route('bestSeller') }}">Best Sellers</a></li>
            <li><a href="{{ route('about') }}">About Us</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>

            @auth
                @if(auth()->user()->role === 'buyer')
                    <li>
                        <a href="{{ route('buyer.smartbudgetcontrol') }}">
                            SmartBudget
                        </a>
                    </li>
                @endif
            @endauth
        </ul>

        <div class="nav-right">
            @auth
                <a href="{{ route('cart.index') }}">Cart</a>

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </nav>

    {{-- PAGE CONTENT --}}
    <main>
        {{ $slot }}
    </main>

</body>
</html>
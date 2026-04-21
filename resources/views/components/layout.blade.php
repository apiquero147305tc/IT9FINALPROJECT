<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CraveCart</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <div class="logo"><a href="{{ route('home') }}" class="cravecartlogo">
    <h2>🛒 CraveCart</h2>
</a></div>

<ul>
    <li><a href="{{ route('shop') }}" class="cravecartlogo">Shop</a></li>
    <li><a href="{{ route('bestSeller') }}"class="cravecartlogo">Best Sellers</a></li>
    <li><a href="{{ route('about') }}"class="cravecartlogo">About Us</a></li>
    <li><a href="{{ route('contact') }}"class="cravecartlogo">Contact</a></li>
</ul>

    <div class="nav-right">
        <input type="text" placeholder="Search for essentials...">
         @if (!Request::is('buyer/*') && !Request::is('seller/*') && !Request::is('chooseRole'))
        
        <button class="login"><a href="{{ route('chooseRole') }}" class="login-btn authpart">
            Login
        </a></button>

        <button class="signup"><a href="{{ route('chooseRole') }}" class="signup-btn authpart">
            Sign up
        </a></button>

    @else

        <button class="login"><span class="login login-btn disabled">
            Login
        </span></button>

        <button class="signup"><span class="signup signup-btn disabled">
            Sign up
        </span></button>

    @endif
    </div>
</nav>

{{ $slot }}


<footer class="footer">
    <div class="footer-container">

        <div class="footer-section">
            <h3>🛒 CraveCart</h3>
            <p>Your one-stop shop for everyday essentials.</p>
        </div>
        <div class="footer-section">
            <h4>Contact</h4>
            <p>Email: support@cravecart.com</p>
            <p>Phone: +63 9XX XXX XXXX</p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© {{ date('Y') }} CraveCart. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
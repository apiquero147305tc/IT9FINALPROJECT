<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CraveCart</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        .join-page {
            background: #f3e3cb;
            display: flex;
            justify-content: center;
            padding-top: 50px;
            min-height: 100vh;
        }

        .join-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 350px;
        }

        .join-title {
            color: #dd0d22;
            text-align: center;
            margin-bottom: 20px;
        }

        .join-label {
            font-size: 0.85rem;
            color: #555;
            font-weight: bold;
        }

        .join-input,
        .join-select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 5px 0;
            border: 1px solid #ff9b9e;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .join-button {
            width: 100%;
            background: #ff4a00;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        .join-error-box {
            background: #ffe6e6;
            color: #dd0d22;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 0.8rem;
        }

        .join-error-msg {
            color: #dd0d22;
            font-size: 0.75rem;
            display: block;
            margin-bottom: 10px;
        }

        .join-footer {
            text-align: center;
            font-size: 0.8rem;
            margin-top: 15px;
        }

        .join-link {
            color: #ff4a00;
            text-decoration: none;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="logo"><a href="{{ route('home') }}" class="cravecartlogo">
    <h2 class="h22">🛒 CraveCart</h2>
</a></div>

<ul>
    <li><a href="{{ route('shop') }}" class="cravecartlogo">Shop</a></li>
    <li><a href="{{ route('bestSeller') }}"class="cravecartlogo">Best Sellers</a></li>
    <li><a href="{{ route('about') }}"class="cravecartlogo">About Us</a></li>
    <li><a href="{{ route('contact') }}"class="cravecartlogo">Contact</a></li>
</ul>

    <div class="nav-right">
        <input type="text" placeholder="Search for essentials...">
        @if (!Route::is('buyer.home') && !Route::is('seller.dashboard'))
    
     <button class="login"><a href="{{ route('login') }}" class="login-btn authpart" style="color: white;">
        Login
     </a></button>

     <button class="signup"><a href="{{ route('chooseRole') }}" class="signup-btn authpart" style="color: darkred;">
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
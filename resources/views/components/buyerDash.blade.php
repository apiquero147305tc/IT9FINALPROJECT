<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'CraveCart')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

{{-- BUYER NAVBAR --}}
<nav class="navbar" style="background: linear-gradient(to right, #dd0d22, #ff6a00); padding: 15px 30px; display: flex; justify-content: space-between; align-items: center;">
    
    {{-- Logo --}}
    <div class="logo">
        <a href="{{ route('buyer.home') }}" style="color: white; text-decoration: none; font-size: 1.5rem; font-weight: bold;">
            🛒 CraveCart
        </a>
    </div>

    {{-- Search --}}
    <div style="flex: 1; max-width: 400px; margin: 0 20px;">
        <input type="text" placeholder="Search..." style="width: 100%; padding: 10px 15px; border-radius: 25px; border: none; outline: none;">
    </div>

    {{-- Right Menu --}}
    <div style="display: flex; align-items: center; gap: 20px;">
        
        {{-- SmartBudget --}}
        <a href="{{ route('buyer.home') }}" style="color: white; text-decoration: none; font-weight: 500;">
            📁 SmartBudget
        </a>

        {{-- Lending --}}
        <a href="{{ route('lending') }}" style="color: white; text-decoration: none; font-weight: 500;">
            💡 Lending
        </a>

        {{-- Cart --}}
        <a href="{{ route('cart.index') }}" style="color: white; text-decoration: none; font-weight: 500; position: relative;">
            🛒 Cart 
            <span style="background: #feb207; color: #dd0d22; padding: 2px 8px; border-radius: 50%; font-size: 0.8rem; font-weight: bold;">
                {{ \App\Models\Cart::where('user_id', auth()->id())->sum('quantity') ?? 0 }}
            </span>
        </a>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: white; color: #dd0d22; border: none; padding: 8px 20px; border-radius: 20px; cursor: pointer; font-weight: bold;">
                Logout
            </button>
        </form>
    </div>
</nav>

{{-- MAIN CONTENT --}}
<main style="background: #f3e3cb; min-height: calc(100vh - 200px); padding: 30px;">
    {{ $slot }}
</main>

{{-- FOOTER --}}
<footer style="background: #111; color: white; padding: 40px 30px; text-align: center;">
    <div style="display: flex; justify-content: space-around; max-width: 800px; margin: 0 auto;">
        <div>
            <h3>🛒 CraveCart</h3>
            <p>Your one-stop shop for everyday essentials.</p>
        </div>
        <div>
            <h4>Contact</h4>
            <p>Email: support@cravecart.com</p>
            <p>Phone: +63 9XX XXX XXXX</p>
        </div>
    </div>
    <div style="margin-top: 30px; border-top: 1px solid #333; padding-top: 20px;">
        <p>© {{ date('Y') }} CraveCart. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
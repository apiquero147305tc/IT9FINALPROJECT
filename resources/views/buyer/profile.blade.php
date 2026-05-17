<x-buyerDash>

<style>
    body {
        background: #f8fafc;
    }

    .profile-container {
        padding: 30px;
        display: grid;
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
    }

    .header {
        background: linear-gradient(90deg, #e11d48, #f97316);
        color: white;
        padding: 25px;
        border-radius: 16px;
    }

    .header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
    }

    .subtext {
        opacity: 0.9;
        margin-top: 5px;
        font-size: 14px;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        background: #fff1f2;
        color: #e11d48;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn {
        padding: 10px 14px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        background: linear-gradient(90deg, #e11d48, #f97316);
        color: white;
        transition: 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn:hover {
        transform: scale(1.03);
    }

    .top-back {
        margin-bottom: 15px;
    }
</style>

<div class="profile-container">

    {{-- BACK TO HOME --}}
    <div class="top-back">
        <a href="{{ route('buyer.home') }}" class="btn">← Back to Home</a>
    </div>

    {{-- HEADER --}}
    <div class="header">
        <h2>{{ auth()->user()->name }}</h2>
        <div class="subtext">{{ auth()->user()->email }}</div>
        <span class="badge">Buyer Account</span>
    </div>

    {{-- TOP GRID --}}
    <div class="grid-2">

        <div class="card">
            <h3>Favorites</h3>
            <p>You have <b>{{ auth()->user()->favoriteProducts->count() }}</b> saved items.</p>

            <a href="{{ route('buyer.favorites') }}">
                <button class="btn">View Favorites</button>
            </a>
        </div>

        <div class="card">
            <h3>Account Settings</h3>
            <p>Manage your account access.</p>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn" style="background:#111;">Logout</button>
            </form>
        </div>

    </div>

    {{-- SMART BUDGET --}}
    <div class="card">
        <h3>Smart Budget Control</h3>
        @include('buyer.smartbudget')
    </div>

    <div class="card">
        <h3>Activity Overview</h3>
        <p style="color:#6b7280;">
            Recently viewed products and interactions will appear here.
        </p>
    </div>

</div>

</x-buyerDash>
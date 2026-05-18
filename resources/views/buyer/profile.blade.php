<x-buyerDash>

<style>
    body{
        background:#f8fafc;
    }

    .profile-wrapper{
        min-height:100vh;
        padding:50px 24px;
    }

    .profile-container{
        max-width:1200px;
        margin:auto;
    }

    .top-back{
        margin-bottom:25px;
    }

    .back-btn{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:12px 20px;
        border-radius:16px;
        background:white;
        color:#111827;
        text-decoration:none;
        font-size:12px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.15em;
        box-shadow:0 6px 18px rgba(0,0,0,0.06);
        transition:.25s ease;
    }

    .back-btn:hover{
        transform:translateY(-2px);
        background:#dc2626;
        color:white;
    }

    .profile-hero{
        position:relative;
        overflow:hidden;
        background:linear-gradient(135deg,#dc2626,#ea580c);
        border-radius:32px;
        padding:45px;
        color:white;
        box-shadow:0 25px 50px rgba(220,38,38,.18);
        margin-bottom:30px;
    }

    .profile-hero::before{
        content:'';
        position:absolute;
        width:280px;
        height:280px;
        background:rgba(255,255,255,.08);
        border-radius:50%;
        top:-120px;
        right:-80px;
    }

    .profile-badge{
        display:inline-block;
        padding:8px 14px;
        border-radius:999px;
        background:rgba(255,255,255,.18);
        backdrop-filter:blur(10px);
        font-size:11px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.2em;
        margin-bottom:18px;
    }

    .profile-name{
        font-size:48px;
        font-weight:900;
        line-height:1;
        margin-bottom:12px;
    }

    .profile-email{
        font-size:15px;
        opacity:.9;
        font-weight:500;
    }

    .grid-2{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
        gap:24px;
        margin-bottom:24px;
    }

    .card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .card:hover{
        transform:translateY(-4px);
        box-shadow:0 18px 40px rgba(0,0,0,.08);
    }

    .card h3{
        margin:0 0 10px;
        font-size:24px;
        font-weight:900;
        color:#111827;
    }

    .card p{
        color:#6b7280;
        line-height:1.7;
        margin-bottom:22px;
    }

    .stats{
        font-size:42px;
        font-weight:900;
        color:#dc2626;
        margin-bottom:12px;
    }

    .btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:10px;
        padding:14px 22px;
        border:none;
        border-radius:18px;
        cursor:pointer;
        font-size:11px;
        font-weight:900;
        letter-spacing:.18em;
        text-transform:uppercase;
        background:linear-gradient(to right,#dc2626,#ea580c);
        color:white;
        text-decoration:none;
        transition:.25s ease;
        box-shadow:0 10px 25px rgba(220,38,38,.2);
    }

    .btn:hover{
        transform:translateY(-2px) scale(1.02);
    }

    .btn-dark{
        background:#111827;
        box-shadow:none;
    }

    .section-title{
        font-size:28px;
        font-weight:900;
        margin-bottom:8px;
        color:#111827;
    }

    .section-sub{
        color:#6b7280;
        margin-bottom:25px;
    }

    @media(max-width:768px){

        .profile-wrapper{
            padding:30px 16px;
        }

        .profile-hero{
            padding:30px;
        }

        .profile-name{
            font-size:34px;
        }
    }
</style>

<div class="profile-wrapper">

    <div class="profile-container">

        {{-- BACK BUTTON --}}
        <div class="top-back">
            <a href="{{ route('buyer.home') }}" class="back-btn">
                ← Back to Marketplace
            </a>
        </div>

        {{-- HERO --}}
        <div class="profile-hero">

            <div class="profile-badge">
                Buyer Account
            </div>

            <div class="profile-name">
                {{ auth()->user()->name }}
            </div>

            <div class="profile-email">
                {{ auth()->user()->email }}
            </div>

        </div>

        {{-- TOP CARDS --}}
        <div class="grid-2">

            {{-- FAVORITES --}}
            <div class="card">

                <h3>Favorites</h3>

                <div class="stats">
                    {{ auth()->user()->favoriteProducts->count() }}
                </div>

                <p>
                    Your saved products are stored here for faster access and future purchases.
                </p>

                <a href="{{ route('buyer.favorites') }}" class="btn">
                    ❤️ View Favorites
                </a>

            </div>

           {{-- SETTINGS --}}
<div class="card">

    <div style="margin-bottom:25px;">
        <h3 style="margin-bottom:8px;">Account Settings</h3>

        <p style="color:#6b7280;">
            Update your buyer profile, secure your password, or permanently remove your account.
        </p>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div style="
            background:#dcfce7;
            color:#166534;
            padding:12px;
            border-radius:12px;
            margin-bottom:20px;
            font-weight:600;
        ">
            {{ session('success') }}
        </div>
    @endif

    {{-- UPDATE PROFILE --}}
    <form action="{{ route('buyer.profile.update') }}" method="POST" style="margin-bottom:30px;">
        @csrf
        @method('PATCH')

        <div style="display:grid; gap:15px;">

            <div>
                <label style="font-weight:700; display:block; margin-bottom:6px;">
                    Full Name
                </label>

                <input type="text"
                       name="name"
                       value="{{ auth()->user()->name }}"
                       required
                       style="
                            width:100%;
                            padding:12px;
                            border:1px solid #d1d5db;
                            border-radius:12px;
                       ">
            </div>

            <div>
                <label style="font-weight:700; display:block; margin-bottom:6px;">
                    Email Address
                </label>

                <input type="email"
                       name="email"
                       value="{{ auth()->user()->email }}"
                       required
                       style="
                            width:100%;
                            padding:12px;
                            border:1px solid #d1d5db;
                            border-radius:12px;
                       ">
            </div>

            <div>
                <label style="font-weight:700; display:block; margin-bottom:6px;">
                    New Password
                </label>

                <input type="password"
                       name="password"
                       placeholder="Leave blank to keep current password"
                       style="
                            width:100%;
                            padding:12px;
                            border:1px solid #d1d5db;
                            border-radius:12px;
                       ">
            </div>

            <div>
                <label style="font-weight:700; display:block; margin-bottom:6px;">
                    Confirm Password
                </label>

                <input type="password"
                       name="password_confirmation"
                       placeholder="Confirm new password"
                       style="
                            width:100%;
                            padding:12px;
                            border:1px solid #d1d5db;
                            border-radius:12px;
                       ">
            </div>

        </div>

        <button type="submit"
                class="btn"
                style="margin-top:20px;">
            Save Changes
        </button>
    </form>
    
    {{-- DELETE ACCOUNT --}}
    <form action="{{ route('buyer.account.delete') }}"
          method="POST"
          onsubmit="return confirmDelete()">
        @csrf
        @method('DELETE')

        <button type="submit"
                style="
                    background:#dc2626;
                    color:white;
                    border:none;
                    padding:12px 18px;
                    border-radius:12px;
                    font-weight:700;
                    cursor:pointer;
                ">
            Delete Account
        </button>
    </form>

</div>

<script>
function confirmDelete() {

    const firstConfirm = confirm(
        "Are you sure you want to permanently delete your account?"
    );

    if (!firstConfirm) {
        return false;
    }

    return confirm(
        "This action cannot be undone. Final confirmation?"
    );
}
</script>

        </div>

       {{-- SMART BUDGET --}}
<div class="card overflow-hidden">
    
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        flex-wrap:wrap;
        gap:10px;
    ">
        <div>
            <h3 style="
                margin:0;
                font-size:22px;
                font-weight:800;
                color:#111827;
            ">
                Smart Budget Control
            </h3>

            <p style="
                margin-top:6px;
                color:#6b7280;
                font-size:14px;
            ">
                Monitor your spending insights and buyer activity.
            </p>
        </div>

        <span style="
            padding:8px 14px;
            border-radius:999px;
            background:#ecfdf5;
            color:#059669;
            font-size:12px;
            font-weight:700;
        ">
            Budget Insights
        </span>
    </div>

    <div style="
        background:#f8fafc;
        border-radius:18px;
        padding:20px;
        border:1px solid #e5e7eb;
        overflow:hidden;
    ">
        @include('buyer.smartbudget')
    </div>

</div>

        {{-- ACTIVITY --}}
        <div class="card">

            <div class="section-title">
                Activity Overview
            </div>

            <div class="section-sub">
                Your recent marketplace interactions and viewed products will appear here.
            </div>

            <div style="padding:30px; border:2px dashed #e2e8f0; border-radius:20px; text-align:center; color:#94a3b8; font-weight:700;">
                No recent activity yet.
            </div>

        </div>

    </div>

</div>

</x-buyerDash>
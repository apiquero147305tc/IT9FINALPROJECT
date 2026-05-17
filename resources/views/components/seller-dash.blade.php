<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - CraveCart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .seller-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #1a1a2e;
            color: white;
            padding: 25px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand h2 {
            font-size: 1.4rem;
            color: #dd0d22;
        }

        .sidebar-brand p {
            font-size: 0.8rem;
            opacity: 0.7;
            margin-top: 5px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin: 5px 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(221, 13, 34, 0.2);
            color: #dd0d22;
            border-left: 3px solid #dd0d22;
        }

        .sidebar-menu .icon {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }

        /* ===== TOP NAV ===== */
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .top-nav h1 {
            font-size: 1.5rem;
            color: #333;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #dd0d22;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* ===== NOTIFICATIONS ===== */
        .notification-badge {
            position: relative;
            cursor: pointer;
        }

        .notification-badge .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dd0d22;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }
            .main-content {
                margin-left: 0;
            }
            .seller-layout {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="seller-layout">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>🍱 CraveCart</h2>
            <p>Seller Studio</p>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('seller.dash') }}" class="{{ request()->routeIs('seller.dash') ? 'active' : '' }}">
                    <span class="icon">📊</span> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('seller.orders') }}" class="{{ request()->routeIs('seller.orders') ? 'active' : '' }}">
                    <span class="icon">📦</span> Orders
                </a>
            </li>
            <li>
                <a href="{{ route('products.create') }}" class="{{ request()->routeIs('products.create') ? 'active' : '' }}">
                    <span class="icon">➕</span> Add Product
                </a>
            </li>
            <li>
                <a href="{{ route('seller.profile') }}" class="{{ request()->routeIs('seller.profile') ? 'active' : '' }}">
                    <span class="icon">👤</span> Profile
                </a>
            </li>
            
           <li>
                <a href="{{ route('messages.inbox') }}"
                class="{{ request()->routeIs('messages.inbox') ? 'active' : '' }}">
                    <span class="icon">💬</span> Messages
                </a>
            </li>

            <li>
                <a href="{{ route('lending.seller') }}" class="{{ request()->routeIs('lending.seller') ? 'active' : '' }}">
                    <span class="icon">📚</span> Lending
                </a>
            </li>
            <li style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="icon">🚪</span> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navigation -->
        <div class="top-nav">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <div class="user-info">
                <div class="notification-badge">
                    <span style="font-size: 1.3rem;">🔔</span>
                    @if(isset($notifCount) && $notifCount > 0)
                        <span class="badge">{{ $notifCount }}</span>
                    @endif
                </div>
                <div class="avatar">
                    {{ substr(auth()->user()->name ?? 'S', 0, 1) }}
                </div>
                <span style="font-weight: 500; color: #333;">{{ auth()->user()->name ?? 'Seller' }}</span>
            </div>
        </div>

        <!-- Page Content Slot -->
        {{ $slot }}
    </main>
</div>

</body>
</html>
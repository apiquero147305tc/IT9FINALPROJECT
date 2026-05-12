<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Admin Dashboard</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

    {{-- Your CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="admin-body">

<div class="dashboard-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="logo-area">
            <div class="logo-box">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>

            <div>
                <h1>CraveCart</h1>
                <p>Admin Dashboard</p>
            </div>
        </div>

        <nav class="sidebar-links">

            <a href="#users" class="active-link">
                <i class="fa-solid fa-users"></i>
                Users
            </a>

            <a href="#complaints">
                <i class="fa-solid fa-envelope"></i>
                Complaints & Messages
            </a>

            <a href="{{ route('admin.analytics') }}">
            <i class="fa-solid fa-chart-line"></i>
            Analytics
            </a>

            <a href="{{ route('admin.users.delete.page') }}">
                <i class="fa-solid fa-trash"></i>
                Delete Accounts
            </a>

            <a href="{{ route('admin.settings') }}">
             <i class="fa-solid fa-gear"></i>
                Settings
            </a>

        </nav>

    </aside>

    {{-- MAIN --}}
    <main class="main-content">

        {{-- HEADER --}}
        <div class="top-header">

            <div>
                <h1>Welcome Admin</h1>
                <p>Manage users and complaints here.</p>
            </div>

            <div class="admin-badge">
                Administrator
            </div>

        </div>

        {{-- STATS --}}
        <div class="stats-grid">

    {{-- TOTAL USERS --}}
    <a href="{{ route('admin.users') }}" class="stat-link">

        <div class="stat-card">

            <div>
                <p>Total Users</p>
                <h2>{{ $users->count() }}</h2>
            </div>

            <div class="stat-icon red">
                <i class="fa-solid fa-users"></i>
            </div>

        </div>

    </a>

    {{-- SELLERS --}}
    <a href="{{ route('admin.sellers') }}" class="stat-link">

        <div class="stat-card">

            <div>
                <p>Sellers</p>
                <h2>{{ $users->where('role','seller')->count() }}</h2>
            </div>

            <div class="stat-icon yellow">
                <i class="fa-solid fa-store"></i>
            </div>

        </div>

    </a>

    {{-- BUYERS --}}
    <a href="{{ route('admin.buyers') }}" class="stat-link">

        <div class="stat-card">

            <div>
                <p>Buyers</p>
                <h2>{{ $users->where('role','buyer')->count() }}</h2>
            </div>

            <div class="stat-icon blue">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>

        </div>

    </a>

    {{-- BLOCKED --}}
    <a href="{{ route('admin.blocked') }}" class="stat-link">

        <div class="stat-card">

            <div>
                <p>Blocked Users</p>
                <h2>{{ $users->where('is_blocked',1)->count() }}</h2>
            </div>

            <div class="stat-icon dark">
                <i class="fa-solid fa-user-lock"></i>
            </div>

        </div>

    </a>

</div>

        {{-- USERS --}}
        <section id="users" class="section-box">

            <div class="section-title">
                <h2>User Management</h2>
            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($users as $user)

                        <tr>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>

                            <td>

                                @if($user->is_blocked)

                                <span class="status blocked">
                                    Blocked
                                </span>

                                @else

                                <span class="status active">
                                    Active
                                </span>

                                @endif

                            </td>

                            <td class="action-buttons">

                               <td class="action-buttons">

                                    {{-- 🟡 PENDING USERS --}}
                                    @if($user->status === 'pending')

                                        <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-blue">
                                                <i class="fa-solid fa-check"></i>
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.reject', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-dark">
                                                <i class="fa-solid fa-xmark"></i>
                                                Reject
                                            </button>
                                        </form>

                                    {{-- 🟢 APPROVED USERS --}}
                                    @elseif($user->status === 'approved')

                                        <form action="{{ route('admin.block', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-dark">
                                                <i class="fa-solid fa-ban"></i>
                                                Block
                                            </button>
                                        </form>

                                        <a href="mailto:{{ $user->email }}" class="btn-red">
                                            <i class="fa-solid fa-envelope"></i>
                                            Email
                                        </a>

                                    {{-- 🔴 REJECTED USERS --}}
                                    @elseif($user->status === 'rejected')

                                        <span class="status rejected">Rejected</span>

                                        <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-blue">
                                                <i class="fa-solid fa-arrow-rotate-right"></i>
                                                Re-approve
                                            </button>
                                        </form>

                                    {{-- ⚫ BLOCKED USERS --}}
                                    @elseif($user->status === 'blocked')

                                        <form action="{{ route('admin.unblock', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-blue">
                                                <i class="fa-solid fa-unlock"></i>
                                                Unblock
                                            </button>
                                        </form>

                                    @endif

                                </td>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </section>

        <section id="rejected-users" class="section-box">

    <div class="section-title">
        <h2>Rejected Users</h2>
    </div>

    <div class="table-wrapper">

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($users->where('status', 'rejected') as $user)

                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>

                    <td>
                        <span class="status rejected">Rejected by admin</span>
                    </td>

                    <td>
                        <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-blue">
                                Re-approve
                            </button>
                        </form>
                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>

    </div>

</section>

        {{-- COMPLAINTS --}}
        <section id="complaints">

            <div class="section-title">
                <h2>Complaints & Messages</h2>
            </div>

            <div class="complaints-grid">

                @foreach($complaints as $c)

                <div class="complaint-card">

                    <div class="complaint-top">

                        <div>
                            <h3>{{ $c->subject }}</h3>
                            <small>{{ $c->email }}</small>
                        </div>

                        <div class="message-icon">
                            <i class="fa-solid fa-message"></i>
                        </div>

                    </div>

                    <p>{{ $c->message }}</p>

                    <a href="mailto:{{ $c->email }}" class="reply-btn">
                        <i class="fa-solid fa-reply"></i>
                        Reply
                    </a>

                </div>

                @endforeach

            </div>

        </section>

    </main>

</div>

</body>
</html>
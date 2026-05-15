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

         <a href="{{ route('admin.messages') }}"
            class="block hover:bg-gray-100">

                <i class="fa-solid fa-envelope"></i>
                Messages

         </a>

        <a href="{{ route('admin.contacts') }}" style="position:relative;">
             <i class="fa-solid fa-message"></i>
            Complaints

            @if($unreadContacts > 0)
                <span style="
                    position:absolute;
                    top:-5px;
                    right:-10px;
                    background:red;
                    color:white;
                    border-radius:50%;
                    font-size:12px;
                    padding:2px 6px;
                ">
                    {{ $unreadContacts }}
                </span>
            @endif
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

{{-- SELLER APPLICATIONS --}}
<section id="seller-applications" class="section-box">

    <div class="section-title">
        <h2>Seller Applications</h2>
    </div>

    <div class="table-wrapper">

        <table>

           <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Shop Name</th>
                    <th>Age</th>
                    <th>Contact</th>
                    <th>Valid ID</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($users->where('role', 'seller')->where('status', 'pending') as $seller)

                <tr>

                    <td>{{ $seller->name }}</td>
                    <td>{{ $seller->email }}</td>
                    <td>{{ $seller->shop_name }}</td>
                    <td>{{ $seller->age }}</td>
                    <td>{{ $seller->contact_number }}</td>

                    <td>
                        @if($seller->valid_id)
                            <a href="{{ asset('storage/' . $seller->valid_id) }}"
                               target="_blank"
                               class="btn-blue">
                                View ID
                            </a>
                        @endif
                    </td>

                    <td>
                        <span class="status pending">
                            Pending
                        </span>
                    </td>

                    <td class="action-buttons">

                        <form action="{{ route('admin.approve', $seller->id) }}" method="POST">
                            @csrf

                            <button type="submit" class="btn-blue">
                                <i class="fa-solid fa-check"></i>
                                Accept
                            </button>
                        </form>

                        <form action="{{ route('admin.reject', $seller->id) }}" method="POST">
                            @csrf

                            <button type="submit" class="btn-dark">
                                <i class="fa-solid fa-xmark"></i>
                                Reject
                            </button>
                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</section>

{{-- USER MANAGEMENT --}}
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

                @foreach($users->where('status', 'approved') as $user)

                <tr>

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>

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

                        {{-- BLOCK / UNBLOCK --}}
                        @if(!$user->is_blocked)

                            <form action="{{ route('admin.block', $user->id) }}" method="POST">
                                @csrf

                                <button type="submit" class="btn-dark">
                                    <i class="fa-solid fa-ban"></i>
                                    Block
                                </button>
                            </form>

                        @else

                            <form action="{{ route('admin.unblock', $user->id) }}" method="POST">
                                @csrf

                                <button type="submit" class="btn-blue">
                                    <i class="fa-solid fa-unlock"></i>
                                    Unblock
                                </button>
                            </form>

                        @endif

                       <a href="{{ route('admin.email.page', $user->id) }}"
                        class="btn-red">
                            <i class="fa-solid fa-envelope"></i>
                            Email
                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</section>

{{-- REJECTED SELLERS --}}
<section id="rejected-users" class="section-box">

    <div class="section-title">
        <h2>Rejected Sellers</h2>
    </div>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Shop Name</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @foreach($users->where('role', 'seller')->where('status', 'rejected') as $seller)

                <tr>

                    <td>{{ $seller->name }}</td>
                    <td>{{ $seller->email }}</td>
                    <td>{{ $seller->shop_name }}</td>

                    <td>
                        <span class="status rejected">
                            Rejected
                        </span>
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</section>

      {{-- CONTACT INBOX --}}
<section id="contacts">

    <div class="section-title mb-4">
        <h2 class="text-2xl font-bold"> Messages Inbox</h2>
        <p class="text-gray-300">User inquiries sent from Contact Us page</p>
    </div>

    <div class="grid gap-4">

        @forelse($contacts as $c)

        <div class="border rounded-xl p-5 bg-white shadow hover:shadow-md transition">

            {{-- HEADER --}}
            <div class="flex justify-between items-center mb-3">

                <div>
                    <h3 class="font-bold text-lg text-gray-800">
                        {{ $c->name }}
                    </h3>

                    <p class="text-sm text-gray-500">
                        {{ $c->email }}
                    </p>
                </div>

                {{-- STATUS --}}
                @if($c->is_read)
                    <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                        Read
                    </span>
                @else
                    <span class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-full">
                        New
                    </span>
                @endif

            </div>

            {{-- MESSAGE --}}
            <p class="text-gray-700 mb-4 leading-relaxed">
                {{ $c->message }}
            </p>

            {{-- ACTIONS --}}
            <div class="flex gap-2">

                {{-- OPEN CHAT (IN-APP MESSAGE SYSTEM) --}}
             @if($c->user_id)

                <a href="{{ route('admin.chat', $c->user_id) }}"
                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">

                    <i class="fa-solid fa-comments mr-1"></i>
                    Reply in Chat

                </a>

                @endif

                {{-- EMAIL --}}
                <a href="mailto:{{ $c->email }}"
                   class="bg-gray-200 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">

                    <i class="fa-solid fa-envelope mr-1"></i>
                    Email

                </a>

                {{-- MARK AS READ --}}
                @if(!$c->is_read)
                    <form method="POST" action="{{ route('admin.contact.read', $c->id) }}">
                        @csrf

                        <button class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm hover:bg-green-200">
                            Mark as Read
                        </button>
                    </form>
                @endif

            </div>

        </div>

        @empty

        <div class="text-center text-gray-500 py-10">
            <i class="fa-solid fa-inbox text-5xl mb-3"></i>
            <p>No contact messages yet.</p>
        </div>

        @endforelse

    </div>

</section>
    </main>

</div>

</body>
</html>
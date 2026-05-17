<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Admin Dashboard</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
            color: #0f172a;
        }
        .sidebar {
            background: #ffffff;
            border-right: 1px solid #f1f5f9;
        }
        .stat-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.08);
        }
        .table-row-hover:hover {
            background: #faf8f5;
        }
    </style>
</head>

<body class="min-h-screen">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="sidebar w-72 fixed h-full flex flex-col p-6 z-50">

        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-10">
            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center border border-red-100 shadow-inner">
                <i class="fa-solid fa-cart-shopping text-red-600 text-lg"></i>
            </div>
            <div>
                <h1 class="font-black text-slate-900 tracking-tight text-lg leading-none">CraveCart</h1>
                <p class="text-[10px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-0.5">Studio Hub</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 space-y-1">

            <a href="#users" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-slate-900 text-white font-semibold text-sm transition-all">
                <i class="fa-solid fa-users w-5 text-center"></i>
                Users
            </a>

            <a href="{{ route('admin.messages') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold text-sm transition-all">
                <i class="fa-solid fa-envelope w-5 text-center"></i>
                Messages
            </a>

            <a href="{{ route('admin.contacts') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold text-sm transition-all relative">
                <i class="fa-solid fa-message w-5 text-center"></i>
                Complaints
                @if($unreadContacts > 0)
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full">
                        {{ $unreadContacts }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold text-sm transition-all">
                <i class="fa-solid fa-chart-line w-5 text-center"></i>
                Analytics
            </a>

            <a href="{{ route('admin.users.delete.page') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold text-sm transition-all">
                <i class="fa-solid fa-trash w-5 text-center"></i>
                Delete Accounts
            </a>

            <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold text-sm transition-all">
                <i class="fa-solid fa-gear w-5 text-center"></i>
                Settings
            </a>

        </nav>

    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 ml-72 p-8">

        {{-- Header --}}
        <div class="mb-10">
            <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
                <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Admin Control</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
                Welcome <span class="text-red-600">Admin.</span>
            </h2>
            <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
                CraveCart Essentials Hub
            </p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

            <a href="{{ route('admin.users') }}" class="stat-card bg-white border border-slate-100 p-8 rounded-[35px] shadow-sm text-center group">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-50 rounded-2xl mb-4 group-hover:bg-slate-900 group-hover:rotate-12 transition-all duration-500 shadow-inner">
                    <i class="fa-solid fa-users text-2xl text-slate-400 group-hover:text-white transition-colors"></i>
                </div>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight">{{ $users->count() }}</h2>
                <p class="text-slate-400 font-bold text-[11px] tracking-[0.2em] uppercase mt-2">Total Users</p>
                <div class="w-full h-1 bg-slate-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-slate-900 rounded-full group-hover:bg-red-600 transition-colors duration-500" style="width: 100%"></div>
                </div>
            </a>

            <a href="{{ route('admin.sellers') }}" class="stat-card bg-white border border-slate-100 p-8 rounded-[35px] shadow-sm text-center group">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-rose-50 rounded-2xl mb-4 group-hover:bg-red-600 group-hover:-rotate-12 transition-all duration-500 shadow-inner">
                    <i class="fa-solid fa-store text-2xl text-red-400 group-hover:text-white transition-colors"></i>
                </div>
                <h2 class="text-4xl font-black text-red-600 tracking-tight">{{ $users->where('role','seller')->count() }}</h2>
                <p class="text-slate-400 font-bold text-[11px] tracking-[0.2em] uppercase mt-2">Sellers</p>
                <div class="w-full h-1 bg-slate-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-red-600 rounded-full group-hover:bg-slate-900 transition-colors duration-500" style="width: {{ $users->count() > 0 ? ($users->where('role','seller')->count() / $users->count() * 100) : 0 }}%"></div>
                </div>
            </a>

            <a href="{{ route('admin.buyers') }}" class="stat-card bg-white border border-slate-100 p-8 rounded-[35px] shadow-sm text-center group">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-50 rounded-2xl mb-4 group-hover:bg-red-500 group-hover:rotate-6 transition-all duration-500 shadow-inner">
                    <i class="fa-solid fa-cart-shopping text-2xl text-red-400 group-hover:text-white transition-colors"></i>
                </div>
                <h2 class="text-4xl font-black text-red-500 tracking-tight">{{ $users->where('role','buyer')->count() }}</h2>
                <p class="text-slate-400 font-bold text-[11px] tracking-[0.2em] uppercase mt-2">Buyers</p>
                <div class="w-full h-1 bg-slate-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-red-500 rounded-full group-hover:bg-slate-900 transition-colors duration-500" style="width: {{ $users->count() > 0 ? ($users->where('role','buyer')->count() / $users->count() * 100) : 0 }}%"></div>
                </div>
            </a>

            <a href="{{ route('admin.blocked') }}" class="stat-card bg-white border border-slate-100 p-8 rounded-[35px] shadow-sm text-center group">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-2xl mb-4 group-hover:bg-gray-800 group-hover:rotate-12 transition-all duration-500 shadow-inner">
                    <i class="fa-solid fa-user-lock text-2xl text-gray-500 group-hover:text-white transition-colors"></i>
                </div>
                <h2 class="text-4xl font-black text-gray-700 tracking-tight">{{ $users->where('is_blocked',1)->count() }}</h2>
                <p class="text-slate-400 font-bold text-[11px] tracking-[0.2em] uppercase mt-2">Blocked</p>
                <div class="w-full h-1 bg-slate-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-gray-700 rounded-full group-hover:bg-red-600 transition-colors duration-500" style="width: {{ $users->count() > 0 ? ($users->where('is_blocked',1)->count() / $users->count() * 100) : 0 }}%"></div>
                </div>
            </a>

        </div>

        {{-- Seller Applications --}}
        <section class="bg-white border border-slate-100 rounded-[35px] shadow-sm p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">Seller Applications</h3>
                    <p class="text-slate-400 text-xs font-bold tracking-wider uppercase mt-1">Pending Approval</p>
                </div>
                <div class="bg-red-50 border border-red-100 rounded-full px-4 py-1.5">
                    <span class="text-red-600 text-[10px] font-black tracking-[0.3em] uppercase">{{ $users->where('role', 'seller')->where('status', 'pending')->count() }} Pending</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Name</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Email</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Shop</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Age</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Contact</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Valid ID</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Status</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users->where('role', 'seller')->where('status', 'pending') as $seller)
                        <tr class="table-row-hover border-b border-slate-50 transition-colors">
                            <td class="py-4 px-4 font-semibold text-slate-800">{{ $seller->name }}</td>
                            <td class="py-4 px-4 text-slate-500 text-sm">{{ $seller->email }}</td>
                            <td class="py-4 px-4 text-slate-500 text-sm">{{ $seller->shop_name }}</td>
                            <td class="py-4 px-4 text-slate-500 text-sm">{{ $seller->age }}</td>
                            <td class="py-4 px-4 text-slate-500 text-sm">{{ $seller->contact_number }}</td>
                            <td class="py-4 px-4">
                                @if($seller->valid_id)
                                    <a href="{{ asset('storage/' . $seller->valid_id) }}" target="_blank" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 bg-yellow-50 border border-yellow-200 text-yellow-700 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.approve', $seller->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                            <i class="fa-solid fa-check"></i> Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reject', $seller->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 px-4 py-2 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                            <i class="fa-solid fa-xmark"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- User Management --}}
        <section class="bg-white border border-slate-100 rounded-[35px] shadow-sm p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">User Management</h3>
                    <p class="text-slate-400 text-xs font-bold tracking-wider uppercase mt-1">Approved Accounts</p>
                </div>
                <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5">
                    <span class="text-slate-600 text-[10px] font-black tracking-[0.3em] uppercase">{{ $users->where('status', 'approved')->count() }} Active</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Name</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Email</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Role</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Status</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users->where('status', 'approved') as $user)
                        <tr class="table-row-hover border-b border-slate-50 transition-colors">
                            <td class="py-4 px-4 font-semibold text-slate-800">{{ $user->name }}</td>
                            <td class="py-4 px-4 text-slate-500 text-sm">{{ $user->email }}</td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 bg-{{ $user->role === 'seller' ? 'red' : 'slate' }}-50 border border-{{ $user->role === 'seller' ? 'red' : 'slate' }}-200 text-{{ $user->role === 'seller' ? 'red' : 'slate' }}-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <i class="fa-solid fa-{{ $user->role === 'seller' ? 'store' : 'user' }}"></i> {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($user->is_blocked)
                                    <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Blocked
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Active
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                    @if(!$user->is_blocked)
                                        <form action="{{ route('admin.block', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-800 text-gray-600 hover:text-white px-4 py-2 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                                <i class="fa-solid fa-ban"></i> Block
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.unblock', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-2 bg-green-50 hover:bg-green-600 text-green-600 hover:text-white border border-green-200 px-4 py-2 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                                <i class="fa-solid fa-unlock"></i> Unblock
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.email.page', $user->id) }}" class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 px-4 py-2 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                        <i class="fa-solid fa-envelope"></i> Email
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Rejected Sellers --}}
        <section class="bg-white border border-slate-100 rounded-[35px] shadow-sm p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">Rejected Sellers</h3>
                    <p class="text-slate-400 text-xs font-bold tracking-wider uppercase mt-1">Denied Applications</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Name</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Email</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Shop</th>
                            <th class="text-left py-4 px-4 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users->where('role', 'seller')->where('status', 'rejected') as $seller)
                        <tr class="table-row-hover border-b border-slate-50 transition-colors">
                            <td class="py-4 px-4 font-semibold text-slate-800">{{ $seller->name }}</td>
                            <td class="py-4 px-4 text-slate-500 text-sm">{{ $seller->email }}</td>
                            <td class="py-4 px-4 text-slate-500 text-sm">{{ $seller->shop_name }}</td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Rejected
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Contact Inbox --}}
        <section class="bg-white border border-slate-100 rounded-[35px] shadow-sm p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">Messages Inbox</h3>
                    <p class="text-slate-400 text-xs font-bold tracking-wider uppercase mt-1">User Inquiries</p>
                </div>
                <div class="bg-red-50 border border-red-100 rounded-full px-4 py-1.5">
                    <span class="text-red-600 text-[10px] font-black tracking-[0.3em] uppercase">{{ $contacts->where('is_read', false)->count() }} New</span>
                </div>
            </div>

            <div class="grid gap-4">
                @forelse($contacts as $c)
                <div class="border border-slate-100 rounded-2xl p-6 bg-white hover:shadow-md transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-bold text-lg text-slate-900">{{ $c->name }}</h4>
                            <p class="text-sm text-slate-400 font-medium">{{ $c->email }}</p>
                        </div>
                        @if($c->is_read)
                            <span class="text-[10px] bg-slate-100 text-slate-500 px-3 py-1.5 rounded-full font-black tracking-wider uppercase">Read</span>
                        @else
                            <span class="text-[10px] bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full font-black tracking-wider uppercase">New</span>
                        @endif
                    </div>
                    <p class="text-slate-600 mb-4 leading-relaxed text-sm">{{ $c->message }}</p>
                    <div class="flex gap-2">
                        @if($c->user_id)
                            <a href="{{ route('admin.chat', $c->user_id) }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300 shadow-lg hover:shadow-xl">
                                <i class="fa-solid fa-comments"></i> Reply in Chat
                            </a>
                        @endif
                        <a href="mailto:{{ $c->email }}" class="inline-flex items-center gap-2 bg-slate-50 hover:bg-slate-100 text-slate-600 border border-slate-200 px-5 py-2.5 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                            <i class="fa-solid fa-envelope"></i> Email
                        </a>
                        @if(!$c->is_read)
                            <form method="POST" action="{{ route('admin.contact.read', $c->id) }}">
                                @csrf
                                <button class="inline-flex items-center gap-2 bg-green-50 hover:bg-green-600 text-green-600 hover:text-white border border-green-200 px-5 py-2.5 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                    <i class="fa-solid fa-check"></i> Mark Read
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                        <i class="fa-solid fa-inbox text-3xl text-slate-300"></i>
                    </div>
                    <p class="text-slate-400 font-bold text-sm tracking-wider uppercase">No messages yet</p>
                </div>
                @endforelse
            </div>
        </section>

    </main>

</div>

</body>
</html>
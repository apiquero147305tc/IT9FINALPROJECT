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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: #475569;
        }
        .custom-scrollbar::-webkit-scrollbar {
            height: 5px;
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }
        
        /* Premium Gradient Border Layout with Rounded Clipping */
        .gradient-border-wrapper {
            position: relative;
            background: linear-gradient(to right, #dc2626, #f97316);
            padding: 1px; /* The border thickness */
        }
    </style>
</head>

<body class="antialiased min-h-screen selection:bg-red-500/10 selection:text-red-600">

<div class="flex flex-col md:flex-row min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-full md:w-64 bg-white border-r border-slate-100 flex flex-col flex-shrink-0 sticky top-0 h-screen z-40 p-4 justify-between">
        
        <div class="space-y-8">
            <div class="p-3 flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-tr from-red-600 to-orange-500 rounded-xl flex items-center justify-center text-white shadow-md">
                    <i class="fa-solid fa-cart-shopping text-sm"></i>
                </div>
                <div>
                    <h1 class="font-bold text-sm tracking-tight text-slate-800">CraveCart</h1>
                    <p class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">Admin Studio</p>
                </div>
            </div>

            <nav class="space-y-1">
                <a href="#users" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-wider text-red-600 bg-red-50/60 rounded-xl transition-all">
                    <i class="fa-solid fa-chart-pie text-sm"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.messages') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
                    <i class="fa-solid fa-envelope text-sm"></i>
                    <span>Messages</span>
                </a>

                <a href="{{ route('admin.contacts') }}" class="relative flex items-center justify-between px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-message text-sm"></i>
                        <span>Complaints</span>
                    </div>
                    @if($unreadContacts > 0)
                        <span class="bg-red-500 text-white font-bold text-[10px] px-2 py-0.5 rounded-full">
                            {{ $unreadContacts }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
                    <i class="fa-solid fa-chart-line text-sm"></i>
                    <span>Analytics</span>
                </a>

                <a href="{{ route('admin.users.delete.page') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
                    <i class="fa-solid fa-trash text-sm"></i>
                    <span>Delete Accounts</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
                    <i class="fa-solid fa-gear text-sm"></i>
                    <span>Settings</span>
                </a>
            </nav>
        </div>

        <div class="p-2 border-t border-slate-50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-red-500 hover:text-red-600 transition text-left">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT SUITE --}}
    <main class="flex-1 p-6 md:p-8 max-w-7xl mx-auto w-full space-y-6">

        {{-- LANDSCAPE HERO BANNER --}}
        <div class="bg-gradient-to-r from-[#ba1124] via-[#d31c30] to-[#e6334a] text-white rounded-3xl p-6 md:p-8 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative overflow-hidden">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white/90">
                    <i class="fa-solid fa-sliders text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Admin Dashboard</h1>
                    <p class="text-white/70 text-xs font-semibold uppercase tracking-wider mt-0.5">Control Panel & Performance</p>
                </div>
            </div>
            <div class="bg-black/15 backdrop-blur-sm border border-white/10 px-4 py-2 rounded-2xl flex items-center gap-2 text-right">
                <div>
                    <div class="text-xs font-bold tracking-wide">System Account</div>
                    <div class="text-[10px] font-bold text-orange-300 uppercase tracking-widest mt-0.5">Verified Root</div>
                </div>
                <div class="w-7 h-7 bg-white rounded-full text-red-600 flex items-center justify-center font-bold text-sm">A</div>
            </div>
        </div>

        {{-- FOUR-COLUMN ROUNDED STAT GRID WITH ROUNDED GRADIENT BORDERS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <a href="{{ route('admin.users') }}" class="block no-underline">
    <div class="gradient-border-wrapper rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden cursor-pointer hover:scale-[1.02]">
        
        <div class="bg-white p-6 rounded-[23px] flex justify-between items-start h-full">
            
            <div class="space-y-2">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                    Global Register
                </p>

                <h2 class="text-4xl font-bold text-slate-800 tracking-tight">
                    {{ $users->count() }}
                </h2>

                <p class="text-slate-400 text-[11px] font-medium leading-tight">
                    Total catalog accounts logged on site.
                </p>
            </div>

            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-red-50 text-red-500 flex-shrink-0">
                <i class="fa-solid fa-users text-sm"></i>
            </div>

        </div>

    </div>
</a>

            <a href="{{ route('admin.sellers') }}" class="block no-underline">
    <div class="gradient-border-wrapper rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden cursor-pointer hover:scale-[1.02]">
        
        <div class="bg-white p-6 rounded-[23px] flex justify-between items-start h-full">
            
            <div class="space-y-2">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                    Active Sellers
                </p>

                <h2 class="text-4xl font-bold text-slate-800 tracking-tight">
                    {{ $users->where('role','seller')->count() }}
                </h2>

                <p class="text-slate-400 text-[11px] font-medium leading-tight">
                    Total authorized operational vendors.
                </p>
            </div>

            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-orange-50 text-orange-500 flex-shrink-0">
                <i class="fa-solid fa-store text-sm"></i>
            </div>

        </div>
    </div>
</a>

            <a href="{{ route('admin.buyers') }}" class="block no-underline">
    <div class="gradient-border-wrapper rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden cursor-pointer hover:scale-[1.02]">
        
        <div class="bg-white p-6 rounded-[23px] flex justify-between items-start h-full">
            
            <div class="space-y-2">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                    Total Buyers
                </p>

                <h2 class="text-4xl font-bold text-slate-800 tracking-tight">
                    {{ $users->where('role','buyer')->count() }}
                </h2>

                <p class="text-slate-400 text-[11px] font-medium leading-tight">
                    Consumer nodes interacting in marketplace.
                </p>
            </div>

            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-orange-50/50 text-orange-500 flex-shrink-0">
                <i class="fa-solid fa-cart-shopping text-sm"></i>
            </div>

        </div>
    </div>
</a>


           <a href="{{ route('admin.blocked') }}" class="block no-underline">
    <div class="gradient-border-wrapper rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden cursor-pointer hover:scale-[1.02]">
        
        <div class="bg-white p-6 rounded-[23px] flex justify-between items-start h-full">
            
            <div class="space-y-2">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                    Blocked Accounts
                </p>

                <h2 class="text-4xl font-bold text-slate-800 tracking-tight">
                    {{ $users->where('is_blocked',1)->count() }}
                </h2>

                <p class="text-slate-400 text-[11px] font-medium leading-tight">
                    Suspended users restricted from access.
                </p>
            </div>

            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-red-50 text-red-500 flex-shrink-0">
                <i class="fa-solid fa-user-lock text-sm"></i>
            </div>

        </div>
    </div>
</a>

        </div>

        {{-- SELLER APPLICATIONS WITH ACTION TRIGGERS --}}
        <div class="gradient-border-wrapper rounded-3xl shadow-sm overflow-hidden">
            <section id="seller-applications" class="bg-white rounded-[23px] p-6 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Seller Applications</h2>
                        <p class="text-slate-400 text-xs mt-0.5">Manage your storefront listings and profile approvals here.</p>
                    </div>
                    <button class="bg-gradient-to-r from-red-600 to-orange-500 text-white font-bold text-xs uppercase tracking-wider px-5 py-3 rounded-full shadow-sm hover:opacity-95 transition">
                        <i class="fa-solid mr-1"></i> Actions
                    </button>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100 pb-3">
                                <th class="pb-3 px-2">Applicant</th>
                                <th class="pb-3 px-2">Shop Name</th>
                                <th class="pb-3 px-2">Valid ID</th>
                                <th class="pb-3 px-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-50 text-slate-600">
                            @foreach($users->where('role', 'seller')->where('status', 'pending') as $seller)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-4 px-2">
                                    <div class="font-bold text-slate-800">{{ $seller->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $seller->email }}</div>
                                </td>
                                <td class="py-4 px-2 font-medium text-slate-700">{{ $seller->shop_name }}</td>
                                <td class="py-4 px-2">
                                    @if($seller->valid_id)
                                        <a href="{{ asset('storage/' . $seller->valid_id) }}" target="_blank" class="text-xs font-bold text-red-600 bg-red-50 px-2.5 py-1 rounded-lg border border-red-100 hover:bg-red-100 transition">
                                            View ID
                                        </a>
                                    @endif
                                </td>
                                <td class="py-4 px-2 text-right">
                                    <div class="inline-flex gap-2 justify-end">
                                        <form action="{{ route('admin.approve', $seller->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold text-white bg-slate-800 hover:bg-slate-900 px-4 py-2 rounded-xl transition">
                                                Accept
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reject', $seller->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs font-semibold text-slate-400 hover:text-slate-600 bg-slate-50 px-4 py-2 rounded-xl transition">
                                                Reject
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
        </div>

        {{-- USER RELATIONS: COMPLAINTS HUB --}}
        <section id="contacts" class="space-y-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Recent Inquiries</h2>
                <p class="text-slate-400 text-xs mt-0.5">Communications funneled directly from client ecosystem touchpoints.</p>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @forelse($contacts as $c)
                <div class="gradient-border-wrapper rounded-3xl shadow-sm hover:shadow-md transition overflow-hidden">
                    <div class="bg-white p-6 rounded-[23px] relative">
                        
                        @if(!$c->is_read)
                            <div class="absolute left-0 top-0 bottom-0 w-[4px] bg-red-600"></div>
                        @endif

                        <div class="flex justify-between items-start gap-4 mb-4">
                            <div>
                                <h3 class="font-bold text-base text-slate-800 tracking-tight">{{ $c->name }}</h3>
                                <p class="text-xs text-slate-400">{{ $c->email }}</p>
                            </div>
                            <div>
                                @if($c->is_read)
                                    <span class="text-[10px] font-bold uppercase tracking-wider bg-slate-50 text-slate-400 px-3 py-1 rounded-full border border-slate-100">Archived</span>
                                @else
                                    <span class="text-[10px] font-bold uppercase tracking-widest bg-red-50 text-red-600 px-3 py-1 rounded-full border border-red-100">New Message</span>
                                @endif
                            </div>
                        </div>

                        <p class="text-slate-500 text-xs leading-relaxed mb-6 bg-slate-50/50 p-4 rounded-2xl border border-slate-100/50">
                            {{ $c->message }}
                        </p>

                        <div class="flex flex-wrap items-center gap-2">
                            @if($c->user_id)
                                <a href="{{ route('admin.chat', $c->user_id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-white bg-slate-800 hover:bg-slate-900 px-4 py-2 rounded-xl transition shadow-sm">
                                    <i class="fa-solid fa-comments"></i> Reply in Chat
                                </a>
                            @endif

                            <a href="mailto:{{ $c->email }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 px-4 py-2 rounded-xl transition shadow-sm">
                                <i class="fa-solid fa-envelope"></i> Email
                            </a>

                            @if(!$c->is_read)
                                <form method="POST" action="{{ route('admin.contact.read', $c->id) }}" class="sm:ml-auto">
                                    @csrf
                                    <button class="text-xs font-bold text-emerald-600 hover:text-white bg-emerald-50 hover:bg-emerald-600 border border-emerald-100 hover:border-transparent px-4 py-2 rounded-xl transition shadow-sm">
                                        Mark as Read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center bg-white border border-slate-100 rounded-3xl p-12 shadow-sm text-slate-400 space-y-2">
                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-300">
                        <i class="fa-solid fa-tray text-lg"></i>
                    </div>
                    <p class="font-semibold text-slate-400 text-xs">Pipeline clear. No inbound documents detected.</p>
                </div>
                @endforelse
            </div>
        </section>
    </main>

</div>

</body>
</html>
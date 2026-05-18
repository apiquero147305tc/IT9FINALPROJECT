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
            background: #fdfefe;
            color: #0f172a;
        }
        /* Fluid premium scrollbars */
        .custom-scrollbar::-webkit-scrollbar {
            height: 5px;
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 99px;
        }
    </style>
</head>

<body class="antialiased min-h-screen selection:bg-orange-500/10 selection:text-orange-600">

<div class="flex flex-col md:flex-row min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-full md:w-64 bg-white/80 backdrop-blur-xl border-r border-slate-100 flex flex-col flex-shrink-0 sticky top-0 h-screen z-40">
        
        <div class="p-7 border-b border-slate-50 flex items-center gap-4">
            <div class="w-11 h-11 bg-gradient-to-tr from-red-500 via-orange-500 to-amber-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-orange-500/20 relative group">
                <div class="absolute inset-0 bg-white/20 rounded-2xl scale-75 blur-md opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <i class="fa-solid fa-cart-shopping text-base relative z-10"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-base tracking-tight text-slate-900">CraveCart</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Enterprise Suite</p>
            </div>
        </div>

        <nav class="p-5 flex-1 space-y-1.5 overflow-y-auto custom-scrollbar">
            <a href="#users" class="flex items-center justify-between px-4 py-3 text-sm font-semibold text-slate-900 bg-slate-50/80 rounded-xl border border-slate-100/50 shadow-sm shadow-slate-100/10 group transition-all">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-users text-red-500"></i>
                    <span>Users</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:translate-x-0.5 transition-transform"></i>
            </a>

            <a href="{{ route('admin.messages') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50/50 rounded-xl transition-all group">
                <i class="fa-solid fa-envelope text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                <span>Messages</span>
            </a>

            <a href="{{ route('admin.contacts') }}" class="relative flex items-center justify-between px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50/50 rounded-xl transition-all group">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-message text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                    <span>Complaints</span>
                </div>
                @if($unreadContacts > 0)
                    <span class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-black text-[10px] px-2 py-0.5 rounded-lg shadow-md shadow-orange-500/10">
                        {{ $unreadContacts }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50/50 rounded-xl transition-all group">
                <i class="fa-solid fa-chart-line text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                <span>Analytics</span>
            </a>

            <a href="{{ route('admin.users.delete.page') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50/50 rounded-xl transition-all group">
                <i class="fa-solid fa-trash text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                <span>Delete Accounts</span>
            </a>

            <div class="h-[1px] bg-slate-100 my-4 mx-2"></div>

            <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-400 hover:text-slate-900 hover:bg-slate-50/50 rounded-xl transition-all group">
                <i class="fa-solid fa-gear text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                <span>Settings</span>
            </a>
        </nav>
    </aside>

    {{-- MAIN AREA --}}
    <main class="flex-1 p-8 md:p-12 max-w-7xl mx-auto w-full space-y-12">

        {{-- PRESTIGE TOP HEADER --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 border-b border-slate-100 pb-8">
            <div class="space-y-1">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Welcome back, Control Center</h1>
                <p class="text-slate-400 text-sm">System oversight, operational approvals, and user relations network.</p>
            </div>
            <div class="bg-gradient-to-r from-red-500/[0.04] to-orange-500/[0.04] border border-orange-500/10 text-orange-600 text-[11px] font-bold uppercase tracking-widest px-4 py-2.5 rounded-xl shadow-sm shadow-orange-500/[0.02]">
                Root Administrator
            </div>
        </div>

        {{-- LUXURY STATS GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <a href="{{ route('admin.users') }}" class="group bg-white ring-1 ring-slate-100 hover:ring-red-500/20 p-6 rounded-2xl shadow-sm hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-red-500"></div>
                <div class="flex justify-between items-center">
                    <div class="space-y-1">
                        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Total Users</p>
                        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">{{ $users->count() }}</h2>
                    </div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-sm transition-all duration-300 bg-gradient-to-br from-red-50 to-red-100/50 text-red-500 border border-red-100/50 shadow-sm shadow-red-500/5 group-hover:from-red-500 group-hover:to-red-600 group-hover:text-white group-hover:border-transparent group-hover:shadow-md group-hover:shadow-red-500/20">
                        <i class="fa-solid fa-users transition-transform duration-300 group-hover:scale-110"></i>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.sellers') }}" class="group bg-white ring-1 ring-slate-100 hover:ring-orange-500/20 p-6 rounded-2xl shadow-sm hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-red-500 to-orange-500"></div>
                <div class="flex justify-between items-center">
                    <div class="space-y-1">
                        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Sellers</p>
                        <h2 class="text-3xl font-bold bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent tracking-tight">{{ $users->where('role','seller')->count() }}</h2>
                    </div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-sm transition-all duration-300 bg-gradient-to-br from-orange-50 to-amber-50/50 text-orange-500 border border-orange-100/50 shadow-sm shadow-orange-500/5 group-hover:from-red-500 group-hover:to-orange-500 group-hover:text-white group-hover:border-transparent group-hover:shadow-md group-hover:shadow-orange-500/20">
                        <i class="fa-solid fa-store transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3"></i>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.buyers') }}" class="group bg-white ring-1 ring-slate-100 hover:ring-orange-400/20 p-6 rounded-2xl shadow-sm hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-orange-500"></div>
                <div class="flex justify-between items-center">
                    <div class="space-y-1">
                        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Buyers</p>
                        <h2 class="text-3xl font-bold text-orange-500 tracking-tight">{{ $users->where('role','buyer')->count() }}</h2>
                    </div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-sm transition-all duration-300 bg-gradient-to-br from-amber-50 to-orange-50/30 text-orange-500 border border-orange-100/40 shadow-sm shadow-orange-500/5 group-hover:from-orange-500 group-hover:to-amber-500 group-hover:text-white group-hover:border-transparent group-hover:shadow-md group-hover:shadow-orange-500/20">
                        <i class="fa-solid fa-cart-shopping transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-3"></i>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.blocked') }}" class="group bg-white ring-1 ring-slate-100 hover:ring-slate-300 p-6 rounded-2xl shadow-sm hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-slate-300"></div>
                <div class="flex justify-between items-center">
                    <div class="space-y-1">
                        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Blocked Users</p>
                        <h2 class="text-3xl font-bold text-slate-400 tracking-tight">{{ $users->where('is_blocked',1)->count() }}</h2>
                    </div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-sm transition-all duration-300 bg-gradient-to-br from-slate-50 to-slate-100 text-slate-400 border border-slate-200/60 shadow-inner group-hover:from-slate-600 group-hover:to-slate-700 group-hover:text-white group-hover:border-transparent group-hover:shadow-md group-hover:shadow-slate-500/20">
                        <i class="fa-solid fa-user-lock transition-transform duration-300 group-hover:scale-110"></i>
                    </div>
                </div>
            </a>

        </div>

        {{-- DATA INTERFACE: SELLER APPLICATIONS --}}
        <section id="seller-applications" class="bg-white ring-1 ring-slate-100 rounded-2xl p-7 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-50 pb-5">
                <div class="space-y-0.5">
                    <h2 class="text-lg font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500 ring-4 ring-orange-500/10"></span>
                        Seller Verification Stream
                    </h2>
                    <p class="text-slate-400 text-xs">Onboarding profiles pending credential checking approvals.</p>
                </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100 bg-slate-50/40">
                            <th class="py-3.5 px-4 rounded-l-xl">Applicant Details</th>
                            <th class="py-3.5 px-4">Market Identity</th>
                            <th class="py-3.5 px-4">Demographics</th>
                            <th class="py-3.5 px-4">Legal Document</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right rounded-r-xl">Authorization</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50 text-slate-600">
                        @foreach($users->where('role', 'seller')->where('status', 'pending') as $seller)
                        <tr class="hover:bg-slate-50/[0.4] transition-colors group">
                            <td class="py-4 px-4">
                                <div class="font-semibold text-slate-800">{{ $seller->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $seller->email }}</div>
                            </td>
                            <td class="py-4 px-4 font-medium text-orange-600">{{ $seller->shop_name }}</td>
                            <td class="py-4 px-4">
                                <div class="text-slate-700 font-medium">Age: {{ $seller->age }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $seller->contact_number }}</div>
                            </td>
                            <td class="py-4 px-4">
                                @if($seller->valid_id)
                                    <a href="{{ asset('storage/' . $seller->valid_id) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-red-600 bg-slate-50 group-hover:bg-white border border-slate-100 hover:border-red-100 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                        <i class="fa-solid fa-file-invoice text-slate-400 group-hover:text-red-500"></i> View Credentials
                                    </a>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-lg bg-amber-50/70 text-amber-700 border border-amber-100/50">
                                    <span class="w-1 h-1 rounded-full bg-amber-500"></span> Pending
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex gap-2 justify-end">
                                    <form action="{{ route('admin.approve', $seller->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 px-4 py-2 rounded-xl transition-all shadow-sm">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reject', $seller->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-50 hover:bg-slate-100 px-4 py-2 rounded-xl transition-all">
                                            Decline
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

        {{-- DATA INTERFACE: USER MANAGEMENT --}}
        <section id="users" class="bg-white ring-1 ring-slate-100 rounded-2xl p-7 shadow-sm space-y-6">
            <div class="border-b border-slate-50 pb-5">
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">Global Directory</h2>
                <p class="text-slate-400 text-xs">Platform interaction controls and privilege escalation tools.</p>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100 bg-slate-50/40">
                            <th class="py-3.5 px-4 rounded-l-xl">Profile Information</th>
                            <th class="py-3.5 px-4">Assigned Hierarchy</th>
                            <th class="py-3.5 px-4">Network Node Status</th>
                            <th class="py-3.5 px-4 text-right rounded-r-xl">Operations</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50 text-slate-600">
                        @foreach($users->where('status', 'approved') as $user)
                        <tr class="hover:bg-slate-50/[0.4] transition-colors">
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                <div>{{ $user->name }}</div>
                                <div class="text-xs font-normal text-slate-400 mt-0.5">{{ $user->email }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-100 text-slate-600">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td class="py-4 px-4">
                                @if($user->is_blocked)
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded">Suspended</span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Operational</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex gap-2 justify-end items-center">
                                    @if(!$user->is_blocked)
                                        <form action="{{ route('admin.block', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs font-semibold text-slate-600 hover:text-red-600 bg-slate-50 hover:bg-red-50 border border-slate-100 hover:border-red-100 px-3 py-1.5 rounded-xl transition-all">
                                                Restrict User
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.unblock', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold text-white bg-gradient-to-r from-red-600 to-orange-500 px-3 py-1.5 rounded-xl shadow-sm transition-all">
                                                Reinstate
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.email.page', $user->id) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 px-3 py-1.5 rounded-xl transition-all shadow-sm">
                                        <i class="fa-solid fa-paper-plane text-slate-400"></i> Dispatch Mail
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- DATA INTERFACE: REJECTED RECORDS --}}
        <section id="rejected-users" class="bg-white ring-1 ring-slate-100 rounded-2xl p-7 shadow-sm space-y-6">
            <div class="border-b border-slate-50 pb-5">
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">Non-Compliant Logs</h2>
                <p class="text-slate-400 text-xs">Historical validation catalog of vendors excluded during onboarding validation filters.</p>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100 bg-slate-50/40">
                            <th class="py-3.5 px-4 rounded-l-xl">Identity</th>
                            <th class="py-3.5 px-4">Contact Node</th>
                            <th class="py-3.5 px-4">Proposed Outpost</th>
                            <th class="py-3.5 px-4 text-right rounded-r-xl">Compliance Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50 text-slate-400">
                        @foreach($users->where('role', 'seller')->where('status', 'rejected') as $seller)
                        <tr class="hover:bg-slate-50/[0.2] transition-colors">
                            <td class="py-4 px-4 font-medium text-slate-550">{{ $seller->name }}</td>
                            <td class="py-4 px-4 text-xs">{{ $seller->email }}</td>
                            <td class="py-4 px-4 font-medium italic">{{ $seller->shop_name }}</td>
                            <td class="py-4 px-4 text-right">
                                <span class="inline-block text-[10px] font-extrabold px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200 text-slate-400 uppercase tracking-wider">Denied Compliance</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- USER RELATIONS: COMPLAINTS HUB --}}
        <section id="contacts" class="space-y-6">
            <div class="border-b border-slate-100 pb-5">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Inquiry Routing Desktop</h2>
                <p class="text-slate-400 text-sm">Natively funneled communication feeds received from client ecosystem contact touchpoints.</p>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @forelse($contacts as $c)
                <div class="bg-white ring-1 ring-slate-100 rounded-2xl p-6 shadow-sm relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-slate-200/30">
                    
                    @if(!$c->is_read)
                        <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-gradient-to-b from-red-500 to-orange-500"></div>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-5">
                        <div>
                            <h3 class="font-bold text-base text-slate-800 tracking-tight">{{ $c->name }}</h3>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $c->email }}</p>
                        </div>
                        <div>
                            @if($c->is_read)
                                <span class="text-[10px] font-extrabold uppercase tracking-wider bg-slate-50 text-slate-400 px-3 py-1 rounded-lg border border-slate-100">Archived</span>
                            @else
                                <span class="text-[10px] font-black uppercase tracking-widest bg-gradient-to-r from-red-500/5 to-orange-500/5 text-orange-600 px-3 py-1 rounded-lg border border-orange-500/10">Action Required</span>
                            @endif
                        </div>
                    </div>

                    <div class="text-slate-600 text-sm leading-relaxed mb-6 bg-slate-50/60 p-4 rounded-xl border border-slate-100/60">
                        {{ $c->message }}
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        @if($c->user_id)
                            <a href="{{ route('admin.chat', $c->user_id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 px-4 py-2.5 rounded-xl transition-all shadow-md shadow-slate-900/10">
                                <i class="fa-solid fa-comments"></i> Native Correspondence Bridge
                            </a>
                        @endif

                        <a href="mailto:{{ $c->email }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 px-4 py-2.5 rounded-xl transition-all shadow-sm">
                            <i class="fa-solid fa-envelope text-slate-400"></i> Launch External Mail
                        </a>

                        @if(!$c->is_read)
                            <form method="POST" action="{{ route('admin.contact.read', $c->id) }}" class="sm:ml-auto">
                                @csrf
                                <button class="text-xs font-bold text-emerald-600 hover:text-white bg-emerald-50/[0.6] hover:bg-emerald-600 border border-emerald-100 hover:border-transparent px-4 py-2.5 rounded-xl transition-all shadow-sm">
                                    Archive Message
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center bg-white ring-1 ring-slate-100 rounded-2xl p-16 shadow-sm text-slate-300 space-y-4">
                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto text-slate-300 shadow-inner">
                        <i class="fa-solid fa-tray text-xl"></i>
                    </div>
                    <p class="font-medium text-slate-400 text-sm">Pipeline clear. No inbound documents detected.</p>
                </div>
                @endforelse
            </div>
        </section>
    </main>

</div>

</body>
</html>
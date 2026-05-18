<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | All Users</title>

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
        /* Fluid premium scrollbars for table bodies */
        .custom-scrollbar::-webkit-scrollbar {
            height: 5px;
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #fca5a5;
            border-radius: 99px;
        }
    </style>
</head>

<body class="antialiased min-h-screen selection:bg-red-500/10 selection:text-red-600">

<div class="max-w-6xl mx-auto p-8 md:p-12 space-y-8">

    {{-- PRESTIGE TOP HEADER WITH INTENSE RED GRADIENT --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 border-b border-slate-100 pb-8">
        <div class="space-y-1">
            <h1 class="text-3xl font-black tracking-tight">
                <span class="bg-gradient-to-r from-red-700 via-red-600 to-orange-500 bg-clip-text text-transparent">Registered Users</span>
            </h1>
            <p class="text-slate-400 text-sm">Comprehensive index of current live records within the platform ecosystem.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-white bg-gradient-to-r from-red-700 via-red-600 to-red-500 hover:from-red-600 hover:to-red-500 px-5 py-3 rounded-xl transition-all shadow-md shadow-red-600/20 hover:shadow-red-600/30 hover:-translate-y-0.5">
            <i class="fa-solid fa-arrow-left"></i>
            Return to Dashboard
        </a>
    </div>

    {{-- SEARCH BAR WITH RED INTERACTIVE ACCENT RING --}}
    <div class="max-w-xl">
        <div class="relative group">
            <input
                type="text"
                id="searchInput"
                placeholder="Search index by unique identifier name or email lookup..."
                class="w-full p-4 pl-12 rounded-xl border border-slate-200 bg-white text-sm placeholder-slate-400 focus:outline-none focus:border-red-500/40 focus:ring-4 focus:ring-red-500/[0.04] transition-all duration-200"
            >
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-red-500 transition-colors text-sm"></i>
        </div>
    </div>

    {{-- DATA INTERFACE: GLOBAL REGISTER --}}
    <div class="bg-white ring-1 ring-slate-100 rounded-2xl shadow-sm overflow-hidden relative">
        <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-red-700 via-red-500 to-orange-500"></div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100 bg-slate-50/40">
                        <th class="py-5 px-6">Identity Parameter</th>
                        <th class="py-5 px-6">Assigned Network Mail</th>
                        <th class="py-5 px-6">Role Rank</th>
                        <th class="py-5 px-6">Node Status</th>
                        <th class="py-5 px-6 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody id="usersTable" class="text-sm divide-y divide-slate-50 text-slate-600">

                    @foreach($users as $user)
                    <tr class="hover:bg-red-50/[0.15] transition-colors user-row group">

                        {{-- NAME --}}
                        <td class="py-4 px-6 font-semibold text-slate-800 group-hover:text-red-600 transition-colors duration-200 user-name">
                            {{ $user->name }}
                        </td>

                        {{-- EMAIL --}}
                        <td class="py-4 px-6 text-slate-400 font-medium user-email">
                            {{ $user->email }}
                        </td>

                        {{-- ROLE BADGES --}}
                        <td class="py-4 px-6">
                            @if($user->role == 'seller')
                                <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-lg bg-orange-50 text-orange-700 border border-orange-100/40">
                                    Seller
                                </span>
                            @elseif($user->role == 'buyer')
                                <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-100/40">
                                    Buyer
                                </span>
                            @else
                                <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-lg bg-red-50 text-red-700 border border-red-100/40">
                                    Admin
                                </span>
                            @endif
                        </td>

                        {{-- STATUS BADGES --}}
                        <td class="py-4 px-6">
                            @if($user->is_blocked)
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-lg bg-red-50 text-red-600 border border-red-100/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Restricted
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Operational
                                </span>
                            @endif
                        </td>

                        {{-- OPERATIONS INTERFACE --}}
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2 justify-end">
                                
                                @if(!$user->is_blocked)
                                    {{-- BLOCK FORM --}}
                                    <form action="{{ route('admin.block', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold text-slate-600 hover:text-red-600 bg-slate-50 hover:bg-red-50 border border-slate-100 hover:border-red-100 px-3 py-1.5 rounded-xl transition-all">
                                            Restrict
                                        </button>
                                    </form>
                                @else
                                    {{-- UNBLOCK FORM --}}
                                    <form action="{{ route('admin.unblock', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold text-white bg-red-700 hover:bg-red-800 px-3 py-1.5 rounded-xl shadow-sm transition-all">
                                            Reinstate
                                        </button>
                                    </form>
                                @endif
                                
                                {{-- DIRECT CONTACT MAIL --}}
                                <a href="{{ route('admin.email.page', $user->id) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-red-50 hover:border-red-200 px-3 py-1.5 rounded-xl transition-all shadow-sm">
                                    <i class="fa-solid fa-paper-plane text-slate-400 group-hover:text-red-600 transition-colors"></i> Dispatch Mail
                                </a>

                            </div>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- LIVE SEARCH SCRIPT CONFIGURATION --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('keyup', function () {
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('.user-row');

        rows.forEach(row => {
            const name = row.querySelector('.user-name').textContent.toLowerCase();
            const email = row.querySelector('.user-email').textContent.toLowerCase();

            if (name.includes(filter) || email.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>

</body>
</html>
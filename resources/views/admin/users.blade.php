<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | All Users</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
        }
        .table-row {
            transition: all 0.3s ease;
        }
        .table-row:hover {
            background: #faf8f5;
        }
        .action-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .action-btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="min-h-screen">

<div class="max-w-7xl mx-auto p-10">

    {{-- Header --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 flex justify-between items-center shadow-sm mb-10">

        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center border border-red-100 shadow-inner">
                <i class="fa-solid fa-users text-red-600 text-xl"></i>
            </div>
            <div>
                <h1 class="font-black text-slate-900 tracking-tight text-xl leading-none">All Users</h1>
                <p class="text-[10px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-1">Studio Hub</p>
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-red-600 text-white font-black px-6 py-3 rounded-2xl text-[11px] tracking-[0.15em] uppercase transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Dashboard
        </a>

    </div>

    {{-- Title Section --}}
    <div class="text-center mb-10">
        <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
            <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Directory</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
            Registered <span class="text-red-600">Users.</span>
        </h2>
        <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
            CraveCart Essentials Hub
        </p>
    </div>

    {{-- Stats Bar --}}
    <div class="flex gap-4 mb-8">
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-slate-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-users text-slate-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Total</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ $users->count() }}</p>
            </div>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-check text-green-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Active</p>
                <p class="text-lg font-black text-green-600 leading-none">{{ $users->where('is_blocked', false)->count() }}</p>
            </div>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-ban text-red-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Blocked</p>
                <p class="text-lg font-black text-red-600 leading-none">{{ $users->where('is_blocked', true)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="mb-6">
        <div class="relative">
            <input
                type="text"
                id="searchInput"
                placeholder="Search by name or email..."
                class="w-full bg-white border border-slate-100 rounded-2xl px-6 py-4 pl-14 text-slate-800 placeholder-slate-400 font-medium outline-none focus:ring-2 focus:ring-red-100 focus:border-red-200 transition shadow-sm"
            >
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[35px] shadow-sm border border-slate-100 overflow-hidden">

        {{-- Table Header --}}
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-slate-900 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-list text-white text-xs"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight uppercase">User Directory</h3>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5">
                <span class="text-slate-500 text-[10px] font-black tracking-[0.3em] uppercase">{{ $users->count() }} Records</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="p-5 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">User</th>
                        <th class="p-5 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Email</th>
                        <th class="p-5 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Role</th>
                        <th class="p-5 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Status</th>
                        <th class="p-5 text-center text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Actions</th>
                    </tr>
                </thead>

                <tbody id="usersTable">

                    @foreach($users as $user)

                    <tr class="table-row border-b border-slate-50 user-row">

                        {{-- Name --}}
                        <td class="p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600 font-black text-sm shadow-inner">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-bold text-slate-800 text-sm user-name">{{ $user->name }}</span>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="p-5 text-slate-500 text-sm font-medium user-email">{{ $user->email }}</td>

                        {{-- Role --}}
                        <td class="p-5">
                            @if($user->role == 'seller')
                                <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <i class="fa-solid fa-store text-[8px]"></i> Seller
                                </span>
                            @elseif($user->role == 'buyer')
                                <span class="inline-flex items-center gap-1.5 bg-blue-50 border border-blue-200 text-blue-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <i class="fa-solid fa-user text-[8px]"></i> Buyer
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-slate-50 border border-slate-200 text-slate-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <i class="fa-solid fa-shield text-[8px]"></i> Admin
                                </span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="p-5">
                            @if($user->is_blocked)
                                <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Blocked
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Active
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="p-5">
                            <div class="flex justify-center gap-2">

                                @if(!$user->is_blocked)
                                    <form action="{{ route('admin.block', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="action-btn inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-800 text-gray-600 hover:text-white px-4 py-2 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                            <i class="fa-solid fa-ban"></i> Block
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.unblock', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="action-btn inline-flex items-center gap-2 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white border border-blue-200 px-4 py-2 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                            <i class="fa-solid fa-unlock"></i> Unblock
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.email.page', $user->id) }}" class="action-btn inline-flex items-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 px-4 py-2 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                    <i class="fa-solid fa-envelope"></i> Email
                                </a>

                            </div>
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>
        </div>

        {{-- Footer --}}
        <div class="p-5 border-t border-slate-100 bg-slate-50 flex justify-between items-center">
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                <i class="fa-solid fa-circle-info mr-1"></i> Use search to filter results
            </p>
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                {{ $users->count() }} Total Records
            </p>
        </div>

    </div>

</div>

{{-- Search Script --}}
<script>
const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('keyup', function () {
    let filter = searchInput.value.toLowerCase();
    let rows = document.querySelectorAll('.user-row');

    rows.forEach(row => {
        let name = row.querySelector('.user-name').textContent.toLowerCase();
        let email = row.querySelector('.user-email').textContent.toLowerCase();

        if (name.includes(filter) || email.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Blocked Users</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
        }
        .user-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .user-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }
        .unblock-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .unblock-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 30px -10px rgba(34, 197, 94, 0.4);
        }
    </style>
</head>

<body class="min-h-screen">

<div class="max-w-7xl mx-auto p-10">

    {{-- Header --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 flex justify-between items-center shadow-sm mb-10">

        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center border border-red-100 shadow-inner">
                <i class="fa-solid fa-user-lock text-red-600 text-xl"></i>
            </div>
            <div>
                <h1 class="font-black text-slate-900 tracking-tight text-xl leading-none">Blocked Users</h1>
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
    <div class="text-center mb-12">
        <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
            <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Restricted Access</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
            Blocked <span class="text-red-600">Users.</span>
        </h2>
        <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
            CraveCart Essentials Hub
        </p>
    </div>

    {{-- Stats Bar --}}
    <div class="flex gap-4 mb-10">
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-user-lock text-red-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Blocked</p>
                <p class="text-lg font-black text-red-600 leading-none">{{ $users->count() }}</p>
            </div>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-slate-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-users text-slate-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Total Users</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ \App\Models\User::count() }}</p>
            </div>
        </div>
    </div>

    {{-- Users Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        @foreach($users as $user)

        <div class="user-card bg-white rounded-[35px] shadow-sm border border-slate-100 p-8 relative overflow-hidden group">

            {{-- Top accent line --}}
            <div class="absolute top-0 left-0 w-full h-1 bg-red-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

            <div class="flex justify-between items-start mb-6">

                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 font-black text-xl shadow-inner">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 tracking-tight">{{ $user->name }}</h2>
                        <p class="text-xs text-slate-400 font-medium">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-500 shadow-inner border border-red-100 group-hover:bg-red-600 group-hover:text-white transition-all duration-500">
                    <i class="fa-solid fa-user-lock text-sm"></i>
                </div>

            </div>

            {{-- Role & Status --}}
            <div class="flex gap-2 mb-6">
                <span class="inline-flex items-center gap-1.5 bg-{{ $user->role === 'seller' ? 'red' : 'blue' }}-50 border border-{{ $user->role === 'seller' ? 'red' : 'blue' }}-200 text-{{ $user->role === 'seller' ? 'red' : 'blue' }}-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                    <i class="fa-solid fa-{{ $user->role === 'seller' ? 'store' : 'user' }} text-[8px]"></i> {{ ucfirst($user->role) }}
                </span>
                <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Blocked
                </span>
            </div>

            {{-- Unblock Button --}}
            <form action="{{ route('admin.unblock', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="unblock-btn w-full bg-green-50 hover:bg-green-600 text-green-600 hover:text-white border border-green-200 font-black py-4 rounded-2xl transition-all duration-300 tracking-[0.1em] uppercase text-[11px] flex items-center justify-center gap-2">
                    <i class="fa-solid fa-unlock"></i>
                    Unblock User
                </button>
            </form>

            {{-- Footer Info --}}
            <div class="mt-5 pt-4 border-t border-slate-100 flex justify-between items-center">
                <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                    <i class="fa-solid fa-calendar mr-1"></i> Blocked {{ $user->updated_at ? $user->updated_at->format('M d, Y') : 'N/A' }}
                </p>
                <p class="text-[10px] font-bold text-slate-300 tracking-wider uppercase">ID: #{{ $user->id }}</p>
            </div>

        </div>

        @endforeach

    </div>

    {{-- Empty State --}}
    @if($users->count() === 0)
    <div class="text-center py-20">
        <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
            <i class="fa-solid fa-shield-halved text-4xl text-slate-200"></i>
        </div>
        <div class="inline-block bg-green-100 border border-green-200 rounded-full px-4 py-1.5 mb-4">
            <span class="text-green-600 text-[10px] font-black tracking-[0.4em] uppercase">All Clear</span>
        </div>
        <h3 class="text-2xl font-black text-slate-900 tracking-tight uppercase mb-2">No Blocked Users.</h3>
        <p class="text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">CraveCart Studio Hub</p>
    </div>
    @endif

</div>

</body>
</html>
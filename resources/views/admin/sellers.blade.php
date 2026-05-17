<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Sellers</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
        }
        .seller-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .seller-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body class="min-h-screen">

<div class="max-w-7xl mx-auto p-10">

    {{-- Header --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 flex justify-between items-center shadow-sm mb-10">

        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center border border-red-100 shadow-inner">
                <i class="fa-solid fa-store text-red-600 text-xl"></i>
            </div>
            <div>
                <h1 class="font-black text-slate-900 tracking-tight text-xl leading-none">Sellers</h1>
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
            <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Marketplace</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
            Registered <span class="text-red-600">Sellers.</span>
        </h2>
        <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
            CraveCart Essentials Hub
        </p>
    </div>

    {{-- Stats Bar --}}
    <div class="flex gap-4 mb-10">
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-store text-red-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Total Sellers</p>
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

    {{-- Sellers Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        @foreach($users as $seller)

        <div class="seller-card bg-white rounded-[35px] shadow-sm border border-slate-100 p-8 relative overflow-hidden group">

            {{-- Top accent line --}}
            <div class="absolute top-0 left-0 w-full h-1 bg-red-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

            <div class="flex justify-between items-start mb-6">

                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 font-black text-xl shadow-inner">
                        {{ strtoupper(substr($seller->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 tracking-tight">{{ $seller->name }}</h2>
                        <p class="text-xs text-slate-400 font-medium">{{ $seller->email }}</p>
                    </div>
                </div>

                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-500 shadow-inner border border-red-100 group-hover:bg-red-600 group-hover:text-white transition-all duration-500">
                    <i class="fa-solid fa-store text-sm"></i>
                </div>

            </div>

            {{-- Shop Info --}}
            @if($seller->shop_name)
            <div class="bg-slate-50 rounded-xl p-4 mb-5 border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 tracking-wider uppercase mb-1">Shop Name</p>
                <p class="font-bold text-slate-800 text-sm">{{ $seller->shop_name }}</p>
            </div>
            @endif

            {{-- Status & Actions --}}
            <div class="flex items-center justify-between">

                @if($seller->is_blocked)
                    <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Blocked
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Active
                    </span>
                @endif

                <div class="flex gap-2">
                    <a href="{{ route('admin.email.page', $seller->id) }}" class="w-9 h-9 bg-slate-50 hover:bg-slate-900 rounded-xl flex items-center justify-center text-slate-400 hover:text-white transition-all duration-300 border border-slate-200">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </a>
                    @if($seller->user_id)
                    <a href="{{ route('admin.chat', $seller->id) }}" class="w-9 h-9 bg-red-50 hover:bg-red-600 rounded-xl flex items-center justify-center text-red-400 hover:text-white transition-all duration-300 border border-red-200">
                        <i class="fa-solid fa-comments text-xs"></i>
                    </a>
                    @endif
                </div>

            </div>

            {{-- Footer Info --}}
            <div class="mt-5 pt-4 border-t border-slate-100 flex justify-between items-center">
                <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                    <i class="fa-solid fa-calendar mr-1"></i> {{ $seller->created_at->format('M d, Y') }}
                </p>
                <p class="text-[10px] font-bold text-slate-300 tracking-wider uppercase">ID: #{{ $seller->id }}</p>
            </div>

        </div>

        @endforeach

    </div>

    {{-- Empty State --}}
    @if($users->count() === 0)
    <div class="text-center py-20">
        <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
            <i class="fa-solid fa-store text-4xl text-slate-200"></i>
        </div>
        <div class="inline-block bg-slate-100 border border-slate-200 rounded-full px-4 py-1.5 mb-4">
            <span class="text-slate-500 text-[10px] font-black tracking-[0.4em] uppercase">Empty Marketplace</span>
        </div>
        <h3 class="text-2xl font-black text-slate-900 tracking-tight uppercase mb-2">No Sellers Yet.</h3>
        <p class="text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">CraveCart Studio Hub</p>
    </div>
    @endif

</div>

</body>
</html>
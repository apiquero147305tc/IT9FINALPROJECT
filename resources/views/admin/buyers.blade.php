<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Buyers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #faf8f5; }
    </style>
</head>
<body class="min-h-screen p-8 md:p-12">

    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="bg-white rounded-3xl p-6 flex justify-between items-center shadow-sm mb-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center">
                    <i class="fa-solid fa-user text-red-600"></i>
                </div>
                <div>
                    <h1 class="font-black text-slate-900 text-lg leading-none">Buyers</h1>
                    <p class="text-[10px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-1">Studio Hub</p>
                </div>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-slate-900 hover:bg-red-600 text-white font-black px-6 py-3 rounded-2xl text-[11px] tracking-widest uppercase transition">
                ← Dashboard
            </a>
        </div>

        {{-- Title --}}
        <div class="text-center mb-10">
            <span class="inline-block bg-red-100 text-red-600 rounded-full px-4 py-1.5 text-[10px] font-black tracking-[0.3em] uppercase mb-4">Directory</span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase">
                Registered <span class="text-red-600">Buyers.</span>
            </h2>
            <p class="mt-3 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">CraveCart Essentials Hub</p>
        </div>

        {{-- Stats --}}
        <div class="flex gap-4 mb-10">
            <div class="bg-white rounded-2xl px-5 py-3 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center text-xs">
                    <i class="fa-solid fa-users text-red-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Total</p>
                    <p class="text-lg font-black text-slate-900">{{ $users->count() }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl px-5 py-3 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 bg-green-50 rounded-xl flex items-center justify-center text-xs">
                    <i class="fa-solid fa-check text-green-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Active</p>
                    <p class="text-lg font-black text-green-600">{{ $users->where('is_blocked', false)->count() }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl px-5 py-3 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center text-xs">
                    <i class="fa-solid fa-ban text-red-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Blocked</p>
                    <p class="text-lg font-black text-red-600">{{ $users->where('is_blocked', true)->count() }}</p>
                </div>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($users as $buyer)

            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 hover:shadow-md transition">

                {{-- Top Row --}}
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 font-black text-lg">
                            {{ strtoupper(substr($buyer->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">{{ $buyer->name }}</h3>
                            <p class="text-xs text-slate-400">{{ $buyer->email }}</p>
                        </div>
                    </div>
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-user text-red-400 text-sm"></i>
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    @if($buyer->is_blocked)
                        <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Blocked
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-600 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Active
                        </span>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex gap-2 pt-4 border-t border-slate-100">
                    @if(!$buyer->is_blocked)
                        <form action="{{ route('admin.block', $buyer->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button class="w-full bg-slate-900 hover:bg-slate-800 text-white py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition">
                                Block
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.unblock', $buyer->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition">
                                Unblock
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.email.page', $buyer->id) }}" class="w-12 h-10 bg-red-50 hover:bg-red-100 text-red-500 rounded-xl flex items-center justify-center transition">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </a>
                </div>

                {{-- Footer --}}
                <div class="flex justify-between items-center mt-4 pt-3 border-t border-slate-50">
                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">
                        <i class="fa-regular fa-calendar mr-1"></i> {{ $buyer->created_at->format('M d, Y') }}
                    </span>
                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">
                        ID: #{{ $buyer->id }}
                    </span>
                </div>

            </div>

            @endforeach

        </div>

    </div>

</body>
</html>
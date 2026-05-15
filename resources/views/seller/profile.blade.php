<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Profile Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        
        body { 
            background-color: #fffaf9; 
            font-family: 'Inter', sans-serif; 
            color: #1e1b1a; 
        }

        /* 🔴 Red-Orange Branded Nav */
        .nav-branded { 
            background-color: #ea580c; 
            border-bottom: 2px solid #991b1b;
        }

        /* 🔥 High-impact Accents */
        .accent-red-orange { color: #dc2626; }
        .bg-red-orange { background-color: #ea580c; }
        
        input:focus {
            border-color: #ea580c !important;
            ring-color: #fecaca !important;
        }

        ::selection {
            background: #dc2626;
            color: white;
        }
    </style>
</head>
<body class="min-h-screen">

    <nav class="nav-branded px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ route('seller.dash') }}" class="bg-white p-2 rounded-xl shadow-md hover:scale-110 transition-all group">
                <span class="text-xl group-hover:-translate-x-1 inline-block transition-transform">⬅️</span>
            </a>
            <h1 class="text-xs font-black tracking-widest uppercase text-white">
                Back to <span class="text-orange-200">Studio</span>
            </h1>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto p-6 md:p-12">
        
        @if(session('success'))
            <div class="mb-10 p-5 bg-green-50 border-2 border-green-200 rounded-[2rem] flex items-center gap-4 shadow-sm">
                <div class="bg-green-500 p-1.5 rounded-full text-white text-xs">✔</div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="mb-12">
            <h2 class="text-6xl font-black tracking-tighter uppercase text-slate-900 leading-none">Settings</h2>
            <div class="h-2 w-16 bg-red-600 mt-4 rounded-full"></div>
            <p class="text-[10px] font-bold text-red-600 uppercase tracking-[0.4em] mt-6">Manage your Seller Identity</p>
        </div>

        <form action="{{ route('seller.profile.update') }}" method="POST" class="space-y-10">
            @csrf
            
            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Shop Name</label>
                <input type="text" name="shop_name" value="{{ Auth::user()->shop_name }}" 
                    class="w-full bg-white border-4 border-slate-50 rounded-3xl p-6 text-xl font-bold text-slate-900 outline-none transition-all focus:shadow-2xl focus:shadow-orange-500/10">
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Personal Name</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" 
                    class="w-full bg-white border-4 border-slate-50 rounded-3xl p-6 text-xl font-bold text-slate-900 outline-none transition-all focus:shadow-2xl focus:shadow-orange-500/10">
            </div>

            <div class="flex items-center gap-8 p-10 bg-red-50/50 rounded-[3rem] border border-red-100/50 relative overflow-hidden">
                <div class="w-24 h-24 rounded-[2rem] bg-red-orange flex items-center justify-center text-3xl font-black text-white shadow-2xl shadow-red-500/40 z-10">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="z-10">
                    <p class="text-xs font-black uppercase tracking-widest text-red-950 mb-1">Avatar Preview</p>
                    <p class="text-[11px] text-red-600/60 font-bold uppercase tracking-tight">Appearing in the Studio Nav</p>
                </div>
                <div class="absolute -right-4 -bottom-4 text-9xl opacity-[0.03] select-none">🎨</div>
            </div>

            <button type="submit" 
                class="w-full bg-slate-950 text-white py-6 rounded-[2rem] font-black uppercase tracking-[0.3em] text-[11px] hover:bg-red-600 transition-all shadow-2xl shadow-slate-900/20 active:scale-95">
                Update Identity
            </button>
        </form>

        <div class="mt-20 text-center">
            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.5em]">CraveCart Student Marketplace v1.0</p>
        </div>
    </main>
</body>
</html>
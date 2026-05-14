<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Profile Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        body { background-color: #ffffff; font-family: 'Inter', sans-serif; color: #0f172a; }
        .nav-branded { background-color: #fb923c; }
    </style>
</head>
<body class="min-h-screen">

    <!-- Navbar -->
    <nav class="nav-branded px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <div class="flex items-center gap-2">
            <!-- ✅ FIXED: Changed route name from seller.dashboard to seller.dash -->
            <a href="{{ route('seller.dash') }}" class="bg-white p-1.5 rounded-xl shadow-sm hover:scale-105 transition">
                <span class="text-xl">⬅️</span>
            </a>
            <h1 class="text-sm font-extrabold tracking-tight uppercase text-orange-950">
                Back to Studio
            </h1>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto p-6 md:p-12">
        
        <!-- ✅ NEW: Success Message Alert -->
        @if(session('success'))
            <div class="mb-8 p-5 bg-green-50 border-2 border-green-200 rounded-2xl flex items-center gap-4">
                <span class="text-2xl">✅</span>
                <p class="text-sm font-black uppercase tracking-widest text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="mb-12">
            <h2 class="text-6xl font-black tracking-tighter uppercase text-slate-900 leading-none">Settings</h2>
            <p class="text-xs font-bold text-orange-400 uppercase tracking-[0.3em] mt-2">Manage your Seller Identity</p>
        </div>

        <form action="{{ route('seller.profile.update') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Shop Name Input -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Shop Name</label>
                <input type="text" name="shop_name" value="{{ Auth::user()->shop_name }}" 
                    class="w-full border-4 border-slate-100 rounded-2xl p-5 text-xl font-bold focus:border-orange-400 outline-none transition">
            </div>

            <!-- Seller Name Input -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Personal Name</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" 
                    class="w-full border-4 border-slate-100 rounded-2xl p-5 text-xl font-bold focus:border-orange-400 outline-none transition">
            </div>

            <!-- Profile Initials Preview -->
            <div class="flex items-center gap-6 p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100">
                <div class="w-20 h-20 rounded-full bg-orange-400 flex items-center justify-center text-2xl font-black text-white shadow-lg">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div>
                    <p class="text-sm font-black uppercase text-slate-900">Avatar Preview</p>
                    <p class="text-xs text-slate-400 font-medium">This is how you appear in the navigation bar.</p>
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-orange-950 text-white py-6 rounded-2xl font-black uppercase tracking-[0.2em] text-sm hover:bg-black transition-all shadow-xl shadow-orange-900/10">
                Update Profile
            </button>
        </form>
    </main>
</body>
</html>
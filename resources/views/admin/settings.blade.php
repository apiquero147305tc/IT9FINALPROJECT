<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings | CraveCart Studio Hub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
        }
        .sidebar-link {
            transition: all 0.3s ease;
        }
        .sidebar-link:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .sidebar-link.active {
            background: #0f172a;
            color: white;
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            background: white;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
    </style>
</head>

<body class="min-h-screen">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-72 bg-white border-r border-slate-100 min-h-screen p-6 flex flex-col fixed">

        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-10">
            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center border border-red-100 shadow-inner">
                <i class="fa-solid fa-gear text-red-600 text-lg"></i>
            </div>
            <div>
                <h1 class="font-black text-slate-900 tracking-tight text-lg leading-none">CraveCart</h1>
                <p class="text-[10px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-0.5">Studio Hub</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 space-y-1">

            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 font-semibold text-sm">
                <i class="fa-solid fa-chart-line w-5 text-center"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.settings') }}" class="sidebar-link active flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold text-sm">
                <i class="fa-solid fa-gear w-5 text-center"></i>
                Settings
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full sidebar-link flex items-center gap-3 px-4 py-3.5 rounded-2xl text-red-500 font-semibold text-sm hover:bg-red-50 hover:text-red-600">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    Logout
                </button>
            </form>

        </nav>

    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 ml-72 p-10">

        {{-- Header --}}
        <div class="mb-10">
            <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
                <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Account Control</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
                Admin <span class="text-red-600">Settings.</span>
            </h2>
            <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
                CraveCart Essentials Hub
            </p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-5 rounded-2xl mb-6 font-bold text-sm flex items-center gap-3 max-w-3xl">
            <div class="w-8 h-8 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-check text-green-600 text-xs"></i>
            </div>
            {{ session('success') }}
        </div>
        @endif

        {{-- Settings Card --}}
        <div class="bg-white rounded-[35px] shadow-sm border border-slate-100 p-10 max-w-3xl">

            {{-- Profile Icon --}}
            <div class="flex justify-center mb-10">
                <div class="w-28 h-28 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-400 text-4xl shadow-inner border border-slate-100">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">
                        Full Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ $admin->name }}"
                        class="input-field w-full bg-slate-50 border-0 rounded-xl px-5 py-4 text-slate-800 font-medium outline-none focus:ring-2 focus:ring-red-100 transition"
                    >
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">
                        Email Address
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ $admin->email }}"
                        class="input-field w-full bg-slate-50 border-0 rounded-xl px-5 py-4 text-slate-800 font-medium outline-none focus:ring-2 focus:ring-red-100 transition"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">
                        New Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Leave blank to keep current password"
                        class="input-field w-full bg-slate-50 border-0 rounded-xl px-5 py-4 text-slate-800 placeholder-slate-400 font-medium outline-none focus:ring-2 focus:ring-red-100 transition"
                    >
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="input-field w-full bg-slate-50 border-0 rounded-xl px-5 py-4 text-slate-800 placeholder-slate-400 font-medium outline-none focus:ring-2 focus:ring-red-100 transition"
                    >
                </div>

                {{-- Button --}}
                <button type="submit" class="w-full bg-slate-900 hover:bg-red-600 text-white font-black py-4 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl tracking-[0.1em] uppercase text-[11px] mt-4 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Changes
                </button>

            </form>

        </div>

        {{-- Footer --}}
        <div class="mt-10 max-w-3xl flex justify-between items-center">
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                <i class="fa-solid fa-shield-halved mr-1"></i> Secure Account Management
            </p>
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                Admin ID: #{{ $admin->id }}
            </p>
        </div>

    </main>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Admin Settings</title>

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
            background: linear-gradient(to right, #ba1124 0%, #d31c30 70%, #f97316 100%);
            padding: 1px;
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
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
                </a>

                <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
                    <i class="fa-solid fa-chart-line text-sm"></i>
                    <span>Analytics</span>
                </a>

                <a href="{{ route('admin.users.delete.page') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
                    <i class="fa-solid fa-trash text-sm"></i>
                    <span>Delete Accounts</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-wider text-red-600 bg-red-50/60 rounded-xl transition-all">
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
        <div class="bg-gradient-to-r from-[#ba1124] via-[#d31c30] to-[#f97316] text-white rounded-3xl p-6 md:p-8 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative overflow-hidden">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white/90">
                    <i class="fa-solid fa-gear text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Admin Settings</h1>
                    <p class="text-white/70 text-xs font-semibold uppercase tracking-wider mt-0.5">Manage your administrator account</p>
                </div>
            </div>
            
            <a href="{{ route('admin.dashboard') }}"
               class="bg-black/15 backdrop-blur-sm border border-white/10 text-white font-bold text-xs uppercase tracking-wider px-5 py-3 rounded-xl shadow-sm hover:bg-black/25 transition">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Dashboard
            </a>
        </div>

        {{-- SUCCESS ALERT FEEDBACK --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl font-semibold text-sm shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- SETTINGS FORM WRAPPED IN PREMIUM ROUNDED GRADIENT LAYOUT --}}
        <div class="max-w-3xl">
            <div class="gradient-border-wrapper rounded-3xl shadow-sm overflow-hidden">
                <div class="bg-white p-6 md:p-8 rounded-[23px]">
                    
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- CENTERED PROFILE SHIELD COMPONENT --}}
                        <div class="flex justify-center pb-4">
                            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-red-50 to-red-100/50 text-red-600 border border-red-100/50 flex items-center justify-center text-3xl shadow-sm">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                        </div>

                        {{-- NAME ENTRY HUB --}}
                        <div class="space-y-2">
                            <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider">
                                Full Name
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="{{ $admin->name }}"
                                class="w-full border border-slate-200 bg-slate-50/50 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-red-500/40 focus:ring-4 focus:ring-red-500/[0.03] transition-all duration-200"
                            >
                        </div>

                        {{-- EMAIL ADDRESS ENTRY HUB --}}
                        <div class="space-y-2">
                            <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider">
                                Email Address
                            </label>
                            <input
                                type="email"
                                name="email"
                                value="{{ $admin->email }}"
                                class="w-full border border-slate-200 bg-slate-50/50 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-red-500/40 focus:ring-4 focus:ring-red-500/[0.03] transition-all duration-200"
                            >
                        </div>

                        {{-- PASSWORD SECURITY MODIFICATION BLOCK --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider">
                                    New Password
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Leave blank to keep current"
                                    class="w-full border border-slate-200 bg-slate-50/50 rounded-2xl px-5 py-3.5 text-sm placeholder-slate-400 outline-none focus:border-red-500/40 focus:ring-4 focus:ring-red-500/[0.03] transition-all duration-200"
                                App>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider">
                                    Confirm Password
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="w-full border border-slate-200 bg-slate-50/50 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-red-500/40 focus:ring-4 focus:ring-red-500/[0.03] transition-all duration-200"
                                >
                            </div>
                        </div>

                        {{-- EXECUTE SUBMIT OPERATIONS ACTION BAR --}}
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-700 via-red-600 to-red-500 hover:from-red-600 hover:to-red-500 text-white font-bold py-4 rounded-xl text-xs uppercase tracking-widest shadow-md shadow-red-600/10 transition-all duration-200 active:scale-95">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>

</div>

</body>
</html>
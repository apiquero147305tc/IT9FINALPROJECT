<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Profile Settings</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
        }

        /* Interactive modern inputs matching the Studio layout design system */
        .form-input-premium {
            width: 100%;
            border: 2px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            background-color: #ffffff;
        }

        .form-input-premium:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.08);
            background-color: #fffbfc;
        }

        .form-label-premium {
            display: block;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            margin-bottom: 0.5rem;
            margin-left: 0.25rem;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50/60 antialiased">

    {{-- ========================================================= --}}
    {{-- UNIFIED BRANDED GRADIENT NAVIGATION BAR                    --}}
    {{-- ========================================================= --}}
    <nav class="bg-gradient-to-r from-rose-600 via-orange-500 to-amber-500 w-full shadow-lg shadow-orange-500/10 border-b border-orange-600/20 sticky top-0 z-50 py-4 px-4 md:px-6">
        <div class="max-w-2xl mx-auto flex items-center justify-between text-white">
            
            <div class="flex items-center gap-3">
                <a href="{{ route('seller.dash') }}" class="bg-white/10 p-2.5 rounded-xl border border-white/10 flex items-center justify-center backdrop-blur-sm transition hover:bg-white/20 active:scale-95">
                    <i class="fa-solid fa-arrow-left text-sm text-orange-200"></i>
                </a>
                <div>
                    <h1 class="text-base font-black tracking-tight leading-none">Seller Studio</h1>
                    <p class="text-[10px] text-orange-100/70 font-medium mt-1">Merchant Profile Settings</p>
                </div>
            </div>

            <a href="{{ route('seller.dash') }}" class="inline-flex items-center gap-1.5 bg-black/15 backdrop-blur-md px-3 py-2 rounded-xl text-[10px] font-bold uppercase tracking-wider border border-white/10 text-white hover:bg-black/25 transition">
                Dashboard
            </a>
        </div>
    </nav>

    {{-- ========================================================= --}}
    {{-- MAIN HUB CONFIGURATION WORKSPACE                          --}}
    {{-- ========================================================= --}}
    <main class="max-w-2xl mx-auto p-4 md:p-8 space-y-8">
        
        {{-- Section Header Identifier Row --}}
        <div class="border-b border-slate-200/60 pb-5">
            <h2 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-id-card text-orange-500"></i> Identity Settings
            </h2>
            <p class="text-xs text-slate-400 mt-1">Modify your storefront's branding properties and account metadata entries.</p>
        </div>

        {{-- Success Message Notification Alert Box --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 shadow-sm transition-all">
                <div class="w-8 h-8 bg-emerald-500 text-white rounded-xl flex items-center justify-center text-xs shadow-md shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-check text-sm"></i>
                </div>
                <p class="text-xs font-bold text-emerald-800 uppercase tracking-wider">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white border border-slate-100 rounded-3xl shadow-sm p-6 md:p-10">
            <form action="{{ route('seller.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Shop Name Field Configuration --}}
                <div class="space-y-1.5">
                    <label class="form-label-premium">Shop Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none text-base">
                            <i class="fa-solid fa-store"></i>
                        </span>
                        <input type="text" name="shop_name" value="{{ Auth::user()->shop_name }}" required class="form-input-premium pl-11">
                    </div>
                </div>

                {{-- Seller Name Field Configuration --}}
                <div class="space-y-1.5">
                    <label class="form-label-premium">Personal Legal Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none text-base">
                            <i class="fa-solid fa-user-gear"></i>
                        </span>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required class="form-input-premium pl-11">
                    </div>
                </div>

                {{-- Interactive Avatar Registry Mockup Preview Card --}}
                <div class="flex items-center gap-5 p-5 bg-slate-50/60 rounded-2xl border border-slate-100 shadow-inner">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-rose-500 to-orange-500 flex items-center justify-center text-lg font-black text-white shadow-lg shadow-orange-500/20 uppercase tracking-wider flex-shrink-0 ring-4 ring-white">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                    <div class="space-y-0.5">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wide flex items-center gap-1">
                            <i class="fa-solid fa-circle-user text-orange-500"></i> Avatar Component Preview
                        </h4>
                        <p class="text-[11px] text-slate-400 font-medium leading-relaxed">This automatic token badge identifies your account across navigation headers and transactional logs files.</p>
                    </div>
                </div>

                {{-- Operational Action Control Buttons Row --}}
                <div class="pt-4 flex flex-col sm:flex-row items-center gap-3">
                    <button type="submit" 
                            class="w-full sm:flex-1 bg-gradient-to-r from-rose-500 via-orange-500 to-orange-600 text-white py-4 rounded-xl font-bold uppercase tracking-wider text-xs hover:opacity-95 active:scale-95 transition-all shadow-lg shadow-orange-500/10">
                        <i class="fa-regular fa-floppy-disk mr-1 text-sm"></i> Save Identity Alterations
                    </button>
                    
                    <a href="{{ route('seller.dash') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center bg-white border border-slate-200 text-slate-500 hover:text-slate-700 hover:bg-slate-50 px-6 py-4 rounded-xl font-bold uppercase tracking-wider text-xs transition active:scale-95 shadow-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('seller.dash') }}" class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-orange-500 transition-colors">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Return to Studio Dashboard
            </a>
        </div>
    </main>
</body>
</html>
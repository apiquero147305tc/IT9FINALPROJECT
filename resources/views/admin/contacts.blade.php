<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Contact Messages</title>

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
        
        /* Premium Gradient Border Layout with Heavy Red Dominance */
        .gradient-border-wrapper {
            position: relative;
            background: linear-gradient(to right, #ba1124 0%, #d31c30 70%, #f97316 100%);
            padding: 1px; /* The border thickness */
        }
    </style>
</head>

<body class="antialiased min-h-screen selection:bg-red-500/10 selection:text-red-600">

<div class="max-w-5xl mx-auto p-6 md:p-12 space-y-8">

    {{-- RED-DOMINANT HERO BANNER WITH SUBTLE ORANGE TAIL --}}
    <div class="bg-gradient-to-r from-[#ba1124] via-[#d31c30] to-[#f97316] text-white rounded-3xl p-6 md:p-8 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative overflow-hidden">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white/90">
                <i class="fa-solid fa-inbox text-lg"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Contact Messages</h1>
                <p class="text-white/70 text-xs font-semibold uppercase tracking-wider mt-0.5">User Inquiries & Complaints</p>
            </div>
        </div>
        
        <a href="{{ route('admin.dashboard') }}"
           class="bg-black/15 backdrop-blur-sm border border-white/10 text-white font-bold text-xs uppercase tracking-wider px-5 py-3 rounded-xl shadow-sm hover:bg-black/25 transition">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Dashboard
        </a>
    </div>

    {{-- MESSAGE FEED LIST --}}
    <div class="space-y-6">

        @forelse($contacts as $msg)
            <div class="gradient-border-wrapper rounded-3xl shadow-sm hover:shadow-md transition overflow-hidden">
                <div class="bg-white p-6 rounded-[23px] relative">
                    
                    {{-- Native Left Border Accent Indicator - Heavy Red --}}
                    <div class="absolute left-0 top-0 bottom-0 w-[4px] {{ $msg->is_read ? 'bg-slate-200' : 'bg-red-600' }}"></div>

                    {{-- TOP INFO CARD PANEL --}}
                    <div class="flex justify-between items-start gap-4 mb-4">
                        <div>
                            <h3 class="font-bold text-slate-800 text-base tracking-tight leading-tight group-hover:text-red-600 transition-colors">
                                {{ $msg->name }}
                            </h3>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">
                                {{ $msg->email }}
                            </p>
                        </div>

                        {{-- STATUS BADGE CONTROLS --}}
                        <div>
                            @if(!$msg->is_read)
                                <span class="text-[10px] font-bold uppercase tracking-widest bg-red-50 text-red-600 px-3 py-1 rounded-full border border-red-100">
                                    New Message
                                </span>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-slate-50 text-slate-400 px-3 py-1 rounded-full border border-slate-100">
                                    Archived
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- MESSAGE TEXT AREA --}}
                    <p class="text-slate-600 text-sm leading-relaxed mb-6 bg-slate-50/50 p-4 rounded-2xl border border-slate-100/50">
                        {{ $msg->message }}
                    </p>

                    {{-- ACTIONS AT CARD FOOTER --}}
                    <div class="flex items-center gap-3">
                        @if(!$msg->is_read)
                            <form method="POST" action="{{ route('admin.contacts.read', $msg->id) }}">
                                @csrf
                                <button class="text-xs font-bold text-white bg-gradient-to-r from-red-700 via-red-600 to-red-500 hover:from-red-600 hover:to-red-500 px-4 py-2.5 rounded-xl transition shadow-md shadow-red-600/10">
                                    <i class="fa-solid fa-check mr-1"></i> Mark as Read
                                </button>
                            </form>
                        @endif

                        <a href="mailto:{{ $msg->email }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-red-50/50 hover:border-red-200/60 px-4 py-2.5 rounded-xl transition shadow-sm">
                            <i class="fa-solid fa-envelope text-slate-400 group-hover:text-red-600 transition-colors"></i> Dispatch Reply
                        </a>
                    </div>

                </div>
            </div>

        @empty

            {{-- EMPTY PIPELINE SCREEN DISPLAY WITH GRADIENT LAYER --}}
            <div class="text-center bg-white border border-slate-100 rounded-3xl p-16 shadow-sm text-slate-400 space-y-4">
                <div class="gradient-border-wrapper rounded-3xl shadow-sm max-w-max mx-auto overflow-hidden">
                    <div class="w-14 h-14 bg-white rounded-[23px] flex items-center justify-center text-red-600 shadow-inner">
                        <i class="fa-solid fa-tray text-xl"></i>
                    </div>
                </div>
                <p class="font-semibold text-slate-400 text-sm">Pipeline clear. No inbound inquiries detected.</p>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>
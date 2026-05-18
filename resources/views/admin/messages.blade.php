<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Admin Messages</title>

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
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #f87171;
            border-radius: 99px;
        }
        
        /* Premium Gradient Border Layout with Rounded Clipping */
        .gradient-border-wrapper {
            position: relative;
            background: linear-gradient(to right, #ba1124, #d31c30, #f97316);
            padding: 1px; /* The border thickness */
        }
    </style>
</head>

<body class="antialiased h-screen overflow-hidden selection:bg-red-500/10 selection:text-red-600">

<div class="flex h-screen w-full bg-[#f8fafc]">

    {{-- SIDEBAR: USER LIST --}}
    <div class="w-[360px] bg-white border-r border-slate-100 flex flex-col flex-shrink-0 h-full">

        {{-- TOP HEADER ACCENT: HEAVY RED GRADIENT WITH TOUCH OF ORANGE --}}
        <div class="p-6 bg-gradient-to-r from-[#ba1124] via-[#d31c30] to-[#f97316] text-white shadow-sm">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold tracking-tight">Messages</h1>
                    <p class="text-white/70 text-xs font-semibold uppercase tracking-wider mt-0.5">Admin Central Inbox</p>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                   class="w-9 h-9 bg-white/10 backdrop-blur-md hover:bg-white/20 border border-white/10 text-white rounded-xl flex items-center justify-center transition shadow-sm">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
            </div>
        </div>

        {{-- USER DIRECTORY NODES --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-1">
            @foreach($users as $u)
            <a href="{{ route('admin.chat', $u->id) }}"
               class="flex items-center gap-4 p-4 rounded-2xl border border-transparent hover:border-slate-100 hover:bg-red-50/[0.12] transition-all duration-200 group relative">
                
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-red-50 to-red-100 text-red-600 flex items-center justify-center font-bold text-sm shadow-sm group-hover:scale-105 transition-transform duration-200 flex-shrink-0">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </div>

                <div class="flex-1 min-w-0">
                    <h2 class="font-bold text-slate-800 text-sm truncate group-hover:text-red-600 transition-colors">{{ $u->name }}</h2>
                    <p class="text-xs text-slate-400 truncate mt-0.5">{{ $u->email }}</p>
                </div>

                <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-red-500 group-hover:translate-x-0.5 transition-all text-xs"></i>
            </a>
            @endforeach
        </div>

    </div>

    {{-- CHAT INTERFACE WINDOW --}}
    <div class="flex-1 flex flex-col h-full bg-[#f8fafc]">

        @if(isset($user))

            {{-- ACTIVE CHAT TARGET HEADER --}}
            <div class="bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between shadow-sm relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-red-50 to-red-100 text-red-600 flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div>
                        <h2 class="font-bold text-slate-800 text-base tracking-tight leading-tight group-hover:text-red-600">
                            {{ $user->name }}
                        </h2>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">
                            {{ $user->email }}
                        </p>
                    </div>
                </div>

                <div class="bg-red-50 border border-red-100 px-3 py-1.5 rounded-xl text-[10px] font-bold text-red-600 uppercase tracking-wider flex items-center gap-1.5 shadow-sm">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> Active Feed
                </div>
            </div>

            {{-- LIVE CHAT HISTORICAL FEED --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar bg-slate-50/50">

                @forelse($messages as $msg)
                <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">

                    <div class="max-w-md flex flex-col {{ $msg->sender_id == auth()->id() ? 'items-end' : 'items-start' }} space-y-1">
                        
                        <div class="px-5 py-3 shadow-sm border border-slate-100/50
                            {{ $msg->sender_id == auth()->id()
                                ? 'bg-gradient-to-r from-red-700 via-red-600 to-orange-500 text-white rounded-3xl rounded-tr-sm shadow-red-500/5'
                                : 'bg-white text-slate-700 rounded-3xl rounded-tl-sm'
                            }}
                        ">
                            <p class="text-xs md:text-sm font-medium leading-relaxed break-words">
                                {{ $msg->message }}
                            </p>
                        </div>

                        <div class="text-[10px] font-semibold text-slate-400 px-2 tracking-wide">
                            {{ $msg->created_at->format('h:i A') }}
                        </div>

                    </div>

                </div>
                @empty
                <div class="h-full flex items-center justify-center">
                    <div class="text-center space-y-3">
                        <div class="w-14 h-14 bg-white border border-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-300 shadow-sm">
                            <i class="fa-solid fa-comments text-xl"></i>
                        </div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">No message logs historical data.</p>
                    </div>
                </div>
                @endforelse

            </div>

            {{-- MESSAGING TEXT CAPTURE TRIGGER --}}
            <div class="bg-white border-t border-slate-100 p-4 relative z-10">
                <form action="{{ route('messages.send') }}" method="POST" class="max-w-4xl mx-auto flex gap-3">
                    @csrf

                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">

                    <input type="text"
                           name="message"
                           autocomplete="off"
                           placeholder="Type your correspondence text response here..."
                           class="flex-1 border border-slate-200 bg-slate-50/50 rounded-2xl px-5 py-3 text-sm placeholder-slate-400 focus:outline-none focus:border-red-500/40 focus:ring-4 focus:ring-red-500/[0.03] transition-all duration-200">

                    <button type="submit"
                            class="bg-gradient-to-r from-red-700 via-red-600 to-orange-500 text-white font-bold px-5 rounded-2xl shadow-md shadow-red-500/10 hover:opacity-95 active:scale-95 transition flex items-center justify-center">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                    </button>
                </form>
            </div>

        @else

            {{-- EMPTY LOG INITIAL DISPLAY PANEL WITH ROUNDED GRADIENT LAYOUT --}}
            <div class="flex-1 flex items-center justify-center bg-slate-50/30">
                <div class="text-center max-w-sm space-y-4 px-6">
                    
                    <div class="gradient-border-wrapper rounded-3xl shadow-sm max-w-max mx-auto overflow-hidden">
                        <div class="w-16 h-16 bg-white rounded-[23px] flex items-center justify-center text-red-600 shadow-inner">
                            <i class="fa-solid fa-comments text-xl"></i>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Correspondence Center</h2>
                        <p class="text-slate-400 text-xs leading-relaxed">
                            Select a user account routing profile from the directory index listing grid to start active communications.
                        </p>
                    </div>
                </div>
            </div>

        @endif

    </div>

</div>

</body>
</html>
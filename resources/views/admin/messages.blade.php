<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages | CraveCart Studio Hub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
        }
        .chat-bubble-sent {
            background: #dc2626;
            color: white;
            border-bottom-right-radius: 4px;
        }
        .chat-bubble-received {
            background: white;
            color: #0f172a;
            border-bottom-left-radius: 4px;
        }
        .sidebar-user:hover {
            background: #faf8f5;
        }
        .sidebar-user.active {
            background: #fef2f2;
            border-left: 3px solid #dc2626;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
    </style>
</head>

<body class="h-screen overflow-hidden">

<div class="flex h-screen">

    {{-- SIDEBAR --}}
    <div class="w-[360px] bg-white border-r border-slate-100 flex flex-col">

        {{-- Header --}}
        <div class="p-6 border-b border-slate-100">
            <div class="flex justify-between items-center mb-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center border border-red-100">
                        <i class="fa-solid fa-envelope text-red-600"></i>
                    </div>
                    <div>
                        <h1 class="font-black text-slate-900 tracking-tight text-lg leading-none">Messages</h1>
                        <p class="text-[10px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-0.5">Studio Hub</p>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 bg-slate-50 hover:bg-slate-900 rounded-xl flex items-center justify-center transition-all duration-300 group">
                    <i class="fa-solid fa-arrow-left text-slate-400 group-hover:text-white transition-colors"></i>
                </a>
            </div>
        </div>

        {{-- User List --}}
        <div class="flex-1 overflow-y-auto">
            @foreach($users as $u)
            <a href="{{ route('admin.chat', $u->id) }}" 
               class="sidebar-user flex items-center gap-4 p-5 border-b border-slate-50 transition-all duration-300 {{ isset($user) && $user->id == $u->id ? 'active' : '' }}">
                
                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 font-black text-lg shadow-inner">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </div>

                <div class="flex-1 min-w-0">
                    <h2 class="font-bold text-slate-800 text-sm truncate">{{ $u->name }}</h2>
                    <p class="text-xs text-slate-400 font-medium truncate">{{ $u->email }}</p>
                </div>

                <i class="fa-solid fa-chevron-right text-slate-300 text-xs"></i>
            </a>
            @endforeach
        </div>

    </div>

    {{-- CHAT AREA --}}
    <div class="flex-1 flex flex-col bg-[#faf8f5]">

        @if(isset($user))

            {{-- Chat Header --}}
            <div class="bg-white border-b border-slate-100 px-8 py-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 font-black text-lg shadow-inner border border-red-100">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-bold text-slate-900 text-lg tracking-tight">{{ $user->name }}</h2>
                    <p class="text-xs text-slate-400 font-medium">{{ $user->email }}</p>
                </div>
                <div class="ml-auto">
                    <span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Online
                    </span>
                </div>
            </div>

            {{-- Chat Messages --}}
            <div class="flex-1 overflow-y-auto p-8 space-y-5" id="chatContainer">

                @forelse($messages as $msg)

                    <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">

                        <div class="max-w-md px-6 py-4 rounded-2xl shadow-sm {{ $msg->sender_id == auth()->id() ? 'chat-bubble-sent' : 'chat-bubble-received border border-slate-100' }}">

                            <p class="text-sm leading-relaxed font-medium">
                                {{ $msg->message }}
                            </p>

                            <div class="text-[10px] mt-2 opacity-70 text-right font-semibold tracking-wide">
                                {{ $msg->created_at->format('h:i A') }}
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                                <i class="fa-solid fa-comments text-3xl text-slate-300"></i>
                            </div>
                            <p class="text-slate-400 font-bold text-sm tracking-wider uppercase">No messages yet</p>
                            <p class="text-slate-300 text-xs mt-1">Start the conversation below</p>
                        </div>
                    </div>

                @endforelse

            </div>

            {{-- Input Area --}}
            <form action="{{ route('messages.send') }}" method="POST" class="bg-white border-t border-slate-100 p-6 flex gap-3">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">

                <div class="flex-1 relative">
                    <input type="text"
                           name="message"
                           placeholder="Type your message..."
                           class="w-full bg-slate-50 border-0 rounded-2xl px-6 py-4 text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm font-medium"
                           autocomplete="off">
                </div>

                <button type="submit" class="bg-slate-900 hover:bg-red-600 text-white w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                </button>
            </form>

        @else

            {{-- Empty State --}}
            <div class="flex-1 flex items-center justify-center bg-[#faf8f5]">
                <div class="text-center">
                    <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
                        <i class="fa-solid fa-comments text-4xl text-slate-200"></i>
                    </div>
                    <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
                        <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Message Center</span>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase mb-2">
                        Select a <span class="text-red-600">Conversation.</span>
                    </h2>
                    <p class="text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
                        CraveCart Studio Hub
                    </p>
                </div>
            </div>

        @endif

    </div>

</div>

</body>
</html>
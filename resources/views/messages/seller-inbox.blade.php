<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Messages | CraveCart Seller Studio</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #ffffff;
        }
        .chat-row {
            transition: all 0.3s ease;
        }
        .chat-row:hover {
            background: #faf8f5;
        }
        .chat-row.unread {
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

    {{-- Sidebar --}}
    <div class="w-80 bg-white border-r border-slate-100 flex flex-col">

        {{-- Header --}}
        <div class="p-6 border-b border-slate-100">
            <div class="flex justify-between items-center mb-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center border border-red-100">
                        <i class="fa-solid fa-comments text-red-600"></i>
                    </div>
                    <div>
                        <h1 class="font-black text-slate-900 tracking-tight text-lg leading-none">Messages</h1>
                        <p class="text-[10px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-0.5">Seller Studio</p>
                    </div>
                </div>
                <a href="{{ route('seller.dash') }}" class="w-10 h-10 bg-slate-50 hover:bg-slate-900 rounded-xl flex items-center justify-center transition-all duration-300 group">
                    <i class="fa-solid fa-arrow-left text-slate-400 group-hover:text-white transition-colors"></i>
                </a>
            </div>
        </div>

        {{-- Chat List --}}
        <div class="flex-1 overflow-y-auto">

            @forelse($users as $chat)

            <a href="{{ route('messages.chat', $chat['user']->id) }}"
               class="chat-row {{ $chat['unread_count'] > 0 ? 'unread' : '' }} flex items-center gap-4 p-5 border-b border-slate-50 transition-all">

                {{-- Avatar --}}
                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 font-black text-lg shadow-inner flex-shrink-0">
                    {{ strtoupper(substr($chat['user']->name, 0, 1)) }}
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">

                    <div class="flex justify-between items-center mb-1">

                        <h3 class="font-bold text-slate-800 text-sm truncate">
                            {{ $chat['user']->name }}
                        </h3>

                        <div class="flex items-center gap-2">
                            @if($chat['unread_count'] > 0)
                                <span class="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full">
                                    {{ $chat['unread_count'] }}
                                </span>
                            @endif
                            <small class="text-slate-400 text-[10px] font-medium">
                                {{ optional($chat['last_message']->created_at)->format('h:i A') }}
                            </small>
                        </div>

                    </div>

                    <p class="text-xs text-slate-500 truncate font-medium {{ $chat['unread_count'] > 0 ? 'text-slate-700 font-semibold' : '' }}">
                        {{ $chat['last_message']->message ?? 'No messages yet' }}
                    </p>

                </div>

                <i class="fa-solid fa-chevron-right text-slate-300 text-xs flex-shrink-0"></i>

            </a>

            @empty

            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <i class="fa-solid fa-comments text-3xl text-slate-300"></i>
                </div>
                <div class="inline-block bg-slate-100 border border-slate-200 rounded-full px-4 py-1.5 mb-3">
                    <span class="text-slate-500 text-[10px] font-black tracking-[0.4em] uppercase">Empty</span>
                </div>
                <p class="text-slate-400 font-bold text-sm tracking-wider uppercase">No messages yet</p>
            </div>

            @endforelse

        </div>

    </div>

    {{-- Empty Chat Area --}}
    <div class="flex-1 bg-[#faf8f5] flex items-center justify-center">

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
                CraveCart Seller Studio
            </p>
        </div>

    </div>

</div>

</body>
</html>
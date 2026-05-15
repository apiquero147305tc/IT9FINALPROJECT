<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>

<body class="bg-gray-100 h-screen overflow-hidden">

<div class="bg-white h-full overflow-y-auto flex flex-col">
{{-- HEADER --}}
<div class="p-5 border-b bg-red-600 text-white flex justify-between items-center">

    <div>
        <h2 class="text-xl font-bold">Messages</h2>
        <p class="text-red-100 text-sm">Your conversations</p>
    </div>

  {{-- BACK BUTTON (ROLE BASED) --}}
@if(auth()->user()->role === 'seller')
    <a href="{{ route('seller.dash') }}"
       class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl transition flex items-center gap-2">

        <i class="fa-solid fa-arrow-left"></i>
        Back to Dashboard
    </a>

@elseif(auth()->user()->role === 'buyer')
    <a href="{{ route('buyer.home') }}"
       class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl transition flex items-center gap-2">

        <i class="fa-solid fa-arrow-left"></i>
        Back to Home
    </a>

@elseif(auth()->user()->role === 'admin')
    <a href="{{ route('admin.dashboard') }}"
       class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl transition flex items-center gap-2">

        <i class="fa-solid fa-arrow-left"></i>
        Back to Dashboard
    </a>
@endif
</div>

    {{-- CHAT LIST --}}
    <div class="divide-y flex-1 overflow-y-auto">

        @forelse($users as $chat)

            <a href="{{ route('messages.chat', $chat['user']->id) }}"
               class="flex items-center gap-4 p-4 hover:bg-red-50 transition">

                {{-- Avatar --}}
                <div class="w-12 h-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold">
                    {{ strtoupper(substr($chat['user']->name, 0, 1)) }}
                </div>

                {{-- Info --}}
                <div class="flex-1">

                    <div class="flex justify-between items-center">

                        <h3 class="font-semibold text-gray-800">
                            {{ $chat['user']->name }}
                        </h3>

                        <small class="text-gray-400 text-xs">
                            {{ optional($chat['last_message']->created_at)->format('h:i A') }}
                        </small>

                    </div>

                    <p class="text-sm text-gray-500 truncate">
                        {{ $chat['last_message']->message }}
                    </p>

                </div>

                <i class="fa-solid fa-chevron-right text-gray-300"></i>

            </a>

        @empty

            <div class="p-10 text-center text-gray-500">
                <i class="fa-solid fa-comments text-5xl mb-3 text-gray-300"></i>
                <p>No conversations yet.</p>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>
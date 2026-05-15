<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>

<body class="bg-gray-100 h-screen overflow-hidden">

<div class="flex h-screen">

    {{-- SIDEBAR --}}
    <div class="w-[350px] bg-white border-r flex flex-col">

        {{-- TOP --}}
        <div class="p-5 border-b bg-red-600 text-white">

            <div class="flex justify-between items-center">

                <div>
                    <h1 class="text-2xl font-bold">
                        Messages
                    </h1>

                    <p class="text-red-100 text-sm">
                        Admin Inbox
                    </p>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                   class="bg-white/20 hover:bg-white/30 px-3 py-2 rounded-xl transition">

                    <i class="fa-solid fa-arrow-left"></i>

                </a>

            </div>

        </div>

        {{-- USERS --}}
        <div class="flex-1 overflow-y-auto">

            @foreach($users as $u)

    <a href="{{ route('admin.chat', $u->id) }}"
       class="flex items-center gap-4 p-4 border-b hover:bg-red-50 transition">

        <div class="w-12 h-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold">
            {{ strtoupper(substr($u->name, 0, 1)) }}
        </div>

        <div class="flex-1">
            <h2 class="font-semibold text-gray-800">{{ $u->name }}</h2>
            <p class="text-sm text-gray-500">{{ $u->email }}</p>
        </div>

        <i class="fa-solid fa-chevron-right text-gray-400"></i>

    </a>

@endforeach

        </div>

    </div>

    {{-- CHAT AREA --}}
    <div class="flex-1 flex flex-col">

        @if(isset($user))

            {{-- CHAT HEADER --}}
            <div class="bg-white border-b px-6 py-4 flex items-center gap-4 shadow-sm">

                <div class="w-12 h-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold">

                    {{ strtoupper(substr($user->name, 0, 1)) }}

                </div>

                <div>
                    <h2 class="font-bold text-lg">
                        {{ $user->name }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        {{ $user->email }}
                    </p>
                </div>

            </div>

            {{-- CHAT BODY --}}
            <div class="flex-1 overflow-y-auto p-6 bg-gray-100 space-y-4">

                @forelse($messages as $msg)

                    <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">

                        <div class="
                            max-w-md px-5 py-3 rounded-3xl shadow
                            {{ $msg->sender_id == auth()->id()
                                ? 'bg-red-600 text-white rounded-br-md'
                                : 'bg-white text-gray-800 rounded-bl-md'
                            }}
                        ">

                            <p class="text-sm leading-relaxed">
                                {{ $msg->message }}
                            </p>

                            <div class="text-[11px] mt-2 opacity-70 text-right">
                                {{ $msg->created_at->format('h:i A') }}
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="h-full flex items-center justify-center">

                        <div class="text-center">

                            <i class="fa-solid fa-comments text-6xl text-gray-300 mb-4"></i>

                            <p class="text-gray-500 text-lg">
                                No messages yet.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

            {{-- INPUT --}}
            <form action="{{ route('messages.send') }}"
                  method="POST"
                  class="bg-white border-t p-4 flex gap-3">

                @csrf

                <input type="hidden"
                       name="receiver_id"
                       value="{{ $user->id }}">

                <input type="text"
                       name="message"
                       placeholder="Type your message..."
                       class="flex-1 border border-gray-300 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-red-300">

                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 rounded-2xl transition">

                    <i class="fa-solid fa-paper-plane"></i>

                </button>

            </form>

        @else

            {{-- EMPTY STATE --}}
            <div class="flex-1 flex items-center justify-center bg-gray-100">

                <div class="text-center">

                    <i class="fa-solid fa-comments text-7xl text-gray-300 mb-5"></i>

                    <h2 class="text-2xl font-bold text-gray-700 mb-2">
                        Welcome to Admin Messages
                    </h2>

                    <p class="text-gray-500">
                        Select a user from the left sidebar to start chatting.
                    </p>

                </div>

            </div>

        @endif

    </div>

</div>

</body>
</html>
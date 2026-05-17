<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gray-100">

<div class="h-screen flex flex-col">

    {{-- HEADER --}}
    <div class="bg-white border-b px-6 py-4 flex items-center justify-between shadow-sm">

        <div>
            <h2 class="text-lg font-bold text-gray-800">
                Chat with {{ $user->name }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ $user->email }}
            </p>
        </div>

        <a href="{{ route('admin.messages') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-xl transition">

            ← Back
        </a>

    </div>

    {{-- CHAT BODY --}}
    <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">

        @forelse($messages as $msg)

            <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">

                <div class="max-w-xs md:max-w-md lg:max-w-lg">

                    <div class="px-4 py-3 rounded-2xl shadow-sm text-sm
                        {{ $msg->sender_id == auth()->id()
                            ? 'bg-red-600 text-white rounded-br-none'
                            : 'bg-white text-gray-800 rounded-bl-none border'
                        }}">

                        {{ $msg->message }}

                    </div>

                    <div class="text-xs text-gray-400 mt-1
                        {{ $msg->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">

                        {{ $msg->created_at->format('h:i A') }}

                    </div>

                </div>

            </div>

        @empty

            <div class="flex items-center justify-center h-full text-gray-400">
                No messages yet. Start the conversation.
            </div>

        @endforelse

    </div>

    {{-- INPUT --}}
    <form action="{{ route('messages.send') }}" method="POST"
          class="bg-white border-t p-4 flex items-center gap-3">

        @csrf

        <input type="hidden" name="receiver_id" value="{{ $user->id }}">

        <input type="text"
               name="message"
               placeholder="Type your message..."
               class="flex-1 border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-300">

        <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl transition">

            Send

        </button>

    </form>

</div>

</body>
</html>
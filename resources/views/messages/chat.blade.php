<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>

<body class="bg-gray-100 h-screen flex flex-col">

{{-- HEADER --}}
<div class="bg-red-600 text-white px-6 py-4 flex justify-between items-center shadow">

    <div>
        <h1 class="text-lg font-bold">
            Chat with {{ $receiver->name }}
        </h1>
        <p class="text-sm text-red-100">
            {{ auth()->user()->role }} messaging
        </p>
    </div>

    {{-- BACK BUTTON --}}
    <a href="{{ url()->previous() }}"
       class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl text-sm transition">
        <i class="fa-solid fa-arrow-left mr-1"></i> Back
    </a>

</div>

{{-- CHAT AREA --}}
<div id="chatBox" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-100">

    @forelse($messages as $msg)

        @php
            $isMe = $msg->sender_id == auth()->id();
        @endphp

        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">

            <div class="
                max-w-[70%] px-4 py-3 rounded-2xl shadow
                {{ $isMe
                    ? 'bg-red-600 text-white rounded-br-sm'
                    : 'bg-white text-gray-800 rounded-bl-sm'
                }}
            ">

                <p class="text-sm">
                    {{ $msg->message }}
                </p>

                <div class="text-[10px] mt-2 opacity-70 text-right">
                    {{ $msg->created_at->format('h:i A') }}
                </div>

            </div>

        </div>

    @empty

        <div class="text-center text-gray-400 mt-10">
            No messages yet. Start the conversation.
        </div>

    @endforelse

</div>

{{-- INPUT --}}
<form method="POST"
      action="{{ route('messages.send') }}"
      class="bg-white border-t p-4 flex gap-3">

    @csrf

    <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

    <input type="text"
           name="message"
           placeholder="Type your message..."
           class="flex-1 border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-300">

    <button class="bg-red-600 hover:bg-red-700 text-white px-6 rounded-xl transition">
        <i class="fa-solid fa-paper-plane"></i>
    </button>

</form>

{{-- AUTO SCROLL --}}
<script>
    const box = document.getElementById('chatBox');
    if (box) box.scrollTop = box.scrollHeight;
</script>

</body>
</html>
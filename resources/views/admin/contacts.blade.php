<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Messages</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>

<body class="bg-gray-100">

<div class="max-w-5xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="bg-red-600 text-white p-5 rounded-xl flex justify-between items-center shadow">

        <div>
            <h2 class="text-xl font-bold">📩 Contact Messages</h2>
            <p class="text-red-100 text-sm">User inquiries & complaints</p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl transition">
            ← Back
        </a>

    </div>

    {{-- MESSAGE LIST --}}
    <div class="mt-6 space-y-4">

       @forelse($contacts as $msg)

            <div class="bg-white p-5 rounded-xl shadow border-l-4 
                        {{ $msg->is_read ? 'border-gray-300' : 'border-red-500' }}">

                {{-- TOP INFO --}}
                <div class="flex justify-between items-center mb-2">

                    <div>
                        <h3 class="font-bold text-gray-800">
                            {{ $msg->name }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            {{ $msg->email }}
                        </p>
                    </div>

                       {{-- TYPE BADGE (REPORT vs CONTACT) --}}
                            @if($msg->type === 'report')
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">
                                    REPORT
                                </span>
                            @else
                                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">
                                    CONTACT
                                </span>
                            @endif

                    {{-- STATUS --}}
                    @if(!$msg->is_read)
                        <span class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-full">
                            New
                        </span>
                    @else
                        <span class="text-xs bg-gray-100 text-gray-500 px-3 py-1 rounded-full">
                            Read
                        </span>
                    @endif

                </div>

                {{-- MESSAGE --}}
                <p class="text-gray-700 mb-4">
                    {{ $msg->message }}
                </p>

                {{-- ACTIONS --}}
                <div class="flex gap-3">

                    {{-- MARK AS READ --}}
                    @if(!$msg->is_read)
                       <form method="POST" action="{{ route('admin.contacts.read', $msg->id) }}">
                            @csrf
                            <button class="text-sm text-green-600 hover:underline">
                                Mark as read
                            </button>
                        </form>
                    @endif

                    {{-- REPLY (optional future feature) --}}
                    <a href="mailto:{{ $msg->email }}"
                       class="text-sm text-blue-600 hover:underline">
                        Reply
                    </a>

                </div>

            </div>

        @empty

            <div class="text-center text-gray-500 p-10">
                <i class="fa-solid fa-inbox text-5xl mb-3"></i>
                <p>No contact messages yet.</p>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>
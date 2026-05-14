<!DOCTYPE html>
<html>
<head>
    <title>Admin Messages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex">

{{-- LEFT USERS LIST --}}
<div class="w-1/4 bg-white border-r overflow-y-auto">

    <div class="p-4 font-bold text-xl border-b">
        Messages
    </div>

    @foreach(\App\Models\User::where('role','!=','admin')->get() as $u)

        <a href="{{ route('admin.chat', $u->id) }}"
           class="block p-4 hover:bg-gray-100 border-b">

            <div class="font-semibold">{{ $u->name }}</div>
            <div class="text-sm text-gray-500">{{ $u->email }}</div>

        </a>

    @endforeach

</div>

{{-- RIGHT SIDE --}}
<div class="flex-1 flex flex-col">

    {{-- HEADER --}}
    <div class="bg-white p-4 border-b flex justify-between items-center">

        <div>
            <h2 class="font-bold text-xl">Admin Messages Inbox</h2>
            <p class="text-sm text-gray-500">
                Select a user to start chatting
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-xl">

            Back
        </a>

    </div>

    {{-- EMPTY STATE --}}
    <div class="flex-1 flex items-center justify-center">
        <p class="text-gray-500">
            Select a user to view conversation
        </p>
    </div>

</div>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Compose Email</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

</head>

<body class="bg-gradient-to-br from-red-50 to-gray-100 min-h-screen flex items-center justify-center font-sans">

<div class="w-full max-w-3xl bg-white shadow-2xl rounded-2xl overflow-hidden">

    {{-- HEADER --}}
    <div class="bg-red-600 text-white px-6 py-4 flex items-center justify-between">

        <h2 class="text-lg font-semibold flex items-center gap-2">
            <i class="fa-solid fa-paper-plane"></i>
            Compose Email
        </h2>

        <a href="{{ route('admin.dashboard') }}"
           class="text-sm bg-white text-red-600 px-3 py-1 rounded-lg hover:bg-gray-100 transition">
            Back
        </a>

    </div>

    {{-- USER INFO --}}
    <div class="px-6 py-4 border-b bg-gray-50">

        <p class="text-sm text-gray-500">To:</p>
        <p class="font-semibold text-gray-800">
            {{ $user->name }}
            <span class="text-gray-500 font-normal">({{ $user->email }})</span>
        </p>

    </div>

    {{-- FORM --}}
    <form action="{{ route('admin.email.send', $user->id) }}" method="POST" class="p-6 space-y-4">

        @csrf

        {{-- SUBJECT --}}
        <div>
            <label class="text-sm font-semibold text-gray-600">Subject</label>
            <input type="text"
                   name="subject"
                   placeholder="Enter email subject..."
                   class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-300 focus:outline-none">
        </div>

        {{-- MESSAGE --}}
        <div>
            <label class="text-sm font-semibold text-gray-600">Message</label>
            <textarea name="message"
                      rows="10"
                      placeholder="Write your message here..."
                      class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-300 focus:outline-none"></textarea>
        </div>

        {{-- ACTIONS --}}
        <div class="flex justify-end gap-3 pt-2">

            <a href="{{ route('admin.dashboard') }}"
               class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 transition">
                Cancel
            </a>

            <button type="submit"
                    class="px-6 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white shadow-md transition flex items-center gap-2">

                <i class="fa-solid fa-paper-plane"></i>
                Send Email

            </button>

        </div>

    </form>

</div>

</body>
</html>
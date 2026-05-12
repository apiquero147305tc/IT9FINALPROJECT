<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Admin Settings</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

    <style>
        body{
            font-family:'Poppins',sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="flex">

    {{-- SIDEBAR --}}
    <aside class="w-72 bg-red-700 text-white min-h-screen p-7 shadow-2xl">

        <div class="flex items-center gap-4 mb-12">

            <div class="w-14 h-14 rounded-2xl bg-white text-red-700 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-gear"></i>
            </div>

            <div>
                <h1 class="text-2xl font-bold">
                    CraveCart
                </h1>

                <p class="text-red-100 text-sm">
                    Admin Settings
                </p>
            </div>

        </div>

        <nav class="space-y-3">

            <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 p-4 rounded-2xl hover:bg-red-800 transition">

                <i class="fa-solid fa-chart-line"></i>
                Dashboard

            </a>

            <a href="{{ route('admin.settings') }}"
            class="flex items-center gap-3 p-4 rounded-2xl bg-red-800">

                <i class="fa-solid fa-gear"></i>
                Settings

            </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

            <button type="submit"
                    class="w-full flex items-center gap-3 p-4 rounded-2xl hover:bg-red-800 transition text-left">

            <i class="fa-solid fa-right-from-bracket"></i>
                Logout

    </button>
</form>

        </nav>

    </aside>

    {{-- MAIN --}}
    <main class="flex-1 p-10">

        {{-- HEADER --}}
        <div class="mb-10">

            <h1 class="text-5xl font-bold text-gray-800">
                Admin Settings
            </h1>

            <p class="text-gray-500 mt-3 text-lg">
                Manage your administrator account
            </p>

        </div>

        {{-- SUCCESS --}}
        @if(session('success'))

        <div class="bg-green-100 text-green-700 p-5 rounded-2xl mb-6 font-semibold">

            {{ session('success') }}

        </div>

        @endif

        {{-- SETTINGS CARD --}}
        <div class="bg-white rounded-3xl shadow-2xl p-10 max-w-3xl">

            <form action="{{ route('admin.settings.update') }}"
            method="POST">

                @csrf

                {{-- PROFILE ICON --}}
                <div class="flex justify-center mb-10">

                    <div class="w-32 h-32 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-5xl shadow-lg">

                        <i class="fa-solid fa-user-shield"></i>

                    </div>

                </div>

                {{-- NAME --}}
                <div class="mb-6">

                    <label class="block text-gray-700 font-semibold mb-3">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ $admin->name }}"
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 outline-none focus:border-red-500"
                    >

                </div>

                {{-- EMAIL --}}
                <div class="mb-6">

                    <label class="block text-gray-700 font-semibold mb-3">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ $admin->email }}"
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 outline-none focus:border-red-500"
                    >

                </div>

                {{-- PASSWORD --}}
                <div class="mb-6">

                    <label class="block text-gray-700 font-semibold mb-3">
                        New Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Leave blank to keep current password"
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 outline-none focus:border-red-500"
                    >

                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="mb-8">

                    <label class="block text-gray-700 font-semibold mb-3">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 outline-none focus:border-red-500"
                    >

                </div>

                {{-- BUTTON --}}
                <button
                class="w-full bg-red-600 hover:bg-red-700 transition text-white py-5 rounded-2xl text-lg font-semibold shadow-lg">

                    <i class="fa-solid fa-floppy-disk mr-2"></i>

                    Save Changes

                </button>

            </form>

        </div>

    </main>

</div>

</body>
</html>
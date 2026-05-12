<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Blocked Users</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

    <style>
        body{
            font-family:'Poppins',sans-serif;
        }
    </style>
</head>

<body class="bg-gray-900 text-white min-h-screen">

<div class="p-10">

    <div class="flex justify-between items-center mb-12">

        <div>

            <h1 class="text-5xl font-bold text-red-500">
                Blocked Users
            </h1>

            <p class="text-gray-400 mt-3">
                Restricted CraveCart accounts
            </p>

        </div>

        <a href="{{ route('admin.dashboard') }}"
        class="bg-red-600 hover:bg-red-700 px-6 py-4 rounded-2xl font-semibold">

            Dashboard

        </a>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        @foreach($users as $user)

        <div class="bg-gray-800 border border-red-500 rounded-3xl p-7">

            <div class="flex justify-between items-start">

                <div>

                    <h2 class="text-2xl font-bold">
                        {{ $user->name }}
                    </h2>

                    <p class="text-gray-400 mt-2">
                        {{ $user->email }}
                    </p>

                </div>

                <div class="w-16 h-16 bg-red-500/20 text-red-400 rounded-2xl flex items-center justify-center text-2xl">

                    <i class="fa-solid fa-user-lock"></i>

                </div>

            </div>

            <div class="mt-8">

                <form action="{{ route('admin.unblock', $user->id) }}"
                method="POST">

                    @csrf

                    <button
                    class="w-full bg-red-600 hover:bg-red-700 py-4 rounded-2xl font-semibold">

                        Unblock User

                    </button>

                </form>

            </div>

        </div>

        @endforeach

    </div>

</div>

</body>
</html>
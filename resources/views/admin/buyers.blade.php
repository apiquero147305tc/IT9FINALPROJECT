<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Buyers</title>

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

<body class="bg-blue-50 min-h-screen">

<div class="p-10">

    <div class="flex justify-between items-center mb-10">

        <div>
            <h1 class="text-5xl font-bold text-blue-700">
                Registered Buyers
            </h1>

            <p class="text-blue-600 mt-3">
                Customers shopping in CraveCart
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-2xl font-semibold">

            Dashboard

        </a>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

        @foreach($users as $buyer)

        <div class="bg-white rounded-3xl shadow-lg p-7 text-center">

            <div class="w-24 h-24 mx-auto bg-blue-100 text-blue-700 rounded-full flex items-center justify-center text-4xl">

                <i class="fa-solid fa-user"></i>

            </div>

            <h2 class="text-2xl font-bold mt-6">
                {{ $buyer->name }}
            </h2>

            <p class="text-gray-500 mt-2">
                {{ $buyer->email }}
            </p>

            <div class="mt-6">

                @if($buyer->is_blocked)

                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm">

                    Blocked

                </span>

                @else

                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm">

                    Active

                </span>

                @endif

            </div>

        </div>

        @endforeach

    </div>

</div>

</body>
</html>
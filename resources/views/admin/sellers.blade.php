<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Sellers</title>

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

<body class="bg-yellow-50 min-h-screen">

<div class="p-10">

    <div class="flex justify-between items-center mb-10">

        <div>
            <h1 class="text-5xl font-bold text-yellow-700">
                Registered Sellers
            </h1>

            <p class="text-yellow-600 mt-3">
                Marketplace vendors of CraveCart
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-4 rounded-2xl font-semibold">

            Dashboard

        </a>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        @foreach($users as $seller)

        <div class="bg-white rounded-3xl shadow-xl p-7">

            <div class="flex justify-between items-start">

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $seller->name }}
                    </h2>

                    <p class="text-gray-500 mt-2">
                        {{ $seller->email }}
                    </p>

                </div>

                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-2xl">

                    <i class="fa-solid fa-store"></i>

                </div>

            </div>

            <div class="mt-8">

                @if($seller->is_blocked)

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
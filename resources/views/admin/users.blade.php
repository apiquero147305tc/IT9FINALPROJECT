<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | All Users</title>

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

<body class="bg-red-100 min-h-screen">

<div class="p-10">

    <div class="flex justify-between items-center mb-10">

        <div>
            <h1 class="text-5xl font-bold text-red-800">
                 Registered Users
            </h1>

            <p class="text-gray-500 mt-3">
                View every CraveCart account
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
        class="bg-red-600 hover:bg-red-700 text-white px-6 py-4 rounded-2xl font-semibold">

            <i class="fa-solid fa-arrow-left mr-2"></i>
            Dashboard

        </a>

    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <table class="w-full">

            <thead class="bg-red-700 text-white">

                <tr>
                    <th class="p-5 text-left">Name</th>
                    <th class="p-5 text-left">Email</th>
                    <th class="p-5 text-left">Role</th>
                    <th class="p-5 text-left">Status</th>
                </tr>

            </thead>

            <tbody>

                @foreach($users as $user)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-5 font-semibold">
                        {{ $user->name }}
                    </td>

                    <td class="p-5 text-gray-500">
                        {{ $user->email }}
                    </td>

                    <td class="p-5">

                        @if($user->role == 'seller')

                        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm">
                            Seller
                        </span>

                        @else

                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm">
                            Buyer
                        </span>

                        @endif

                    </td>

                    <td class="p-5">

                        @if($user->is_blocked)

                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm">
                            Blocked
                        </span>

                        @else

                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm">
                            Active
                        </span>

                        @endif

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
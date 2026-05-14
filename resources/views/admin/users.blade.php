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

    {{-- HEADER --}}
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
        class="bg-red-600 hover:bg-red-700 text-white px-6 py-4 rounded-2xl font-semibold transition">

            <i class="fa-solid fa-arrow-left mr-2"></i>
            Dashboard

        </a>

    </div>

    {{-- SEARCH BAR --}}
    <div class="mb-6">

        <div class="relative">

            <input
                type="text"
                id="searchInput"
                placeholder="Search by name or email..."
                class="w-full p-4 pl-12 rounded-2xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-300"
            >

            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <table class="w-full">

            <thead class="bg-red-700 text-white">

                <tr>
                    <th class="p-5 text-left">Name</th>
                    <th class="p-5 text-left">Email</th>
                    <th class="p-5 text-left">Role</th>
                    <th class="p-5 text-left">Status</th>
                    <th class="p-5 text-left">Actions</th>
                </tr>

            </thead>

            <tbody id="usersTable">

                @foreach($users as $user)

                <tr class="border-b hover:bg-gray-50 user-row">

                    {{-- NAME --}}
                    <td class="p-5 font-semibold user-name">
                        {{ $user->name }}
                    </td>

                    {{-- EMAIL --}}
                    <td class="p-5 text-gray-500 user-email">
                        {{ $user->email }}
                    </td>

                    {{-- ROLE --}}
                    <td class="p-5">

                        @if($user->role == 'seller')

                        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm">
                            Seller
                        </span>

                        @elseif($user->role == 'buyer')

                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm">
                            Buyer
                        </span>

                        @else

                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm">
                            Admin
                        </span>

                        @endif

                    </td>

                    {{-- STATUS --}}
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

                    {{-- ACTIONS --}}
                    <td class="p-5">

                        @if(!$user->is_blocked)

                        {{-- BLOCK --}}
                        <form action="{{ route('admin.block', $user->id) }}"
                              method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-xl transition">

                                <i class="fa-solid fa-ban mr-2"></i>
                                Block

                            </button>

                        </form>

                        @else

                        {{-- UNBLOCK --}}
                        <form action="{{ route('admin.unblock', $user->id) }}"
                              method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition">

                                <i class="fa-solid fa-unlock mr-2"></i>
                                Unblock

                            </button>

                        </form>

                        
                        @endif
                        
                        <a href="{{ route('admin.email.page', $user->id) }}"
                           class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl transition">

                               <i class="fa-solid fa-envelope mr-2"></i>
                               Email

                       </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

{{-- SEARCH SCRIPT --}}
<script>

const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('keyup', function () {

    let filter = searchInput.value.toLowerCase();

    let rows = document.querySelectorAll('.user-row');

    rows.forEach(row => {

        let name = row.querySelector('.user-name')
            .textContent.toLowerCase();

        let email = row.querySelector('.user-email')
            .textContent.toLowerCase();

        if (name.includes(filter) || email.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

});

</script>

</body>
</html>
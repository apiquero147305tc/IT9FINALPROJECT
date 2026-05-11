<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete Users | Admin Panel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blood: '#7f1d1d',
                        dark: '#0f0f0f',
                        dark2: '#1a1a1a'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-dark text-white min-h-screen">

<!-- HEADER -->
<div class="max-w-6xl mx-auto py-10">

    <div class="flex justify-between items-center mb-8">

        <div>
            <h1 class="text-3xl font-bold">User Management</h1>
            <p class="text-gray-400 text-sm">Delete or manage user accounts</p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="bg-dark2 hover:bg-black px-4 py-2 rounded-lg text-sm border border-gray-700">
            Dashboard
        </a>

    </div>

    <!-- TABLE CARD -->
    <div class="bg-dark2 rounded-2xl shadow-lg border border-gray-800 overflow-hidden">

        <!-- TABLE HEADER -->
        <div class="p-4 border-b border-gray-800 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-red-400">
                All Users (Except Admin)
            </h2>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-black text-gray-300 text-sm uppercase">
                    <tr>
                        <th class="p-4">Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($users as $user)

                    <tr class="border-b border-gray-800 hover:bg-black transition">

                        <td class="p-4 font-medium">{{ $user->name }}</td>
                        <td class="text-gray-300">{{ $user->email }}</td>

                        <td>
                            <span class="px-2 py-1 text-xs rounded bg-gray-800">
                                {{ $user->role }}
                            </span>
                        </td>

                        <td>
                            @if($user->status == 'pending')
                                <span class="text-yellow-400 text-sm">Pending</span>
                            @elseif($user->status == 'approved')
                                <span class="text-green-400 text-sm">Active</span>
                            @else
                                <span class="text-red-400 text-sm">{{ $user->status }}</span>
                            @endif
                        </td>

                        <td class="text-center">

                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this user permanently?');">

                                @csrf
                                @method('DELETE')

                                <button class="bg-red-900 hover:bg-red-700 px-3 py-2 rounded-lg text-sm transition">
                                    <i class="fa-solid fa-trash"></i>
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
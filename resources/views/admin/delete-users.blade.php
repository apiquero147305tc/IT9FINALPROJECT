<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete Users | CraveCart Studio Hub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
        }
        .table-row {
            transition: all 0.3s ease;
        }
        .table-row:hover {
            background: #faf8f5;
        }
        .delete-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .delete-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px -10px rgba(220, 38, 38, 0.4);
        }
    </style>
</head>

<body class="min-h-screen">

<div class="max-w-6xl mx-auto p-6">

    {{-- Header --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 flex justify-between items-center shadow-sm mb-8">

        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center border border-red-100 shadow-inner">
                <i class="fa-solid fa-trash-can text-red-600 text-xl"></i>
            </div>
            <div>
                <h1 class="font-black text-slate-900 tracking-tight text-xl leading-none">Delete Users</h1>
                <p class="text-[10px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-1">Studio Hub</p>
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-red-600 text-white font-black px-6 py-3 rounded-2xl text-[11px] tracking-[0.15em] uppercase transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Dashboard
        </a>

    </div>

    {{-- Title Section --}}
    <div class="text-center mb-10">
        <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
            <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Account Control</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
            User <span class="text-red-600">Management.</span>
        </h2>
        <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
            CraveCart Essentials Hub
        </p>
    </div>

    {{-- Stats Bar --}}
    <div class="flex gap-4 mb-8">
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-slate-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-users text-slate-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Total Users</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ $users->count() }}</p>
            </div>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Danger Zone</p>
                <p class="text-lg font-black text-red-600 leading-none">Permanent</p>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[35px] shadow-sm border border-slate-100 overflow-hidden">

        {{-- Table Header --}}
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-slate-900 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-list text-white text-xs"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight uppercase">User Directory</h3>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5">
                <span class="text-slate-500 text-[10px] font-black tracking-[0.3em] uppercase">{{ $users->count() }} Records</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="p-5 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">User</th>
                        <th class="p-5 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Email</th>
                        <th class="p-5 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Role</th>
                        <th class="p-5 text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Status</th>
                        <th class="p-5 text-center text-[11px] font-black text-slate-400 tracking-[0.15em] uppercase">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($users as $user)

                    <tr class="table-row border-b border-slate-50">

                        <td class="p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600 font-black text-sm shadow-inner">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-bold text-slate-800 text-sm">{{ $user->name }}</span>
                            </div>
                        </td>

                        <td class="p-5 text-slate-500 text-sm font-medium">{{ $user->email }}</td>

                        <td class="p-5">
                            <span class="inline-flex items-center gap-1.5 bg-{{ $user->role === 'seller' ? 'red' : ($user->role === 'admin' ? 'slate' : 'blue') }}-50 border border-{{ $user->role === 'seller' ? 'red' : ($user->role === 'admin' ? 'slate' : 'blue') }}-200 text-{{ $user->role === 'seller' ? 'red' : ($user->role === 'admin' ? 'slate' : 'blue') }}-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                <i class="fa-solid fa-{{ $user->role === 'seller' ? 'store' : ($user->role === 'admin' ? 'shield' : 'user') }} text-[8px]"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td class="p-5">
                            @if($user->status == 'pending')
                                <span class="inline-flex items-center gap-1.5 bg-yellow-50 border border-yellow-200 text-yellow-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending
                                </span>
                            @elseif($user->status == 'approved')
                                <span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> {{ ucfirst($user->status) }}
                                </span>
                            @endif
                        </td>

                        <td class="p-5 text-center">

                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('⚠️ WARNING: This will permanently delete {{ $user->name }}.\n\nThis action cannot be undone. Continue?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="delete-btn inline-flex items-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 px-5 py-2.5 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                    <i class="fa-solid fa-trash-can"></i>
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- Footer --}}
        <div class="p-5 border-t border-slate-100 bg-slate-50 flex justify-between items-center">
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                <i class="fa-solid fa-circle-info mr-1"></i> Deletion is irreversible
            </p>
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                {{ $users->count() }} Total Users
            </p>
        </div>

    </div>

</div>

</body>
</html>
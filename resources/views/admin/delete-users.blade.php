<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Users | Admin Panel</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: #475569;
        }
        .custom-scrollbar::-webkit-scrollbar {
            height: 5px;
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #f87171;
            border-radius: 99px;
        }
        
        /* Premium Gradient Border Layout with Heavy Red Dominance */
        .gradient-border-wrapper {
            position: relative;
            background: linear-gradient(to right, #ba1124 0%, #d31c30 70%, #f97316 100%);
            padding: 1px;
        }
    </style>
</head>

<body class="antialiased min-h-screen selection:bg-red-500/10 selection:text-red-600">

<div class="max-w-6xl mx-auto p-6 md:p-12 space-y-8">

    {{-- RED-DOMINANT MASTER HEADER WITH TOUCH OF ORANGE --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 border-b border-slate-100 pb-8">
        <div class="space-y-1">
            <h1 class="text-3xl font-black tracking-tight">
                <span class="bg-gradient-to-r from-red-700 via-red-600 to-orange-500 bg-clip-text text-transparent">User Management </span>
            </h1>
            <p class="text-slate-400 text-sm">Permanently delete or handle user records within the platform cluster.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-white bg-gradient-to-r from-red-700 via-red-600 to-orange-500 hover:from-red-600 hover:to-orange-400 px-5 py-3 rounded-xl transition-all shadow-md shadow-red-600/20 hover:shadow-orange-500/20 hover:-translate-y-0.5">
            <i class="fa-solid fa-arrow-left"></i>
            Return to Dashboard
        </a>
    </div>

    {{-- DATA INTERFACE: PURGE REGISTER --}}
    <div class="gradient-border-wrapper rounded-3xl shadow-sm overflow-hidden">
        <div class="bg-white rounded-[23px] overflow-hidden">

            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-xs font-black tracking-widest text-red-700 uppercase flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                    Live User Directory Indexes
                </h2>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100 bg-slate-50/20">
                            <th class="py-4 px-6">Identity Parameter</th>
                            <th class="py-4 px-6">Assigned Network Mail</th>
                            <th class="py-4 px-6">Role Rank</th>
                            <th class="py-4 px-6">System Nodes Status</th>
                            <th class="py-4 px-6 text-center">Destruction Operational Trigger</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50 text-slate-600">

                        @foreach($users as $user)
                        <tr class="hover:bg-red-50/[0.12] transition-colors group">

                            {{-- NAME --}}
                            <td class="py-4 px-6 font-semibold text-slate-800 group-hover:text-red-600 transition-colors duration-200">
                                {{ $user->name }}
                            </td>

                            {{-- EMAIL --}}
                            <td class="py-4 px-6 text-slate-400 font-medium">
                                {{ $user->email }}
                            </td>

                            {{-- ROLE BADGES --}}
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200 text-slate-600">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            {{-- STATUS NODES TRACKING --}}
                            <td class="py-4 px-6">
                                @if($user->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 border border-amber-100/40">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @elseif($user->status == 'approved')
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100/40">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-lg bg-red-50 text-red-600 border border-red-100/40">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> {{ ucfirst($user->status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- ACTION TRIGGER DESTRUCTION OPERATIONAL CAPTURE --}}
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Delete this user permanently?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-gradient-to-r from-red-700 via-red-600 to-red-500 hover:from-red-600 hover:to-red-500 px-4 py-2 rounded-xl transition shadow-sm hover:shadow-md hover:shadow-red-600/10 active:scale-95">
                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                        Delete Account
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

</div>

</body>
</html>
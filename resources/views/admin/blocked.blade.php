<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Blocked Users</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }
    </style>
</head>

<body class="antialiased min-h-screen">

    <!-- TOP NAVBAR / HEADER CONTAINER -->
    <div class="max-w-6xl mx-auto p-6 md:py-10">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-12">
            <div>
                <h1 class="text-4xl font-black tracking-tight flex items-center gap-3">
                    <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">
                        Blocked Users
                    </span>
                </h1>
                <p class="text-slate-500 mt-1 text-sm md:text-base">
                    Restricted CraveCart accounts and access management.
                </p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-500 hover:to-orange-500 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition-all duration-200 shadow-md shadow-red-500/10 hover:shadow-orange-500/20 hover:-translate-y-0.5 inline-block">
                Dashboard
            </a>
        </div>

        <!-- GRID SYSTEM -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach($users as $user)
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm relative overflow-hidden group hover:border-red-500/30 transition-all duration-300 flex flex-col justify-between">
                
                <!-- Card Gradient Border Header Accent -->
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-red-500 to-orange-500"></div>

                <div class="flex justify-between items-start gap-4">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight group-hover:text-red-600 transition-colors duration-200 break-all">
                            {{ $user->name }}
                        </h2>
                        <p class="text-slate-400 text-sm break-all">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center text-lg flex-shrink-0 shadow-inner">
                        <i class="fa-solid fa-user-lock"></i>
                    </div>
                </div>

                <!-- ACTION BUTTON -->
                <div class="mt-8">
                    <form action="{{ route('admin.unblock', $user->id) }}" method="POST">
                        @csrf
                        <button class="w-full bg-slate-50 hover:bg-red-50 border border-slate-200 hover:border-red-200 text-slate-700 hover:text-red-600 py-3 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 shadow-sm">
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
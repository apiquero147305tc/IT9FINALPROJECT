<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valid ID | CraveCart Studio Hub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
        }
        .id-image {
            transition: all 0.5s ease;
        }
        .id-image:hover {
            transform: scale(1.02);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-4xl">

    {{-- Header --}}
    <div class="text-center mb-10">
        <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
            <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Verification</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
            Valid <span class="text-red-600">ID.</span>
        </h2>
        <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
            CraveCart Essentials Hub
        </p>
    </div>

    {{-- User Info Card --}}
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm p-6 mb-6 flex items-center gap-4">

        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 font-black text-xl shadow-inner">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>

        <div>
            <h3 class="font-bold text-slate-900 text-lg tracking-tight">{{ $user->name }}</h3>
            <p class="text-sm text-slate-400 font-medium">{{ $user->email }}</p>
        </div>

        <div class="ml-auto">
            <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                <i class="fa-solid fa-store text-[8px]"></i> {{ ucfirst($user->role) }}
            </span>
        </div>

    </div>

    {{-- ID Image Card --}}
    <div class="bg-white border border-slate-100 rounded-[35px] shadow-sm p-8 mb-8">

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-slate-900 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-id-card text-white text-xs"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight uppercase">Identification Document</h3>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5">
                <span class="text-slate-500 text-[10px] font-black tracking-[0.3em] uppercase">Seller Verification</span>
            </div>
        </div>

        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 overflow-hidden">
            <img src="{{ Storage::url($user->valid_id) }}" 
                 alt="Valid ID for {{ $user->name }}"
                 class="id-image w-full rounded-xl shadow-lg"
                 style="max-height: 600px; object-fit: contain;">
        </div>

        <div class="mt-4 flex justify-between items-center">
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                <i class="fa-solid fa-file-image mr-1"></i> {{ $user->valid_id ? pathinfo($user->valid_id, PATHINFO_EXTENSION) : 'Image' }} File
            </p>
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                Uploaded {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
            </p>
        </div>

    </div>

    {{-- Back Button --}}
    <div class="text-center">
        <a href="{{ route('admin.dashboard') }}" 
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-red-600 text-white font-black px-8 py-4 rounded-2xl text-[11px] tracking-[0.15em] uppercase transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Back to Dashboard
        </a>
    </div>

</div>

</body>
</html>
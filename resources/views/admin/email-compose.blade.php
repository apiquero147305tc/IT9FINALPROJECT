<!DOCTYPE html>
<html lang="en">
<head>
    <title>Compose Email | CraveCart Studio Hub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            background: white;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-3xl">

    {{-- Header Section --}}
    <div class="text-center mb-8">
        <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
            <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Communication</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
            Compose <span class="text-red-600">Email.</span>
        </h2>
        <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
            CraveCart Essentials Hub
        </p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-[35px] shadow-sm border border-slate-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="bg-white border-b border-slate-100 px-8 py-5 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center border border-red-100 shadow-inner">
                    <i class="fa-solid fa-paper-plane text-red-600 text-sm"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 tracking-tight text-sm uppercase">New Message</h3>
                    <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">Email Center</p>
                </div>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 bg-slate-50 hover:bg-slate-900 text-slate-600 hover:text-white border border-slate-200 px-4 py-2.5 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>

        </div>

        {{-- Recipient Info --}}
        <div class="px-8 py-5 bg-slate-50 border-b border-slate-100 flex items-center gap-4">

            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-600 font-black text-lg shadow-sm border border-slate-100">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <p class="text-[10px] font-black text-slate-400 tracking-wider uppercase mb-0.5">To</p>
                <p class="font-bold text-slate-800 text-sm">
                    {{ $user->name }}
                    <span class="text-slate-400 font-medium text-xs">({{ $user->email }})</span>
                </p>
            </div>

            <div class="ml-auto">
                <span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Active
                </span>
            </div>

        </div>

        {{-- Form --}}
        <form action="{{ route('admin.email.send', $user->id) }}" method="POST" class="p-8 space-y-6">

            @csrf

            {{-- Subject --}}
            <div>
                <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">
                    Subject
                </label>
                <input type="text"
                       name="subject"
                       placeholder="Enter email subject..."
                       class="input-field w-full bg-slate-50 border-0 rounded-xl px-5 py-4 text-slate-800 placeholder-slate-400 font-medium outline-none focus:ring-2 focus:ring-red-100 transition text-sm">
            </div>

            {{-- Message --}}
            <div>
                <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">
                    Message
                </label>
                <textarea name="message"
                          rows="10"
                          placeholder="Write your message here..."
                          class="input-field w-full bg-slate-50 border-0 rounded-xl px-5 py-4 text-slate-800 placeholder-slate-400 font-medium outline-none focus:ring-2 focus:ring-red-100 transition text-sm resize-none"></textarea>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 pt-2">

                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center gap-2 bg-slate-50 hover:bg-slate-100 text-slate-600 border border-slate-200 px-6 py-3 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                    Cancel
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 bg-slate-900 hover:bg-red-600 text-white px-6 py-3 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300 shadow-lg hover:shadow-xl">

                    <i class="fa-solid fa-paper-plane"></i>
                    Send Email

                </button>

            </div>

        </form>

        {{-- Footer --}}
        <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                <i class="fa-solid fa-lock mr-1"></i> Secure Transmission
            </p>
            <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                {{ now()->format('M d, Y • h:i A') }}
            </p>
        </div>

    </div>

</div>

</body>
</html>
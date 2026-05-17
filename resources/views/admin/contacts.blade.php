<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Messages | CraveCart Studio Hub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8f5;
        }
        .message-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .message-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>

<body class="min-h-screen">

<div class="max-w-5xl mx-auto p-6">

    {{-- Header --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 flex justify-between items-center shadow-sm mb-8">

        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center border border-red-100 shadow-inner">
                <i class="fa-solid fa-envelope text-red-600 text-xl"></i>
            </div>
            <div>
                <h1 class="font-black text-slate-900 tracking-tight text-xl leading-none">Contact Messages</h1>
                <p class="text-[10px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-1">Studio Hub</p>
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-red-600 text-white font-black px-6 py-3 rounded-2xl text-[11px] tracking-[0.15em] uppercase transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Back
        </a>

    </div>

    {{-- Title Section --}}
    <div class="text-center mb-10">
        <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
            <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Inbox Center</span>
        </div>
        <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
            User <span class="text-red-600">Inquiries.</span>
        </h2>
        <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
            CraveCart Essentials Hub
        </p>
    </div>

    {{-- Stats Bar --}}
    <div class="flex gap-4 mb-8">
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-envelope-open text-red-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Total</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ $contacts->count() }}</p>
            </div>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-bell text-red-500 text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Unread</p>
                <p class="text-lg font-black text-red-600 leading-none">{{ $contacts->where('is_read', false)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Message List --}}
    <div class="space-y-5">

        @forelse($contacts as $msg)

            <div class="message-card bg-white border {{ $msg->is_read ? 'border-slate-100' : 'border-red-200' }} rounded-[35px] p-8 shadow-sm relative overflow-hidden">

                {{-- Unread Indicator Line --}}
                @if(!$msg->is_read)
                    <div class="absolute top-0 left-0 w-full h-1 bg-red-500"></div>
                @endif

                {{-- Top Info --}}
                <div class="flex justify-between items-start mb-4">

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 font-black text-xl shadow-inner">
                            {{ strtoupper(substr($msg->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg tracking-tight">{{ $msg->name }}</h3>
                            <p class="text-sm text-slate-400 font-medium">{{ $msg->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">

                        {{-- Type Badge --}}
                        @if($msg->type === 'report')
                            <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Report
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-slate-50 border border-slate-200 text-slate-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                <span class="w-1.5 h-1.5 bg-slate-500 rounded-full"></span> Contact
                            </span>
                        @endif

                        {{-- Status Badge --}}
                        @if(!$msg->is_read)
                            <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> New
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-slate-50 border border-slate-200 text-slate-500 px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span> Read
                            </span>
                        @endif

                    </div>

                </div>

                {{-- Message --}}
                <div class="bg-slate-50 rounded-2xl p-5 mb-5 border border-slate-100">
                    <p class="text-slate-700 leading-relaxed text-sm font-medium">
                        {{ $msg->message }}
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3">

                    @if(!$msg->is_read)
                        <form method="POST" action="{{ route('admin.contacts.read', $msg->id) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 bg-green-50 hover:bg-green-600 text-green-600 hover:text-white border border-green-200 px-5 py-2.5 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                                <i class="fa-solid fa-check"></i> Mark as Read
                            </button>
                        </form>
                    @endif

                    <a href="mailto:{{ $msg->email }}" class="inline-flex items-center gap-2 bg-slate-50 hover:bg-slate-900 text-slate-600 hover:text-white border border-slate-200 px-5 py-2.5 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                        <i class="fa-solid fa-reply"></i> Reply via Email
                    </a>

                    @if($msg->user_id)
                        <a href="{{ route('admin.chat', $msg->user_id) }}" class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 px-5 py-2.5 rounded-xl text-[11px] font-black tracking-wider uppercase transition-all duration-300">
                            <i class="fa-solid fa-comments"></i> Open Chat
                        </a>
                    @endif

                </div>

                {{-- Timestamp --}}
                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                    <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        <i class="fa-regular fa-clock mr-1"></i> {{ $msg->created_at->format('M d, Y • h:i A') }}
                    </p>
                    <p class="text-[10px] font-bold text-slate-300 tracking-wider uppercase">ID: #{{ $msg->id }}</p>
                </div>

            </div>

        @empty

            <div class="text-center py-20">
                <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
                    <i class="fa-solid fa-inbox text-4xl text-slate-200"></i>
                </div>
                <div class="inline-block bg-slate-100 border border-slate-200 rounded-full px-4 py-1.5 mb-4">
                    <span class="text-slate-500 text-[10px] font-black tracking-[0.4em] uppercase">Empty Inbox</span>
                </div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight uppercase mb-2">No Messages Yet.</h3>
                <p class="text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">CraveCart Studio Hub</p>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>
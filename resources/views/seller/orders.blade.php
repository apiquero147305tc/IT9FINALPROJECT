<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | CraveCart Seller Studio</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #ffffff;
        }
        .order-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body class="min-h-screen">

    {{-- Red Header Bar --}}
    <div class="bg-[#dc2626] text-white px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-store text-white"></i>
            </div>
            <div>
                <h1 class="font-black text-sm tracking-wider uppercase">CraveCart <span class="text-white/80">|</span> Seller Studio</h1>
                <p class="text-[10px] font-bold text-white/70 tracking-[0.2em] uppercase">My Shop | Active</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="#" class="text-xs font-black tracking-wider uppercase text-white/90 hover:text-white">Notifications</a>
            <a href="#" class="text-xs font-black tracking-wider uppercase text-white/90 hover:text-white">Lending</a>
            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-xs font-bold">ES</div>
            <a href="{{ route('logout') }}" class="bg-[#0f172a] hover:bg-black text-white px-5 py-2 rounded-full text-xs font-black tracking-wider uppercase transition">Logout</a>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-5xl mx-auto p-10">

        {{-- Title Section --}}
        <div class="mb-10">
            <h2 class="text-5xl font-black text-[#0f172a] tracking-tight uppercase">
                All <span class="text-[#dc2626]">Orders.</span>
            </h2>
            <div class="w-16 h-1 bg-[#dc2626] mt-4"></div>
            <p class="mt-3 text-xs font-bold text-slate-400 tracking-[0.25em] uppercase">Order Management</p>
        </div>

        {{-- Stats Bar --}}
        <div class="flex gap-4 mb-8">
            <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 bg-slate-50 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-bag-shopping text-slate-500 text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Total Orders</p>
                    <p class="text-lg font-black text-slate-900 leading-none">{{ $orders->count() }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 bg-yellow-50 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-clock text-yellow-500 text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Pending</p>
                    <p class="text-lg font-black text-yellow-600 leading-none">{{ $orders->where('status', 'pending')->count() }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-100 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 bg-green-50 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-check text-green-500 text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 tracking-wider uppercase">Completed</p>
                    <p class="text-lg font-black text-green-600 leading-none">{{ $orders->where('status', 'completed')->count() }}</p>
                </div>
            </div>
        </div>

        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('seller.dash') }}" 
               class="inline-flex items-center gap-2 bg-slate-900 hover:bg-[#dc2626] text-white font-black px-6 py-3 rounded-full text-[11px] tracking-[0.15em] uppercase transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back to Dashboard
            </a>
        </div>

        {{-- Orders List --}}
        <div class="space-y-5">

            @forelse($orders as $order)

            <div class="order-card bg-white rounded-[30px] shadow-sm border border-slate-100 p-8 relative overflow-hidden group">

                {{-- Top accent line for pending --}}
                @if($order->status === 'pending')
                    <div class="absolute top-0 left-0 w-full h-1 bg-yellow-500"></div>
                @elseif($order->status === 'completed')
                    <div class="absolute top-0 left-0 w-full h-1 bg-green-500"></div>
                @else
                    <div class="absolute top-0 left-0 w-full h-1 bg-slate-300"></div>
                @endif

                <div class="flex justify-between items-start mb-4">

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 font-black text-xl shadow-inner">
                            {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg tracking-tight">{{ $order->user->name ?? 'Unknown Customer' }}</h3>
                            <p class="text-xs text-slate-400 font-medium">{{ $order->created_at->format('M d, Y • h:i A') }}</p>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-2xl font-black text-[#0f172a]">₱{{ number_format($order->total_price, 2) }}</p>
                        <span class="inline-flex items-center gap-1.5 mt-1 
                            {{ $order->status === 'pending' ? 'bg-yellow-50 border-yellow-200 text-yellow-600' : 
                               ($order->status === 'completed' ? 'bg-green-50 border-green-200 text-green-600' : 
                                'bg-slate-50 border-slate-200 text-slate-600') }} 
                            px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase border">
                            <span class="w-1.5 h-1.5 rounded-full 
                                {{ $order->status === 'pending' ? 'bg-yellow-500' : 
                                   ($order->status === 'completed' ? 'bg-green-500' : 'bg-slate-400') }}"></span>
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                </div>

                {{-- Product Info --}}
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 flex items-center gap-4">

                    @if($order->product && $order->product->images->first())
                        <div class="w-16 h-16 bg-white rounded-xl overflow-hidden shadow-sm flex-shrink-0">
                            <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" 
                                 alt="{{ $order->product->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-16 h-16 bg-slate-200 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-box text-slate-400 text-xl"></i>
                        </div>
                    @endif

                    <div>
                        <p class="text-[10px] font-black text-slate-400 tracking-wider uppercase mb-1">Product</p>
                        <p class="font-bold text-slate-800">{{ $order->product->name ?? 'Deleted Product' }}</p>
                        @if($order->product)
                            <p class="text-xs text-slate-400 mt-0.5">{{ $order->product->category }}</p>
                        @endif
                    </div>

                </div>

                {{-- Footer --}}
                <div class="mt-5 pt-4 border-t border-slate-100 flex justify-between items-center">

                    <p class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        <i class="fa-regular fa-clock mr-1"></i> {{ $order->created_at->diffForHumans() }}
                    </p>

                    <p class="text-[10px] font-bold text-slate-300 tracking-wider uppercase">Order #{{ $order->id }}</p>

                </div>

            </div>

            @empty

            {{-- Empty State --}}
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
                    <i class="fa-solid fa-bag-shopping text-4xl text-slate-200"></i>
                </div>
                <div class="inline-block bg-slate-100 border border-slate-200 rounded-full px-4 py-1.5 mb-4">
                    <span class="text-slate-500 text-[10px] font-black tracking-[0.4em] uppercase">Empty</span>
                </div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight uppercase mb-2">No Orders Yet.</h3>
                <p class="text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">CraveCart Seller Studio</p>
            </div>

            @endforelse

        </div>

    </div>

</body>
</html>
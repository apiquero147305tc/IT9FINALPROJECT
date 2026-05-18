<x-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Add New Item</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
        }

        /* 🔴 Clean Hide targets the main marketplace layout top navigation bar on this view */
        nav.nav-branded,
        header,
        nav:not(.studio-nav)[class*="bg-gradient"],
        div[class*="bg-gradient"][class*="sticky"] {
            display: none !important;
        }

        /* Interactive modern inputs matching Studio design framework */
        .form-input-premium {
            width: 100%;
            border: 2px solid #e2e8f0;
            border-radius: 1rem;
            padding: 0.875rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #1e293b;
            transition: all 0.25s ease;
            outline: none;
            background-color: #ffffff;
        }

        .form-input-premium:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .form-label-premium {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 0.5rem;
            margin-left: 0.25rem;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50/60 antialiased">

    {{-- ========================================================= --}}
    {{-- UNIFIED BRANDED GRADIENT NAVIGATION BAR                    --}}
    {{-- ========================================================= --}}
    <nav class="studio-nav bg-gradient-to-r from-rose-600 via-orange-500 to-amber-500 w-full shadow-lg shadow-orange-500/10 border-b border-orange-600/20 sticky top-0 z-50 py-4 px-4 md:px-6">
        <div class="max-w-3xl mx-auto flex items-center justify-between text-white">
            
            <div class="flex items-center gap-3">
                <a href="{{ route('seller.dash') }}" class="bg-white/10 p-2 rounded-xl border border-white/10 flex items-center justify-center backdrop-blur-sm transition hover:bg-white/20">
                    <i class="fa-solid fa-arrow-left text-base text-orange-200"></i>
                </a>
                <div>
                    <h1 class="text-base font-black tracking-tight leading-none">Seller Studio</h1>
                    <p class="text-[10px] text-orange-100/70 font-medium mt-1">Catalog Expansion Registry</p>
                </div>
            </div>

            <a href="{{ route('seller.dash') }}" class="inline-flex items-center gap-1.5 bg-black/15 backdrop-blur-md px-3 py-2 rounded-xl text-[10px] font-bold uppercase tracking-wider border border-white/10 text-white hover:bg-black/25 transition">
                Dashboard
            </a>
        </div>
    </nav>

    {{-- ========================================================= --}}
    {{-- MAIN CONFIGURATION WORKSPACE                              --}}
    {{-- ========================================================= --}}
    <main class="max-w-3xl mx-auto p-4 md:p-8 space-y-8">
        
        {{-- Header Identifier Row --}}
        <div class="border-b border-slate-200/60 pb-5">
            <h2 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-circle-plus text-orange-500"></i> Add New Product
            </h2>
            <p class="text-xs text-slate-400 mt-1">Onboard your asset listings directly into the marketplace engine.</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 md:p-10">
            
            {{-- Error Context Alert Blocks --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-xl flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm mt-0.5"></i>
                    <div>
                        <h4 class="text-xs font-bold text-rose-800 uppercase tracking-wider">Validation Errors Overlooked</h4>
                        <ul class="list-disc pl-4 mt-1.5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-rose-600 text-xs font-medium">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Form Structure Element --}}
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label-premium">Item Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Premium Cooking Oil" required class="form-input-premium">
                    </div>

                    <div>
                        <label class="form-label-premium">Category Classification</label>
                        <div class="relative">
                            <select name="category" class="form-input-premium appearance-none bg-white cursor-pointer pr-10">
                                <option value="Household">Household Goods</option>
                                <option value="Cooking">Cooking & Pantry</option>
                                <option value="School Supplies">School & Office Supplies</option>
                                <option value="Accessories">Accessories & Jewelry</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 text-xs">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label-premium">Base Price (PHP)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-bold text-sm pointer-events-none">₱</span>
                            <input type="number" name="price" value="{{ old('price') }}" step="0.01" placeholder="0.00" required class="form-input-premium pl-8">
                        </div>
                    </div>
                    <div>
                        <label class="form-label-premium">Initial Stock Quantity</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" placeholder="e.g. 50" required class="form-input-premium">
                    </div>
                </div>

                <div>
                    <label class="form-label-premium">Item Public Description</label>
                    <textarea name="description" rows="4" placeholder="Detail specifications, measurements, capabilities or borrowing stipulations..." class="form-input-premium resize-none">{{ old('description') }}</textarea>
                </div>

                {{-- Interactive Branded Media Upload Area --}}
                <div class="p-6 md:p-8 bg-slate-50/50 rounded-2xl border-2 border-dashed border-slate-200 text-center relative group transition hover:bg-slate-50">
                    <div class="w-12 h-12 bg-white text-slate-400 border border-slate-200 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-sm group-hover:text-orange-500 group-hover:border-orange-200 transition-colors">
                        <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                    </div>
                    <label class="form-label-premium !ml-0 !mb-1 text-center cursor-pointer">Upload Asset Showcase Photos</label>
                    <p class="text-[11px] text-slate-400 font-medium mb-4">Supports multi-photo drops for dynamic preview arrays</p>
                    
                    <input type="file" name="images[]" accept="image/*" multiple 
                           class="text-xs text-slate-500 font-medium file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer mx-auto">
                </div>

                {{-- Action Controls Row --}}
                <div class="pt-4 flex flex-col sm:flex-row items-center gap-3">
                    <button type="submit" 
                            class="w-full sm:flex-1 bg-gradient-to-r from-rose-500 via-orange-500 to-orange-600 text-white py-4 rounded-xl font-bold uppercase tracking-wider text-xs hover:opacity-95 active:scale-95 transition-all shadow-md shadow-orange-500/10">
                        <i class="fa-solid fa-cloud-arrow-up mr-1 text-sm"></i> Commit & Deploy Item
                    </button>
                    
                    <a href="{{ route('seller.dash') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center bg-white border border-slate-200 text-slate-500 hover:text-slate-700 hover:bg-slate-50 px-6 py-4 rounded-xl font-bold uppercase tracking-wider text-xs transition active:scale-95 shadow-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('seller.dash') }}" class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-orange-500 transition-colors">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Return to Studio Dashboard
            </a>
        </div>
    </main>
</body>
</html>
</x-layout>
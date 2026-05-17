<x-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Edit Item</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        
        body { 
            background-color: #ffffff; 
            font-family: 'Inter', sans-serif; 
            color: #0f172a;
        }

        /* 🔴 Branded Solid Red Navbar */
        .nav-branded { 
            background-color: #dc2626; 
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* Standard Red Studio Input Styling */
        .form-input {
            width: 100%;
            border: 4px solid #f8fafc;
            border-radius: 1.5rem;
            padding: 1.25rem;
            font-weight: 700;
            transition: all 0.3s ease;
            outline: none;
            background-color: #f8fafc;
        }

        .form-input:focus {
            border-color: #dc2626;
            background-color: #fffafb;
        }

        label {
            display: block;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            margin-bottom: 0.5rem;
            margin-left: 0.5rem;
        }

        /* Custom scrollbar for description textarea */
        textarea::-webkit-scrollbar { width: 8px; }
        textarea::-webkit-scrollbar-track { background: transparent; }
        textarea::-webkit-scrollbar-thumb { background: #fee2e2; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen bg-slate-50/30">

    <nav class="nav-branded px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <div class="flex items-center gap-2">
            <a href="{{ route('seller.dash') }}" class="bg-white p-1.5 rounded-xl shadow-sm hover:scale-110 active:scale-95 transition-all">
                <span class="text-xl">🏪</span>
            </a>
            <div>
                <h1 class="text-sm font-extrabold tracking-tight uppercase text-white leading-none">
                    Seller Studio
                </h1>
                <p class="text-[10px] text-rose-100 font-bold uppercase tracking-widest mt-1">
                    Editing: {{ $product->name }}
                </p>
            </div>
        </div>
        <a href="{{ route('seller.dash') }}" class="text-[10px] font-black uppercase tracking-widest text-rose-100 hover:text-white transition">
            Cancel Changes
        </a>
    </nav>

    <main class="max-w-2xl mx-auto p-6 md:p-12">
        
        <div class="mb-10">
            <h2 class="text-6xl font-black tracking-tighter uppercase text-slate-900 leading-none">Modify Item</h2>
            <div class="h-2 w-20 bg-red-600 mt-4 rounded-full"></div>
        </div>

        <div class="bg-white border border-slate-100 rounded-[3rem] shadow-2xl shadow-slate-900/5 p-8 md:p-12 relative overflow-hidden">
            
            @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl">
                    <ul class="list-none p-0 m-0">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600 text-[10px] font-black uppercase tracking-tight">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ✅ UPDATE FORM --}}
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <label>Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="form-input" placeholder="e.g. Premium Pencil">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label>Price (PHP)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" required class="form-input">
                    </div>
                    <div>
                        <label>Stock Level</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="form-input">
                    </div>
                </div>

                <div>
                    <label>Store Category</label>
                    <select name="category" class="form-input appearance-none bg-white cursor-pointer">
                        <option value="Cooking" {{ $product->category == 'Cooking' ? 'selected' : '' }}>Cooking</option>
                        <option value="Household" {{ $product->category == 'Household' ? 'selected' : '' }}>Household</option>
                        <option value="School Supplies" {{ $product->category == 'School Supplies' ? 'selected' : '' }}>School Supplies</option>
                        <option value="Accessories" {{ $product->category == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                    </select>
                </div>

                <div>
                    <label>Description</label>
                    <textarea name="description" rows="3" placeholder="Describe your item..." class="form-input resize-none">{{ old('description', $product->description) }}</textarea>
                </div>

                <div>
                    <label>Current Gallery</label>
                    <div class="flex flex-wrap gap-4 p-8 bg-slate-50/50 rounded-[2.5rem] border-2 border-dashed border-slate-100 mt-2">
                        @forelse($product->images as $img)
                            <div class="group relative w-24 h-24 rounded-3xl overflow-hidden border-4 border-white shadow-md hover:scale-110 transition-all">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-red-600/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                        @empty
                            <div class="w-full text-center py-4">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 italic">No images currently uploaded</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <label>Add More Photos</label>
                    <div class="relative group">
                        <input type="file" name="images[]" multiple 
                               class="w-full text-xs font-bold text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-xs file:font-black file:bg-slate-900 file:text-white hover:file:bg-red-600 transition-all cursor-pointer">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-red-600 text-white py-6 rounded-[2rem] font-black uppercase tracking-[0.2em] text-sm hover:bg-slate-950 transition-all shadow-xl shadow-red-600/20">
                    Save Changes
                </button>
            </form>

            <div class="mt-12 pt-8 border-t border-slate-100 text-center">
                {{-- ✅ DELETE PRODUCT --}}
                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                      onsubmit="return confirm('⚠️ CRITICAL: Are you sure? This will permanently remove the product and all images.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-slate-300 hover:text-red-600 text-[10px] font-black uppercase tracking-widest transition-colors inline-flex items-center gap-2 bg-transparent border-none cursor-pointer">
                        <span>🗑️</span> Archive Product Permanently
                    </button>
                </form>
            </div>

        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('seller.dash') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-600 transition-all no-underline">
                ← Return to Dashboard
            </a>
        </div>
    </main>
</body>
</html>
</x-layout>
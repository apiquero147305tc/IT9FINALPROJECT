<x-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Add New Item</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        
        body { 
            background-color: #ffffff; 
            font-family: 'Inter', sans-serif; 
            color: #0f172a;
        }

        /* 🔴 Crimson Navbar Branding */
        .nav-branded { 
            background-color: #dc2626; 
        }

        /* Clean input styling to match your Red Studio theme */
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
    </style>
</head>
<body class="min-h-screen bg-slate-50/50">

    <nav class="nav-branded px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <div class="flex items-center gap-2">
            <a href="{{ route('seller.dash') }}" class="bg-white p-1.5 rounded-xl shadow-sm hover:scale-110 transition">
                <span class="text-xl">⬅️</span>
            </a>
            <h1 class="text-sm font-extrabold tracking-tight uppercase text-white">
                Back to Dashboard
            </h1>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto p-6 md:p-12">
        
        <div class="mb-12 text-center">
            <h2 class="text-6xl font-black tracking-tighter uppercase text-slate-900 leading-none">Add Item</h2>
            <p class="text-xs font-bold text-red-600 uppercase tracking-[0.3em] mt-2">Expand Your Inventory</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-[3rem] shadow-2xl shadow-slate-900/5 p-8 md:p-12">
            
            @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl">
                    <ul class="list-none p-0 m-0">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600 text-[10px] font-black uppercase tracking-tight">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label>Item Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Cooking Oil" required class="form-input">
                </div>

                <div>
                    <label>Category</label>
                    <select name="category" class="form-input appearance-none bg-white cursor-pointer">
                        <option value="Household">Household</option>
                        <option value="Cooking">Cooking</option>
                        <option value="School Supplies">School Supplies</option>
                        <option value="Accessories">Accessories</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Price (PHP)</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" placeholder="0.00" required class="form-input">
                    </div>
                    <div>
                        <label>Stock Quantity</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" placeholder="0" required class="form-input">
                    </div>
                </div>

                <div>
                    <label>Item Description</label>
                    <textarea name="description" rows="4" placeholder="Tell customers about your product..." class="form-input resize-none">{{ old('description') }}</textarea>
                </div>

                <div class="p-8 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200 text-center">
                    <label class="mb-4 block">Product Images</label>
                    <input type="file" name="images[]" accept="image/*" multiple 
                           class="text-xs font-bold text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-red-100 file:text-red-600 hover:file:bg-red-200 cursor-pointer">
                    <p class="mt-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest">Supports multiple high-quality photos</p>
                </div>

                <button type="submit" 
                        class="w-full bg-slate-950 text-white py-6 rounded-3xl font-black uppercase tracking-[0.2em] text-sm hover:bg-red-600 hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-red-900/10 mt-8">
                    Upload to Shop
                </button>
            </form>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('seller.dash') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-600 transition-colors">
                ← Return to Studio
            </a>
        </div>
    </main>
</body>
</html>
</x-layout>
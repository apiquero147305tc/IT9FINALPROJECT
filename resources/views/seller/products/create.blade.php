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
            background-color: #fffaf9; 
            font-family: 'Inter', sans-serif; 
            color: #1e1b1a;
        }

        /* 🔴 Maximum Impact Red Navigation */
        .nav-branded { 
            background-color: #b91c1c; 
            border-bottom: 4px solid #7f1d1d;
        }

        /* Clean input styling to match the Red Studio theme */
        .form-input {
            width: 100%;
            border: 4px solid #f8fafc;
            border-radius: 1.5rem;
            padding: 1.25rem;
            font-weight: 700;
            transition: all 0.3s ease;
            outline: none;
            background-color: #ffffff;
        }

        .form-input:focus {
            border-color: #dc2626;
            background-color: #fef2f2;
            box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.1);
        }

        label {
            display: block;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #94a3b8;
            margin-bottom: 0.6rem;
            margin-left: 0.75rem;
        }

        ::selection {
            background: #991b1b;
            color: white;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50/30">

    <nav class="nav-branded px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-2xl">
        <div class="flex items-center gap-4">
            <a href="{{ route('seller.dash') }}" class="bg-white p-2 rounded-xl shadow-md hover:scale-110 transition-all group">
                <span class="text-xl group-hover:-translate-x-1 inline-block transition-transform">⬅️</span>
            </a>
            <h1 class="text-xs font-black tracking-widest uppercase text-white">
                Seller Studio | <span class="text-red-200">Inventory Management</span>
            </h1>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto p-6 md:p-12">
        
        <div class="mb-12 text-center">
            <h2 class="text-6xl font-black tracking-tighter uppercase text-slate-900 leading-none">Add Item</h2>
            <div class="h-2 w-16 bg-red-700 mx-auto mt-4 rounded-full"></div>
            <p class="text-[10px] font-bold text-red-700 uppercase tracking-[0.4em] mt-6">Expand Your Inventory</p>
        </div>

        <div class="bg-white border border-red-100 rounded-[3rem] shadow-2xl shadow-red-900/5 p-8 md:p-12">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label>Item Name</label>
                    <input type="text" name="name" placeholder="e.g. Cooking Oil" required class="form-input text-slate-900">
                </div>

                <div>
                    <label>Category</label>
                    <div class="relative">
                        <select name="category" class="form-input appearance-none bg-white text-slate-900 pr-12 cursor-pointer">
                            <option value="Household">Household</option>
                            <option value="Cooking">Cooking</option>
                            <option value="School Supplies">School Supplies</option>
                            <option value="Accessories">Accessories</option>
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-red-600">
                            ▼
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label>Price (PHP)</label>
                        <input type="number" name="price" step="0.01" placeholder="0.00" required class="form-input text-slate-900">
                    </div>
                    <div>
                        <label>Stock Quantity</label>
                        <input type="number" name="stock" placeholder="0" required class="form-input text-slate-900">
                    </div>
                </div>

                <div>
                    <label>Item Description</label>
                    <textarea name="description" rows="4" placeholder="Tell customers about your product..." class="form-input resize-none text-slate-900"></textarea>
                </div>

                <div class="p-10 bg-red-50/50 rounded-[2.5rem] border-4 border-dashed border-red-100 text-center transition-colors hover:border-red-200">
                    <label class="mb-4 block text-red-900">Product Images</label>
                    <input type="file" name="images[]" accept="image/*" multiple 
                           class="text-[10px] font-black text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-[10px] file:font-black file:bg-red-700 file:text-white hover:file:bg-black cursor-pointer transition-all">
                    <p class="mt-4 text-[10px] text-red-600/50 font-bold uppercase tracking-widest">Multiple high-quality photos supported</p>
                </div>

                <button type="submit" 
                        class="w-full bg-slate-950 text-white py-6 rounded-[2rem] font-black uppercase tracking-[0.3em] text-[11px] hover:bg-red-700 hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-slate-900/20 mt-8">
                    Upload to Shop
                </button>
            </form>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('seller.dash') }}" class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-400 hover:text-red-700 transition-colors">
                ← Return to Studio
            </a>
        </div>
    </main>
</body>
</html>
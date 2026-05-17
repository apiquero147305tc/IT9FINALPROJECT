<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | CraveCart Seller Studio</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #ffffff;
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
        .red-pill {
            transition: all 0.3s ease;
        }
        .red-pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.3);
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
    <div class="max-w-4xl mx-auto p-10">

        {{-- Title Section --}}
        <div class="mb-10">
            <h2 class="text-5xl font-black text-[#0f172a] tracking-tight uppercase">
                Add New <span class="text-[#dc2626]">Item.</span>
            </h2>
            <div class="w-16 h-1 bg-[#dc2626] mt-4"></div>
            <p class="mt-3 text-xs font-bold text-slate-400 tracking-[0.25em] uppercase">Inventory Management</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-[30px] shadow-lg border border-slate-100 p-10">

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="productForm">
                @csrf

                {{-- Product Name --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Product Name
                    </label>
                    <input type="text" 
                           name="name" 
                           placeholder="e.g. Cooking Oil"
                           required
                           class="input-field w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 text-[#0f172a] placeholder-slate-400 font-semibold outline-none transition text-sm">
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Category
                    </label>
                    <select name="category" id="categorySelect"
                            onchange="toggleCustomCategory()"
                            class="input-field w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 text-slate-600 font-semibold outline-none transition text-sm appearance-none cursor-pointer">

                        <option value="Household">Household</option>
                        <option value="Cooking">Cooking</option>
                        <option value="School Supplies">School Supplies</option>
                        <option value="Accessories">Accessories</option>
                        <option value="custom">+ Custom Category</option>

                    </select>
                </div>

                {{-- Custom Category Input (Hidden by default) --}}
                <div id="customCategoryContainer" class="hidden">
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Enter Custom Category
                    </label>
                    <input type="text" 
                           name="custom_category" 
                           id="customCategoryInput"
                           placeholder="e.g. Electronics, Beauty, etc."
                           class="input-field w-full bg-red-50 border-2 border-red-200 rounded-2xl px-6 py-4 text-[#0f172a] placeholder-slate-400 font-semibold outline-none focus:border-[#dc2626] transition text-sm">
                </div>

                {{-- Price & Stock Row --}}
                <div class="grid grid-cols-2 gap-5">

                    <div>
                        <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                            Price (PHP)
                        </label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[#0f172a] text-lg font-black">₱</span>
                            <input type="number" 
                                   name="price" 
                                   step="0.01" 
                                   placeholder="0.00" 
                                   required
                                   class="input-field w-full pl-12 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-[#0f172a] placeholder-slate-400 font-semibold outline-none transition text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                            Stock Quantity
                        </label>
                        <input type="number" 
                               name="stock" 
                               required
                               class="input-field w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-[#0f172a] placeholder-slate-400 font-semibold outline-none transition text-sm">
                    </div>

                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Description
                    </label>
                    <textarea name="description" 
                              rows="4" 
                              placeholder="Tell customers about your product..."
                              class="input-field w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 text-[#0f172a] placeholder-slate-400 font-semibold outline-none transition text-sm resize-none"></textarea>
                </div>

                {{-- Product Image --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Product Image
                    </label>
                    <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-[#dc2626] hover:bg-red-50/50 transition cursor-pointer" onclick="document.getElementById('fileInput').click()">
                        <input type="file" 
                               id="fileInput"
                               name="images[]" 
                               accept="image/*" 
                               multiple
                               class="hidden"
                               onchange="updateFileName(this)">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                            <i class="fa-solid fa-cloud-arrow-up text-[#dc2626] text-2xl"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-600">Click to upload images</p>
                        <p class="text-xs text-slate-400 mt-1" id="fileLabel">or drag and drop files here</p>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="red-pill flex-1 bg-[#dc2626] hover:bg-[#b91c1c] text-white font-black py-4 rounded-full transition tracking-[0.1em] uppercase text-xs flex items-center justify-center gap-2 shadow-lg shadow-red-200">
                        <i class="fa-solid fa-plus"></i>
                        Add Product
                    </button>
                    
                    <a href="{{ route('seller.dash') }}" 
                       class="red-pill bg-[#0f172a] hover:bg-black text-white font-black py-4 px-8 rounded-full transition tracking-[0.1em] uppercase text-xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back
                    </a>
                </div>

            </form>

        </div>

    </div>

<script>
    function toggleCustomCategory() {
        const select = document.getElementById('categorySelect');
        const container = document.getElementById('customCategoryContainer');
        const input = document.getElementById('customCategoryInput');

        if (select.value === 'custom') {
            container.classList.remove('hidden');
            input.setAttribute('required', 'required');
            input.focus();
        } else {
            container.classList.add('hidden');
            input.removeAttribute('required');
            input.value = '';
        }
    }

    function updateFileName(input) {
        const label = document.getElementById('fileLabel');
        if (input.files && input.files.length > 0) {
            label.textContent = input.files.length + ' file(s) selected';
            label.classList.add('text-[#dc2626]', 'font-bold');
        }
    }
</script>

</body>
</html>
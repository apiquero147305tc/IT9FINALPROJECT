<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | CraveCart Seller Studio</title>

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
        .image-card {
            transition: all 0.3s ease;
        }
        .image-card:hover {
            transform: scale(1.05);
        }
        .delete-img-btn {
            transition: all 0.2s ease;
        }
        .delete-img-btn:hover {
            transform: scale(1.1);
            background: #b91c1c;
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
                Edit <span class="text-[#dc2626]">Product.</span>
            </h2>
            <div class="w-16 h-1 bg-[#dc2626] mt-4"></div>
            <p class="mt-3 text-xs font-bold text-slate-400 tracking-[0.25em] uppercase">Inventory Management</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-[30px] shadow-lg border border-slate-100 p-10">

            {{-- Update Form --}}
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="editForm">
                @csrf
                @method('PUT')

                {{-- Product Name --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Product Name
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ $product->name }}"
                           required
                           class="input-field w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 text-[#0f172a] placeholder-slate-400 font-semibold outline-none transition text-sm">
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
                                   value="{{ $product->price }}"
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
                               value="{{ $product->stock }}"
                               required
                               class="input-field w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-[#0f172a] placeholder-slate-400 font-semibold outline-none transition text-sm">
                    </div>

                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Category
                    </label>
                    <select name="category" id="categorySelect"
                            onchange="toggleCustomCategory()"
                            class="input-field w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 text-slate-600 font-semibold outline-none transition text-sm appearance-none cursor-pointer">

                        <option value="Cooking" {{ $product->category == 'Cooking' ? 'selected' : '' }}>Cooking</option>
                        <option value="Household" {{ $product->category == 'Household' ? 'selected' : '' }}>Household</option>
                        <option value="School Supplies" {{ $product->category == 'School Supplies' ? 'selected' : '' }}>School Supplies</option>
                        <option value="Accessories" {{ $product->category == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                        
                        {{-- Check if current category is custom --}}
                        @if(!in_array($product->category, ['Cooking', 'Household', 'School Supplies', 'Accessories']))
                            <option value="custom" selected>+ Custom Category</option>
                        @else
                            <option value="custom">+ Custom Category</option>
                        @endif

                    </select>
                </div>

                {{-- Custom Category Input --}}
                <div id="customCategoryContainer" class="{{ !in_array($product->category, ['Cooking', 'Household', 'School Supplies', 'Accessories']) ? '' : 'hidden' }}">
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Enter Custom Category
                    </label>
                    <input type="text" 
                           name="custom_category" 
                           id="customCategoryInput"
                           value="{{ !in_array($product->category, ['Cooking', 'Household', 'School Supplies', 'Accessories']) ? $product->category : '' }}"
                           placeholder="e.g. Electronics, Beauty, etc."
                           class="input-field w-full bg-red-50 border-2 border-red-200 rounded-2xl px-6 py-4 text-[#0f172a] placeholder-slate-400 font-semibold outline-none focus:border-[#dc2626] transition text-sm">
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Description
                    </label>
                    <textarea name="description" 
                              rows="4" 
                              class="input-field w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 text-[#0f172a] placeholder-slate-400 font-semibold outline-none transition text-sm resize-none">{{ $product->description }}</textarea>
                </div>

                {{-- Current Images --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Current Images
                    </label>
                    <div class="flex gap-4 flex-wrap">
                        @foreach($product->images as $img)
                        <div class="image-card relative w-24 h-24 rounded-2xl overflow-hidden shadow-md group">
                            <img src="{{ asset('storage/' . $img->image_path) }}" 
                                 alt="Product image"
                                 class="w-full h-full object-cover">
                            <button type="button" 
                                    onclick="deleteImage({{ $img->id }})"
                                    class="delete-img-btn absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Add New Images --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 tracking-[0.2em] uppercase mb-3">
                        Add New Images
                    </label>
                    <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-[#dc2626] hover:bg-red-50/50 transition cursor-pointer" onclick="document.getElementById('fileInput').click()">
                        <input type="file" 
                               id="fileInput"
                               name="images[]" 
                               accept="image/*" 
                               multiple
                               class="hidden"
                               onchange="updateFileName(this)">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mx-auto mb-2 shadow-sm">
                            <i class="fa-solid fa-cloud-arrow-up text-[#dc2626] text-lg"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-600">Click to upload new images</p>
                        <p class="text-[10px] text-slate-400 mt-1" id="fileLabel">or drag and drop files here</p>
                    </div>
                </div>

                {{-- Update Button --}}
                <button type="submit" 
                        class="red-pill w-full bg-[#dc2626] hover:bg-[#b91c1c] text-white font-black py-4 rounded-full transition tracking-[0.1em] uppercase text-xs flex items-center justify-center gap-2 shadow-lg shadow-red-200">
                    <i class="fa-solid fa-rotate"></i>
                    Update Product
                </button>

            </form>

            {{-- Divider --}}
            <div class="my-8 border-t border-slate-100"></div>

            {{-- Delete Product Form --}}
            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                  onsubmit="return confirm('⚠️ WARNING: This will permanently delete this product.\n\nThis action cannot be undone. Continue?')">
                @csrf
                @method('DELETE')

                <button type="submit" 
                        class="red-pill w-full bg-[#0f172a] hover:bg-red-600 text-white font-black py-4 rounded-full transition tracking-[0.1em] uppercase text-xs flex items-center justify-center gap-2">
                    <i class="fa-solid fa-trash"></i>
                    Delete Product
                </button>
            </form>

            {{-- Back Link --}}
            <div class="mt-6 text-center">
                <a href="{{ route('seller.dash') }}" 
                   class="inline-flex items-center gap-2 text-slate-400 hover:text-[#dc2626] font-bold text-xs tracking-wider uppercase transition-colors">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back to Dashboard
                </a>
            </div>

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

    function deleteImage(imageId) {
        if (confirm('Delete this image?')) {
            // You can add AJAX call here to delete image without page reload
            // Or submit a form to a delete image route
            fetch(`/seller/images/${imageId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    }
</script>

</body>
</html>
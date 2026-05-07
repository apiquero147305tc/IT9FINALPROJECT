<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <style>
        body {
            font-family: sans-serif;
            background: #f3e3cb;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            max-width: 700px;
            margin: auto;
        }

        label {
            display:block;
            margin-top:10px;
            font-weight:bold;
        }

        input, select, textarea {
            width:100%;
            padding:10px;
            margin-top:5px;
            border:1px solid #ddd;
            border-radius:8px;
        }

        .images {
            display:flex;
            gap:10px;
            flex-wrap:wrap;
            margin-top:10px;
        }

        .img-box {
            position:relative;
            width:100px;
            height:100px;
        }

        .img-box img {
            width:100%;
            height:100%;
            object-fit:cover;
            border-radius:8px;
        }

        .delete-btn {
            position:absolute;
            top:5px;
            right:5px;
            background:red;
            color:white;
            border:none;
            border-radius:50%;
            width:22px;
            height:22px;
            cursor:pointer;
        }

        .btn {
            width:100%;
            padding:12px;
            margin-top:15px;
            border:none;
            border-radius:8px;
            cursor:pointer;
        }

        .update-btn {
            background:#ff4a00;
            color:white;
        }

        .delete-product-btn {
            background:black;
            color:white;
        }

        .back {
            display:block;
            margin-top:15px;
            text-align:center;
            text-decoration:none;
            color:#dd0d22;
            font-weight:bold;
        }
    </style>
</head>
<body>

<div class="card">

<h2>Edit Product</h2>

{{-- UPDATE FORM --}}
<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Name</label>
    <input type="text" name="name" value="{{ $product->name }}" required>

    <label>Price</label>
    <input type="number" name="price" value="{{ $product->price }}" required>

    <label>Stock</label>
    <input type="number" name="stock" value="{{ $product->stock }}" required>

    <label>Category</label>
    <select name="category" required>
        <option value="Cooking" {{ $product->category == 'Cooking' ? 'selected' : '' }}>Cooking</option>
        <option value="Household" {{ $product->category == 'Household' ? 'selected' : '' }}>Household</option>
        <option value="School Supplies" {{ $product->category == 'School Supplies' ? 'selected' : '' }}>School Supplies</option>
        <option value="Accessories" {{ $product->category == 'Accessories' ? 'selected' : '' }}>Accessories</option>
    </select>

    <label>Description</label>
    <textarea name="description">{{ $product->description }}</textarea>

   <label>Current Images</label>

<div class="images">
    @foreach($product->images as $img)
        <img src="{{ asset('storage/' . $img->image_path) }}"
             style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
    @endforeach
</div>

    <label>Add New Images</label>
    <input type="file" name="images[]" multiple>

    <button class="btn update-btn" type="submit">
        Update Product
    </button>
</form>

{{-- DELETE PRODUCT (SEPARATE FORM) --}}
<form action="{{ route('products.destroy', $product->id) }}" method="POST"
      onsubmit="return confirm('Delete this product?')">

    @csrf
    @method('DELETE')

    <button class="btn delete-product-btn" type="submit">
        Delete Product
    </button>
</form>

<a href="{{ route('seller.dash') }}" class="back">
    ← Back to Dashboard
</a>

</div>

</body>
</html>
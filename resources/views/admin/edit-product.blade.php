<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

<h1>Edit Product</h1>

<form method="POST" action="{{ route('admin.products.update', $product->id) }}">
    @csrf

    <label>Name</label>
    <input type="text" name="name" value="{{ $product->name }}">

    <label>Price</label>
    <input type="number" name="price" value="{{ $product->price }}">

    <label>Category</label>
    <input type="text" name="category" value="{{ $product->category }}">

    <button type="submit">Update</button>
</form>

</body>
</html>
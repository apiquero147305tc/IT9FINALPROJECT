<!DOCTYPE html>
<html>
<head>
    <title>Add Product | CraveCart</title>
    <style>
        body { background: #f3e3cb; font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        
        .card { 
            background: white; 
            padding: 30px; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 500px; 
        }

        h2 { color: #dd0d22; margin-bottom: 20px; text-align: center; font-size: 1.5rem; }

        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; font-size: 0.9rem; }

        input[type="text"], 
        input[type="number"], 
        select, 
        textarea { 
            width: 100%; 
            padding: 12px; 
            margin-bottom: 20px; 
            border: 2px solid #f3e3cb; 
            border-radius: 10px; 
            box-sizing: border-box; 
            outline: none;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus { border-color: #ff9b9e; }

        .row { display: flex; gap: 15px; }
        .col { flex: 1; }

        input[type="file"] { 
            margin-bottom: 20px; 
            font-size: 0.8rem; 
            color: #777; 
        }

        button { 
            background: #dd0d22; 
            color: white; 
            border: none; 
            width: 100%; 
            padding: 15px; 
            border-radius: 10px; 
            font-size: 1rem; 
            font-weight: bold; 
            cursor: pointer; 
            transition: background 0.3s, transform 0.2s;
        }

        button:hover { background: #ff4a00; transform: translateY(-2px); }

        .back-link { display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 0.8rem; }
        .back-link:hover { color: #dd0d22; }
    </style>
</head>
<body>

<div class="card">
    <h2>Add New Item</h2>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <label>Item Name</label>
        <input type="text" name="name" placeholder="e.g. Cooking Oil" required>

        <label>Category</label>
        <select name="category">
            <option value="Household">Household</option>
            <option value="Cooking">Cooking</option>
            <option value="School Supplies">School Supplies</option>
            <option value="Accesories">Accesories</option>
        </select>

        <div class="row">
            <div class="col">
                <label>Price (PHP)</label>
                <input type="number" name="price" step="0.01" placeholder="0.00" required>
            </div>
            <div class="col">
                <label>Stock Quantity</label>
                <input type="number" name="stock" required>
            </div>
        </div>

        <label>Item Description</label>
        <textarea name="description" rows="3" placeholder="Tell customers about your product..."></textarea>

        <label>Product Image</label>
        <input type="file" name="images[]" accept="image/*" multiple>

        <button type="submit">Upload to Shop</button>
        
        <a href="{{ route('seller.dash') }}" class="back-link">← Back to Dashboard</a>
    </form>
</div>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Admin | Product Management</title>

    <style>
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #333;
            color: white;
        }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            color: white;
        }

        .pending { background: orange; }
        .approved { background: green; }
        .rejected { background: red; }

        .btn {
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            margin-right: 5px;
            text-decoration: none;
        }

        .edit { background: #007bff; }
        .delete { background: #dc3545; }

        .alert {
            background: #28a745;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<h1>Product Management (Admin)</h1>

@if(session('success'))
    <div class="alert">
        {{ session('success') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($products as $product)

            @php
                $status = strtolower($product->status);
            @endphp

            <tr>
                <td>{{ $product->name }}</td>
                <td>₱{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->category ?? 'N/A' }}</td>

                <!-- ✅ FIXED STATUS LOGIC (handles "available") -->
                <td>
                    @if($status == 'approved')
                        <span class="status approved">Approved</span>

                    @elseif($status == 'pending')
                        <span class="status pending">Pending</span>

                    @elseif($status == 'available')
                        <span class="status pending">Pending</span>

                    @else
                        <span class="status rejected">Rejected</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn edit">
                        Edit
                    </a>

                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn delete" onclick="return confirm('Delete this product?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="6">No products found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
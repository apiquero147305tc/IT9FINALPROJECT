<!DOCTYPE html>
<html>
<head>
    <title>CraveCart | Product Moderation</title>
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
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #dd0d22;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .approve {
            background: #28a745;
        }

        .reject {
            background: #dc3545;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>
</head>
<body>

<h1>Product Moderation Panel</h1>

<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Seller</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($pendingProducts as $product)
            <tr>
                <td>{{ $product->name ?? 'N/A' }}</td>
                <td>{{ $product->seller_name ?? 'Unknown' }}</td>
                <td><strong>{{ $product->status }}</strong></td>
                <td>
                    <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn approve">Approve</button>
                    </form>

                    <form action="{{ route('admin.products.reject', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn reject">Reject</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="empty">No pending products</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
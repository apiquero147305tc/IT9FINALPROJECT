<!DOCTYPE html>
<html>
<head>
    <title>CraveCart | Admin Panel</title>

    <style>
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            color: white;
            text-decoration: none;
        }

        .btn-approve { background: #28a745; }
        .btn-reject { background: #dc3545; }

        .nav {
            margin-bottom: 30px;
        }

        .nav a {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            margin-right: 10px;
        }

        .nav .panel { background: #333; }
        .nav .requests { background: #007bff; }
        .nav .manage { background: #28a745; }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            color: white;
        }

        .pending { background: orange; }
        .approved { background: green; }
        .rejected { background: red; }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            color: white;
            border-radius: 5px;
        }

        .success { background: #28a745; }
        .error { background: #dc3545; }
    </style>
</head>

<body>

<h1>Admin Control Center</h1>

<!-- 🔔 ALERT MESSAGES -->
@if(session('success'))
    <div class="alert success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert error">
        {{ session('error') }}
    </div>
@endif

<!-- 📊 STATS -->
<div class="stats">
    <div class="stat-card">
        <h3>Sellers</h3>
        <p>{{ $totalSellers }}</p>
    </div>

    <div class="stat-card">
        <h3>Buyers</h3>
        <p>{{ $totalBuyers }}</p>
    </div>

    <div class="stat-card">
        <h3>Pending Requests</h3>
        <p>{{ count($pendingUsers ?? []) }}</p>
    </div>
</div>

<!-- 🔗 NAVIGATION -->
<div class="nav">
    <a href="/admin/products" class="requests">Product Requests</a>
    <a href="/admin/products/manage" class="manage">Manage Products</a>
</div>

<!-- 👤 USER APPROVAL TABLE -->
<h2>Pending User Approvals</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Requested Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($pendingUsers ?? [] as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><strong style="text-transform: capitalize;">{{ $user->role }}</strong></td>

                <td>
                    @if($user->status == 'pending')
                        <span class="status pending">🟡 Pending</span>
                    @elseif($user->status == 'approved')
                        <span class="status approved">🟢 Approved</span>
                    @else
                        <span class="status rejected">🔴 Rejected</span>
                    @endif
                </td>

                <td>
                    <form action="{{ route('admin.approve', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-approve">Approve</button>
                    </form>

                    <form action="{{ route('admin.reject', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-reject">Reject</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No pending users.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
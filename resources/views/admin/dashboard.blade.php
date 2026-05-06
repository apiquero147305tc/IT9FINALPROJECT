<!DOCTYPE html>
<html>
<head>
    <title>CraveCart | Admin Panel</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .stats { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; flex: 1; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; background: white; border-collapse: collapse; border-radius: 10px; overflow: hidden; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #dd0d22; color: white; }
        .btn { padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; color: white; }
        .btn-approve { background: #28a745; }
        .btn-reject { background: #dc3545; }
    </style>
</head>
<body>
    <form action="{{ route('logout') }}" method="POST" style="position:absolute; top:20px; right:20px;">
    @csrf
    <button type="submit"
        style="background:#dd0d22; color:white; border:none; padding:8px 12px; border-radius:6px; cursor:pointer;">
        Logout
    </button>
</form>

    <h1>Admin Control Center</h1>

    <div class="stats">
        <div class="stat-card"><h3>Sellers</h3><p>{{ $totalSellers }}</p></div>
        <div class="stat-card"><h3>Buyers</h3><p>{{ $totalBuyers }}</p></div>
        <div class="stat-card"><h3>Pending Requests</h3><p>{{ $pendingUsers->count() }}</p></div>
    </div>

    <h2>Pending User Approvals</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Requested Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingUsers as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><strong style="text-transform: capitalize;">{{ $user->role }}</strong></td>
                <td>
                    <form action="{{ route('admin.approve', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-approve"
                            onclick="return confirm('Approve this user?')">
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('admin.reject', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-reject"
                            onclick="return confirm('Reject this user?')">
                            Reject
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Product; 

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::where('role', '!=', 'admin')
                ->latest()
                ->get();

        $totalSellers = User::where('role', 'seller')->count();
        $totalBuyers = User::where('role', 'buyer')->count();

// ✅ FIXED: use status instead of is_approved
    $pendingUsers = User::where('role', 'seller')
        ->where('status', 'pending')
        ->latest()
        ->get();

    $approvedSellers = User::where('role', 'seller')
        ->where('status', 'approved')
        ->count();

    $rejectedSellers = User::where('role', 'seller')
        ->where('status', 'rejected')
        ->count();

        $complaints = Complaint::latest()->get();

        return view('admin.dashboard', compact(
            'users',
            'totalSellers',
            'totalBuyers',
            'pendingUsers',
            'complaints'
        ));
    }

    // APPROVE SELLER
   public function approveUser($id)
{
    $user = User::findOrFail($id);

    $user->status = 'approved';
    $user->save();

    return back()->with('success', "{$user->name} approved successfully.");
}

    // REJECT SELLER
    public function rejectUser($id)
{
    $user = User::findOrFail($id);

    $user->status = 'rejected';
    $user->save();

    return back()->with('error', "{$user->name} rejected successfully.");
}

    // BLOCK USER
    public function block($id)
{
    $user = User::findOrFail($id);
    $user->is_blocked = 1;
    $user->save();

    return back()->with('success', 'User blocked successfully');
}

public function unblock($id)
{
    $user = User::findOrFail($id);
    $user->is_blocked = 0;
    $user->save();

    return back()->with('success', 'User unblocked successfully');
}

           public function allUsers()
{
    $users = User::where('role', '!=', 'admin')
                ->latest()
                ->get();

    return view('admin.users', compact('users'));
}

        public function sellers()
        {
            $users = User::where('role', 'seller')->latest()->get();

            return view('admin.sellers', compact('users'));
        }

        public function buyers()
        {
            $users = User::where('role', 'buyer')->latest()->get();

            return view('admin.buyers', compact('users'));
        }

        public function blockedUsers()
{
    $users = User::where('is_blocked', 1)
                ->where('role', '!=', 'admin')
                ->latest()
                ->get();

    return view('admin.blocked', compact('users'));
}

public function settings()
{
    $admin = Auth::user();

    return view('admin.settings', compact('admin'));
}

public function updateSettings(Request $request)
{
   $admin = User::find(Auth::id());

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'nullable|min:6|confirmed'
    ]);

    $admin->name = $request->name;
    $admin->email = $request->email;

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    $admin->save();

    return back()->with('success', 'Settings updated successfully.');
}

public function analytics()
{
    $users = User::all();

    $data = [
        'totalUsers' => $users->count(),
        'sellers' => $users->where('role', 'seller')->count(),
        'buyers' => $users->where('role', 'buyer')->count(),
        'blocked' => $users->where('is_blocked', 1)->count(),
    ];

    return view('admin.analytics', $data);
}


public function destroyUser($id)
{
    $user = User::findOrFail($id);

    // safety check: never delete admin
    if ($user->role === 'admin') {
        return back()->with('error', 'Admin account cannot be deleted.');
    }

    $user->delete();

    return back()->with('success', 'User deleted successfully.');
}

public function deleteUsersPage()
{
    $users = User::where('role', '!=', 'admin')->get();

    return view('admin.delete-users', compact('users'));
}
}
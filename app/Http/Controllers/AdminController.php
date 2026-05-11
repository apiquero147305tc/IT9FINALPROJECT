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

        $pendingUsers = User::where('role', 'seller')
            ->where('is_approved', false)
            ->get();

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

        $user->is_approved = true;
        $user->save();

        return back()->with('success', "{$user->name} approved successfully.");
    }

    // REJECT SELLER
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);

        $user->delete(); // fully remove account

        return back()->with('error', "{$user->name} rejected and removed.");
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
}
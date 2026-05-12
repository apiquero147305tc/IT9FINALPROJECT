<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema; // Required for table check
use App\Models\Product; 

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch non-admin users for the general table
        $users = User::where('role', '!=', 'admin')
                ->latest()
                ->take(10) // Limit to 10 for dashboard performance
                ->get();

        $totalSellers = User::where('role', 'seller')->count();
        $totalBuyers = User::where('role', 'buyer')->count();

        // ✅ SELLER STATUS LOGIC
        $pendingUsers = User::where('role', 'seller')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $approvedSellersCount = User::where('role', 'seller')
            ->where('status', 'approved')
            ->count();

        $rejectedSellersCount = User::where('role', 'seller')
            ->where('status', 'rejected')
            ->count();

        /**
         * ✅ SAFETY FALLBACK: Complaints
         * If the 'complaints' table doesn't exist, we return an empty collection
         * to prevent the "Base table or view not found" error.
         */
        $complaints = Schema::hasTable('complaints') 
                      ? Complaint::latest()->get() 
                      : collect();

        return view('admin.dashboard', compact(
            'users',
            'totalSellers',
            'totalBuyers',
            'pendingUsers',
            'approvedSellersCount',
            'rejectedSellersCount',
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

    // BLOCK/UNBLOCK LOGIC
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

    // USER VIEW LOGIC
    public function allUsers()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
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

    // SETTINGS & PROFILE
    public function settings()
    {
        return view('admin.settings', ['admin' => Auth::user()]);
    }

    public function updateSettings(Request $request)
    {
        $admin = User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$admin->id,
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

    // ANALYTICS ENGINE
    public function analytics()
    {
        $data = [
            'totalUsers' => User::where('role', '!=', 'admin')->count(),
            'sellers' => User::where('role', 'seller')->count(),
            'buyers' => User::where('role', 'buyer')->count(),
            'blocked' => User::where('is_blocked', 1)->count(),
        ];

        return view('admin.analytics', $data);
    }

    // ACCOUNT DELETION
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Critical: Admin account cannot be deleted.');
        }

        $user->delete();
        return back()->with('success', 'Account successfully purged from system.');
    }

    public function deleteUsersPage()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.delete-users', compact('users'));
    }
}
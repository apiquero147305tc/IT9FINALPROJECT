<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * ADMIN DASHBOARD
     * Resolves the "undefined method" error from image_cb6322.png.
     */
    public function dashboard()
    {
        $stats = [
            'pending_users'    => User::where('status', 'pending')->count(),
            'total_products'   => Product::count(),
            'total_complaints' => Complaint::where('status', 'open')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * ANALYTICS ENGINE
     * Provides a breakdown of user types and status.
     */
    public function analytics()
    {
        $data = [
            'totalUsers' => User::where('role', '!=', 'admin')->count(),
            'sellers'    => User::where('role', 'seller')->count(),
            'buyers'     => User::where('role', 'buyer')->count(),
            'blocked'    => User::where('is_blocked', 1)->count(),
        ];

        return view('admin.analytics', $data);
    }

    /**
     * DELETE USERS PAGE
     * Lists all non-admin users for management.
     */
    public function deleteUsersPage()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.delete-users', compact('users'));
    }

    /**
     * ACCOUNT DELETION
     * Purges a user from the database.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Security check: Prevent accidental admin suicide
        if ($user->role === 'admin') {
            return back()->with('error', 'Critical: Admin account cannot be deleted.');
        }

        try {
            $user->delete();
            return back()->with('success', 'Account successfully purged from system.');
        } catch (\Exception $e) {
            // Catches foreign key constraint violations
            return back()->with('error', 'Deletion failed: User has active listings or reports that must be handled first.');
        }
    }

    /**
     * VIEW SELLER ID
     * View the ID/Documents uploaded by a seller for verification.
     */
    public function viewId($id)
    {
        $user = User::findOrFail($id);
        return view('admin.view-id', compact('user'));
    }
}
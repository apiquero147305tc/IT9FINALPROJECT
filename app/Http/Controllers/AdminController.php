<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard with pending approval requests.
     */
    public function dashboard()
    {
        // Fetch users waiting for approval
        $pendingUsers = User::where('status', 'pending')->latest()->get();
        
        // Basic stats for the dashboard overview
        $totalSellers = User::where('role', 'seller')->count();
        $totalBuyers = User::where('role', 'buyer')->count();

        return view('admin.dashboard', compact('pendingUsers', 'totalSellers', 'totalBuyers'));
    }

    /**
     * Approve a user so they can log in and use their dashboard.
     */
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved'; // Change status from pending to approved
        $user->save();

        return back()->with('success', "User {$user->name} has been approved!");
    }

    /**
     * Reject a user if they do not meet campus requirements.
     */
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected'; // Mark as rejected
        $user->save();

        return back()->with('error', "User {$user->name} was rejected.");
    }
}
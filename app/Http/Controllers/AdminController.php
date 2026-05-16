<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Report;


class AdminController extends Controller
{
    public function reports()
    {
        $reports = Report::latest()->get();
    
        return view('admin.reports', compact('reports'));
    }
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

    // safety check (optional but good)
    if ($user->status === 'approved') {
        return back()->with('error', 'User already approved.');
    }

    $user->status = 'approved';
    $user->save();

    return back()->with('success', "{$user->name} has been approved!");
}

public function rejectUser($id)
{
    $user = User::findOrFail($id);

    $user->status = 'rejected';
    $user->save();

    return back()->with('error', "{$user->name} was rejected.");
}
}
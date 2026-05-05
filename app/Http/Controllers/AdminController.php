<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingUsers = User::where('status', 'pending')
            ->where('role', '!=', 'admin')
            ->latest()
            ->get();

        $totalSellers = User::where('role', 'seller')
            ->where('status', 'approved')
            ->count();

        $totalBuyers = User::where('role', 'buyer')
            ->where('status', 'approved')
            ->count();

        return view('admin.dashboard', compact(
            'pendingUsers',
            'totalSellers',
            'totalBuyers'
        ));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);

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
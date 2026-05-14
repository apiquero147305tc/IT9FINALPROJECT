<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Complaint;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    //////////////////////////////////////////////////
    // DASHBOARD
    //////////////////////////////////////////////////
    public function dashboard()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();

        return view('admin.dashboard', [
            'users' => $users,
            'totalSellers' => User::where('role', 'seller')->count(),
            'totalBuyers' => User::where('role', 'buyer')->count(),
            'pendingUsers' => User::where('role', 'seller')->where('status', 'pending')->get(),
            'complaints' => Complaint::latest()->get(),
        ]);
    }

    //////////////////////////////////////////////////
    // USER MANAGEMENT
    //////////////////////////////////////////////////
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

    //////////////////////////////////////////////////
    // APPROVAL SYSTEM
    //////////////////////////////////////////////////
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        return back();
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

        return back();
    }

    //////////////////////////////////////////////////
    // BLOCK SYSTEM
    //////////////////////////////////////////////////
    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = 1;
        $user->save();

        return back();
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = 0;
        $user->save();

        return back();
    }

    //////////////////////////////////////////////////
    // SETTINGS
    //////////////////////////////////////////////////
    public function settings()
    {
        return view('admin.settings', [
            'admin' => Auth::user()
        ]);
    }

    public function updateSettings(Request $request) { $admin = User::find(Auth::id()); $request->validate([ 'name' => 'required', 'email' => 'required|email', 'password' => 'nullable|min:6|confirmed' ]); $admin->name = $request->name; $admin->email = $request->email; if ($request->filled('password')) { $admin->password = Hash::make($request->password); } $admin->save(); return back()->with('success', 'Settings updated successfully.'); }

    //////////////////////////////////////////////////
    // ANALYTICS
    //////////////////////////////////////////////////
    public function analytics()
    {
        $users = User::all();

        return view('admin.analytics', [
            'totalUsers' => $users->count(),
            'sellers' => $users->where('role', 'seller')->count(),
            'buyers' => $users->where('role', 'buyer')->count(),
            'blocked' => $users->where('is_blocked', 1)->count(),
        ]);
    }

    //////////////////////////////////////////////////
    // DELETE USERS
    //////////////////////////////////////////////////
    public function deleteUsersPage()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.delete-users', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back();
        }

        $user->delete();

        return back();
    }

    //////////////////////////////////////////////////
    // VIEW ID
    //////////////////////////////////////////////////
    public function viewId($id)
    {
        $user = User::findOrFail($id);
        return view('admin.view-id', compact('user'));
    }

    //////////////////////////////////////////////////
    // EMAIL SYSTEM
    //////////////////////////////////////////////////
    public function emailPage($id)
    {
        $user = User::findOrFail($id);
        return view('admin.email-compose', compact('user'));
    }

    public function sendEmail(Request $request, $id)
    {
        $user = User::findOrFail($id);

        Notification::create([
            'user_id' => $user->id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        Mail::raw($request->message, function ($mail) use ($user, $request) {
            $mail->to($user->email)
                ->subject($request->subject);
        });

        return back();
    }

    //////////////////////////////////////////////////
    // MESSAGES / CHAT
    //////////////////////////////////////////////////

    // INBOX (NO $user HERE)
    public function messages()
{
    $users = User::whereIn('role', ['buyer', 'seller'])->latest()->get();
    $complaints = Complaint::latest()->get();

    return view('admin.messages', compact('users', 'complaints'));
}

    // CHAT (HAS $user)
    public function adminChat($id)
{
    $user = User::findOrFail($id);

    $messages = Message::where(function ($q) use ($user) {
        $q->where('sender_id', Auth::id())
          ->where('receiver_id', $user->id);
    })
    ->orWhere(function ($q) use ($user) {
        $q->where('sender_id', $user->id)
          ->where('receiver_id', Auth::id());
    })
    ->orderBy('created_at')
    ->get();

    return view('admin.chat', compact('user', 'messages'));
}
}
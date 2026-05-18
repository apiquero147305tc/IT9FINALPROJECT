<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Complaint;
use App\Models\Message;
use App\Models\Notification;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    //////////////////////////////////////////////////
    // 📊 DASHBOARD
    //////////////////////////////////////////////////
    public function dashboard()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();

        $totalSellers = User::where('role', 'seller')->count();
        $totalBuyers  = User::where('role', 'buyer')->count();

        $pendingSellers = User::where('role', 'seller')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $complaints = Complaint::latest()->get();
        $contacts = ContactMessage::latest()->get();
        $unreadContacts = ContactMessage::where('is_read', false)->count();

        return view('admin.dashboard', compact(
            'users',
            'totalSellers',
            'totalBuyers',
            'pendingSellers',
            'complaints',
            'contacts',
            'unreadContacts'
        ));
    }

    //////////////////////////////////////////////////
    // 👥 USER MANAGEMENT
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
    // ✅ APPROVAL SYSTEM
    //////////////////////////////////////////////////
   public function approveUser($id)
{
    $user = User::findOrFail($id);

    if ($user->role === 'seller') {
        $user->status = 'approved';
    } else {
        $user->status = 'approved';
    }

    $user->save();

    return back()->with('success', 'User approved successfully.');
}

    public function rejectUser($id)
    {
        User::findOrFail($id)->update(['status' => 'rejected']);
        return back();
    }

    //////////////////////////////////////////////////
    // 🚫 BLOCK SYSTEM
    //////////////////////////////////////////////////
    public function block($id)
    {
        User::findOrFail($id)->update(['is_blocked' => 1]);
        return back();
    }

    public function unblock($id)
    {
        User::findOrFail($id)->update(['is_blocked' => 0]);
        return back();
    }

    //////////////////////////////////////////////////
    // ⚙️ SETTINGS
    //////////////////////////////////////////////////
    public function settings()
    {
        return view('admin.settings', [
            'admin' => Auth::user()
        ]);
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

    //////////////////////////////////////////////////
    // 📈 ANALYTICS
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
    // 🗑 DELETE USERS
    //////////////////////////////////////////////////
    public function deleteUsersPage()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.delete-users', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'admin') {
            $user->delete();
        }

        return back();
    }

    //////////////////////////////////////////////////
    // 🪪 VIEW ID
    //////////////////////////////////////////////////
    public function viewId($id)
    {
        $user = User::findOrFail($id);
        return view('admin.view-id', compact('user'));
    }

    //////////////////////////////////////////////////
    // 📧 EMAIL SYSTEM
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
    // 💬 ADMIN MESSAGES
    //////////////////////////////////////////////////
    public function messages()
    {
        $users = User::whereIn('role', ['buyer', 'seller'])->latest()->get();
        $complaints = Complaint::latest()->get();

        return view('admin.messages', compact('users', 'complaints'));
    }

    public function adminChat($id)
    {
        $authId = Auth::id();

        $users = User::where('role', '!=', 'admin')->get();
        $user = User::findOrFail($id);

        $messages = Message::where(function ($q) use ($authId, $id) {
                $q->where('sender_id', $authId)
                  ->where('receiver_id', $id);
            })
            ->orWhere(function ($q) use ($authId, $id) {
                $q->where('sender_id', $id)
                  ->where('receiver_id', $authId);
            })
            ->orderBy('created_at')
            ->get();

        return view('admin.messages', compact('users', 'user', 'messages'));
    }

    //////////////////////////////////////////////////
    // 📩 CONTACT SYSTEM
    //////////////////////////////////////////////////
    public function contacts()
    {
        $contacts = ContactMessage::latest()->get();
        return view('admin.contacts', compact('contacts'));
    }

    public function markAsRead($id)
    {
        ContactMessage::findOrFail($id)->update([
            'is_read' => true
        ]);

        return back();
    }
}
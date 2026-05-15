<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
   public function chat(int $userId)
{
    $authId = Auth::id();

    $receiver = User::findOrFail($userId);

    $messages = Message::where(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $authId)
              ->where('receiver_id', $userId);
        })
        ->orWhere(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', $authId);
        })
        ->orderBy('created_at')
        ->get();

    return view('messages.chat', compact('messages', 'receiver'));
}

    public function send(Request $request)
    {
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return back();
    }

  public function inbox()
{
    $authId = Auth::id();

    $conversations = Message::where('sender_id', $authId)
        ->orWhere('receiver_id', $authId)
        ->latest()
        ->get()
        ->groupBy(function ($msg) use ($authId) {
            return $msg->sender_id == $authId
                ? $msg->receiver_id
                : $msg->sender_id;
        });

    $users = [];

    foreach ($conversations as $userId => $msgs) {
        $user = User::find($userId);

        if (!$user) continue;

        $users[] = [
            'user' => $user,
            'last_message' => $msgs->first()
        ];
    }

    return view('messages.inbox', compact('users'));
}

public function fetchMessages($userId)
{
    $authId = Auth::id();

    $messages = Message::where(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $authId)
              ->where('receiver_id', $userId);
        })
        ->orWhere(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', $authId);
        })
        ->orderBy('created_at')
        ->get();

    return view('messages.partials.chat-body', compact('messages', 'userId'));
}

public function sellerInbox()
{
    $authId = Auth::id();

    $conversations = Message::where('sender_id', $authId)
        ->orWhere('receiver_id', $authId)
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function ($msg) use ($authId) {
            return $msg->sender_id == $authId
                ? $msg->receiver_id
                : $msg->sender_id;
        });

    $users = [];

    foreach ($conversations as $userId => $msgs) {
        $users[] = [
            'user' => User::find($userId),
            'last_message' => $msgs->first()
        ];
    }

    return view('messages.seller-inbox', compact('users'));
}

public function adminInbox()
{
    $users = User::where('role', '!=', 'admin')
        ->latest()
        ->get();

    return view('admin.messages', compact('users'));
}

public function adminChat($id)
{
    $authId = Auth::id();

    // always required for sidebar
    $users = User::where('role', '!=', 'admin')->get();

    // selected user
    $user = User::findOrFail($id);

    // messages between admin and selected user
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


}
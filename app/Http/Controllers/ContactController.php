<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

public function send(Request $request)
{
    ContactMessage::create([
       'user_id' => Auth::id(),
        'name' => $request->name,
        'email' => $request->email,
        'message' => $request->message,
        'type' => 'report', 
        'is_read' => false,
    ]);

    return back()->with('success', 'Message sent successfully!');
}

}

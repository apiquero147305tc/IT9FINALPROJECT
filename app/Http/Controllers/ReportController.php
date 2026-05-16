<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactMessage;


class ReportController extends Controller
{
    public function store(Request $request)
    {
          ContactMessage::create([
        'user_id' => Auth::id(),
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'message' => $request->reason,
        'type' => 'report',
        'is_read' => false,
    ]);

    return back()->with('success', 'Report sent to admin.');
    }
}

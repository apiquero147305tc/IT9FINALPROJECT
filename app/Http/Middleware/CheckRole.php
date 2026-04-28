<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = strtolower(trim(Auth::user()->role));
        $requiredRole = strtolower(trim($role));

        // 1. If role matches, proceed
        if ($userRole === $requiredRole) {
            return $next($request);
        }

        // 2. Prevent loops: If they are in the wrong spot, send them to their right dashboard
        if ($userRole === 'seller' && !$request->is('seller*')) {
            return redirect()->route('seller.dashboard');
        }

        if ($userRole === 'buyer' && !$request->is('buyer*')) {
            return redirect()->route('buyer.dashboard');
        }

        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
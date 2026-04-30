<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Added this
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  <-- Added this parameter
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Check if the user's role matches the required role (e.g., 'seller')
        // We use strtolower to prevent errors if the DB has 'Seller' vs 'seller'
        if (strtolower(Auth::user()->role) !== strtolower($role)) {
            
            // Redirect based on what they actually are
            if (Auth::user()->role === 'seller') {
                return redirect()->route('seller.dash');
            }
            
            return redirect('/home')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
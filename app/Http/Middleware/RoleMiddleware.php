<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. AUTHENTICATION CHECK
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = strtolower($user->role ?? '');
        $requiredRole = strtolower($role);

        // 2. SECURITY CHECK: BLOCKED STATUS
        // Checks both is_blocked boolean and status string for safety
        if ($user->is_blocked || $user->status === 'blocked') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect to a specific blocked page if it exists, otherwise login
            return Route::has('blocked') 
                ? redirect()->route('blocked') 
                : redirect()->route('login')->withErrors(['email' => 'Your account has been suspended.']);
        }

        // 3. ACCOUNT STATUS CHECK: PENDING APPROVAL
        // We bypass this for Admins. If a non-admin is pending, redirect them.
        if ($userRole !== 'admin' && $user->status === 'pending') {
            if (!$request->routeIs('pending')) {
                return redirect()->route('pending');
            }
            return $next($request);
        }

        // 4. ROLE-BASED ACCESS CONTROL (RBAC)
        // Admins are granted "God Mode" and can bypass specific role requirements.
        if ($userRole !== 'admin' && $userRole !== $requiredRole) {
            // Check if they are already headed to the pending page to avoid loops
            if ($request->routeIs('pending')) {
                return $next($request);
            }
            
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
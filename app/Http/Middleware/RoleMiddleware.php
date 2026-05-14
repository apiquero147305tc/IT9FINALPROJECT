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

        // 2. SECURITY CHECK: BLOCKED STATUS
        if ($user->is_blocked) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['email' => 'Your account has been suspended.']);
        }

        // 3. ACCOUNT STATUS CHECK: PENDING APPROVAL
        // We bypass this check if the user is an admin or is already headed to the pending page.
        if ($user->role !== 'admin' && $user->status === 'pending') {
            if (!$request->routeIs('pending')) {
                return redirect()->route('pending');
            }
            return $next($request);
        }

        // 4. ROLE-BASED ACCESS CONTROL (RBAC)
        $userRole = strtolower($user->role ?? '');
        $requiredRole = strtolower($role);

        // Admins are granted "God Mode" and can bypass role checks.
        // Otherwise, the user role must match the requirement.
        if ($userRole !== 'admin' && $userRole !== $requiredRole) {
            // Safety: Don't abort if they are already on the pending page
            if (!$request->routeIs('pending')) {
                abort(403, 'Unauthorized access.');
            }
        }

        return $next($request);
    }
}
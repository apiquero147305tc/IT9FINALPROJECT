<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // 1. AUTHENTICATION CHECK
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = strtolower($user->role ?? '');
        $requiredRole = strtolower($role);

        // 2. SECURITY CHECK: BLOCKED STATUS
        if ($user->is_blocked || $user->status === 'blocked') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Route::has('blocked')
                ? redirect()->route('blocked')
                : redirect()->route('login')->withErrors(['email' => 'Your account has been suspended.']);
        }

        // 3. ACCOUNT STATUS CHECK: PENDING APPROVAL
        // Allow sellers to access their pending page while logged in
        if ($userRole !== 'admin' && $user->status === 'pending') {
            // Allow access to seller-specific pending page and self-approve/delete routes
            if ($request->routeIs('seller.pending') || 
                $request->routeIs('seller.self-approve') || 
                $request->routeIs('seller.delete-account')) {
                return $next($request);
            }
            // Allow access to generic pending page
            if ($request->routeIs('auth.pending')) {
                return $next($request);
            }
            // For sellers, redirect to seller.pending instead of generic pending
            if ($userRole === 'seller') {
                return redirect()->route('seller.pending');
            }
            // For others, use generic pending
            return redirect()->route('auth.pending');
        }

        // 4. Handle approved sellers - let them access confirmation page
        if ($userRole === 'seller' && $user->status === 'approved') {
            if ($request->routeIs('seller.confirm') || 
                $request->routeIs('seller.confirm.yes') || 
                $request->routeIs('seller.confirm.no')) {
                return $next($request);
            }
            return redirect()->route('seller.confirm');
        }

        // 5. ROLE-BASED ACCESS CONTROL (RBAC)
        // Admins are granted "God Mode" and can bypass specific role requirements.
        if ($userRole !== 'admin' && $userRole !== $requiredRole) {
            // Check if they are already headed to the pending page to avoid loops
            if ($request->routeIs('auth.pending') || $request->routeIs('seller.pending')) {
                return $next($request);
            }

            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
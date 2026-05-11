<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $userRole = strtolower($user->role ?? '');
        $requiredRole = strtolower($role);

        // 1. BLOCK ACCESS IF ROLE DOES NOT MATCH
        if ($userRole !== $requiredRole) {
            abort(403, 'Unauthorized access');
        }

        // 2. BLOCK IF USER IS BLOCKED (IMPORTANT FOR ADMIN SYSTEM)
        if ($user->is_blocked) {
            Auth::logout();
            abort(403, 'Your account has been blocked by admin.');
        }

        // 3. SELLER APPROVAL CHECK (ONLY FOR SELLERS)
        if ($userRole === 'seller' && !$user->is_approved) {
            Auth::logout();
            abort(403, 'Your seller account is pending admin approval.');
        }

        return $next($request);
    }
}
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
        // =========================
        // 1. CHECK LOGIN
        // =========================
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $userRole = strtolower($user->role ?? '');
        $requiredRole = strtolower($role);

        // =========================
        // 2. ROLE CHECK
        // =========================
        if ($userRole !== $requiredRole) {
            abort(403, 'Unauthorized access');
        }

        // =========================
        // 3. BLOCKED USER CHECK
        // =========================
        if ($user->status === 'blocked') {
            abort(403, 'Your account has been blocked by admin.');
        }

        // =========================
        // 4. SELLER APPROVAL CHECK
        // =========================
        if (
            $userRole === 'seller' &&
            $user->status !== 'approved' &&
            !$request->routeIs('pending')
        ) {
            return redirect()->route('pending');
        }

        return $next($request);
    }
}
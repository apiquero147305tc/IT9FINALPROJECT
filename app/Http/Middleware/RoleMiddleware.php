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
        // 1. Not logged in → go to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Normalize roles
        $userRole = strtolower($user->role);
        $requiredRole = strtolower($role);

        // 3. Role mismatch → block access
        if ($userRole !== $requiredRole) {
            return redirect('/home')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
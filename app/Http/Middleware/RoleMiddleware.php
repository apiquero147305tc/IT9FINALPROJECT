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
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    // normalize role
    $userRole = strtolower($user->role);
    $requiredRole = strtolower($role);

    // STRICT ROLE CHECK ONLY
    if ($userRole !== $requiredRole) {
        return redirect('/home')->with('error', 'Unauthorized access.');
    }

    return $next($request);
}
}
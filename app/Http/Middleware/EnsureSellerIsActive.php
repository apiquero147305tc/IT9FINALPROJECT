<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureSellerIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if user is a seller
        if ($user->role !== 'seller') {
            return redirect()->route('home')->with('error', 'Access denied.');
        }

        // Check seller status
        if ($user->status === 'pending') {
            return redirect()->route('seller.pending')
                ->with('info', 'Your account is pending admin approval.');
        }

        if ($user->status === 'approved') {
            return redirect()->route('seller.confirm')
                ->with('info', 'Please confirm your seller registration.');
        }

        if ($user->status !== 'active') {
            return redirect()->route('home')
                ->with('error', 'Your seller account is not active.');
        }

        return $next($request);
    }
}
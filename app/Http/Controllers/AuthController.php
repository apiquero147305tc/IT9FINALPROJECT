<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage() { return view('auth.login'); }
    public function registerPage() { return view('auth.register'); }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:buyer,seller',
            'grade_level' => 'required_if:role,buyer', 
            'monthly_budget' => 'required_if:role,buyer',
            'custom_budget' => 'required_if:monthly_budget,others|nullable|numeric',
        ]);

        $finalBudget = $request->monthly_budget;
        if ($request->monthly_budget === 'others' && $request->filled('custom_budget')) {
            $finalBudget = "₱" . $request->custom_budget;
        }

        // Creating the User with 'pending' status by default
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'pending', // New users start as pending
            'grade_level' => $request->role === 'buyer' ? $request->grade_level : null,
            'monthly_budget' => $request->role === 'buyer' ? $finalBudget : null,
        ]);

        // IMPORTANT: We do NOT auto-login here anymore because they need approval
        return redirect()->route('login')->with('success', 'Registration successful! Please wait for Admin approval before logging in.');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user is approved or is an admin
            if ($user->status !== 'approved' && !$user->isAdmin()) {
                Auth::logout(); // Log them out immediately
                return back()->withErrors(['email' => 'Your account is pending admin approval. Please try again later.']);
            }

            $request->session()->regenerate();
            return $this->redirectUserBasedOnRole($user);
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    /**
     * Helper to keep redirect logic in one place
     */
    private function redirectUserBasedOnRole($user) {
        if ($user->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }
        
        if ($user->isSeller()) {
            return redirect()->intended('/seller/dashboard');
        }
        
        return redirect()->intended('/home');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
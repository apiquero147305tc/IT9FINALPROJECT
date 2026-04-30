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
            // Added validation for the dropdowns
            'grade_level' => 'required_if:role,buyer', 
            'monthly_budget' => 'required_if:role,buyer',
            'custom_budget' => 'required_if:monthly_budget,others|nullable|numeric',
        ]);

        // Clean up the budget string for the database
        $finalBudget = $request->monthly_budget;
        if ($request->monthly_budget === 'others' && $request->filled('custom_budget')) {
            $finalBudget = "₱" . $request->custom_budget; // Standardizing the format
        }

        // Creating the User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Securely hashing
            'role' => $request->role,
            'grade_level' => $request->role === 'buyer' ? $request->grade_level : null,
            'monthly_budget' => $request->role === 'buyer' ? $finalBudget : null,
        ]);

        // Auto-login the user after registration so they don't have to log in again
        Auth::login($user);

        // Use the same redirect logic as login
        return $this->redirectUserBasedOnRole($user);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectUserBasedOnRole(Auth::user());
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    /**
     * Helper to keep redirect logic in one place
     */
    private function redirectUserBasedOnRole($user) {
        // Using your isSeller() and isBuyer() helpers from the User Model
        if ($user->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }
        
        if ($user->isSeller()) {
            return redirect()->intended('/seller/dashboard');
        }
        
        // Buyers go to the shop home
        return redirect()->intended('/home');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
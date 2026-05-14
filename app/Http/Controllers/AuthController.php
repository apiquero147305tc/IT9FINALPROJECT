<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function loginPage()
    {
        return view('auth.login');
    }

    /**
     * Show the registration page with a default role.
     */
    public function registerPage(Request $request)
    {
        return view('auth.register', [
            'role' => $request->role ?? 'buyer'
        ]);
    }

    /**
     * Unified Registration for both Buyers and Sellers.
     */
    public function register(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:buyer,seller',
        ];

        if ($request->role === 'buyer') {
            $rules['grade_level']    = 'required|string';
            $rules['monthly_budget'] = 'required|string';
            $rules['custom_budget']  = 'required_if:monthly_budget,others|nullable|numeric';
        } else {
            $rules['shop_name']      = 'required|string|max:255';
            $rules['age']             = 'required|numeric|min:18';
            $rules['contact_number'] = 'required|digits:11';
            $rules['valid_id']       = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $request->validate($rules);

        $filePath = null;
        if ($request->hasFile('valid_id')) {
            $filePath = $request->file('valid_id')->store('valid_ids', 'public');
        }

        $finalBudget = $request->monthly_budget;
        if ($request->monthly_budget === 'others' && $request->filled('custom_budget')) {
            $finalBudget = "₱" . number_format($request->custom_budget, 2);
        }

        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => $request->role,
            'status'         => 'pending', 
            'grade_level'    => $request->grade_level,
            'monthly_budget' => $finalBudget,
            'shop_name'      => $request->shop_name,
            'contact_number' => $request->contact_number,
            'age'            => $request->age,
            'valid_id'       => $filePath,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please wait for admin approval.');
    }

    /**
     * Handle Login Attempts.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if account is blocked
            if ($user->is_blocked) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been suspended.']);
            }

            // Check for admin approval (mainly for sellers)
            if ($user->status !== 'approved') {
                Auth::logout();
                return redirect()->route('pending')->withErrors([
                    'email' => 'Your account is currently waiting for admin approval.'
                ]);
            }

            $request->session()->regenerate();
            return $this->redirectUserBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Helper to route users after successful login.
     */
    private function redirectUserBasedOnRole($user)
    {
        return match ($user->role) {
            'admin'  => redirect('/admin/dashboard'),
            'seller' => redirect('/seller/dashboard'),
            default  => redirect()->route('buyer.home'),
        };
    }

    /**
     * Handle Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Show the pending approval view.
     */
    public function pending()
    {
        return view('auth.pending');
    }
}
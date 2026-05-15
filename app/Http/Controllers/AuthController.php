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
     * Show the Role Selection page.
     */
    public function showChooseRole()
    {
        return view('auth.chooseRole');
    }

    /**
     * Show Buyer Registration Form.
     * Matches route: buyer.register
     */
    public function showBuyerRegister()
    {
        return view('auth.register', ['role' => 'buyer']);
    }

    /**
     * Show Seller Registration Form.
     * Matches route: seller.register
     */
    public function showSellerRegister()
    {
        return view('auth.register', ['role' => 'seller']);
    }

    /**
     * Unified Registration Logic for both Buyers and Sellers.
     */
    public function register(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:buyer,seller',
        ];

        // Conditional Validation based on Role
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

        // Handle File Upload for Sellers
        $filePath = null;
        if ($request->hasFile('valid_id')) {
            $filePath = $request->file('valid_id')->store('valid_ids', 'public');
        }

        // Format Budget String
        $finalBudget = $request->monthly_budget;
        if ($request->monthly_budget === 'others' && $request->filled('custom_budget')) {
            $finalBudget = "₱" . number_format($request->custom_budget, 2);
        }

        // Create the User
        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => $request->role,
            // Logic: Buyers are approved by default; Sellers need admin review
            'status'         => $request->role === 'buyer' ? 'approved' : 'pending', 
            'grade_level'    => $request->grade_level,
            'monthly_budget' => $finalBudget,
            'shop_name'      => $request->shop_name,
            'contact_number' => $request->contact_number,
            'age'            => $request->age,
            'valid_id'       => $filePath,
        ]);

        $message = $request->role === 'buyer' 
            ? 'Registration successful! You can now log in.' 
            : 'Registration submitted! Please wait for admin approval.';

        return redirect()->route('login')->with('success', $message);
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

            // 1. Check if account is blocked
            if ($user->is_blocked) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been suspended.']);
            }

            // 2. Check for admin approval (mainly for sellers)
            if ($user->status !== 'approved') {
                Auth::logout();
                // Redirect to a specific "Pending" page or back to login with a message
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
            'admin'  => redirect()->route('admin.dashboard'),
            'seller' => redirect()->route('seller.dash'),
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
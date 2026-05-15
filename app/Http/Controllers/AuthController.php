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
     * ✅ NEW: Show the registration page specifically for Buyers
     */
    public function showBuyerRegister()
    {
<<<<<<< HEAD
        return view('auth.register', [
            'role' => request('role', 'buyer')
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:buyer,seller',

            'grade_level' => 'required_if:role,buyer',
            'monthly_budget' => 'required_if:role,buyer',
            'custom_budget' => 'required_if:monthly_budget,others|nullable|numeric',

            // seller fields
            'shop_name' => 'required_if:role,seller',
            'seller_name' => 'required_if:role,seller',
            'age' => 'required_if:role,seller|nullable|numeric',
            'contact_number' => 'required_if:role,seller',
            'valid_id' => 'required_if:role,seller|file|mimes:jpg,jpeg,png,pdf',
        ]);

        // =========================
        // 🟢 SELLER REGISTRATION
        // =========================
        if ($request->role === 'seller') {

            if ($request->age < 18) {
                return back()->withErrors([
                    'age' => 'You must be 18 years old or above to register as seller.'
                ]);
            }

            $filePath = null;

            if ($request->hasFile('valid_id')) {
                $filePath = $request->file('valid_id')->store('valid_ids', 'public');
            }

            User::create([
                'name' => $request->seller_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'seller',
                'status' => 'pending',

                'shop_name' => $request->shop_name,
                'contact_number' => $request->contact_number,
                'age' => $request->age,
                'valid_id' => $filePath,
            ]);

            return redirect('/pending-approval');
        }

        // =========================
        // 🟡 BUYER REGISTRATION
        // =========================

        $finalBudget = $request->monthly_budget;

        if ($request->monthly_budget === 'others' && $request->filled('custom_budget')) {
            $finalBudget = "₱" . $request->custom_budget;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'buyer',
            'status' => 'pending',

            'grade_level' => $request->grade_level,
            'monthly_budget' => $finalBudget,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please wait for Admin approval before logging in.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
=======
        return view('auth.register', ['role' => 'buyer']);
    }

    /**
     * ✅ NEW: Show the registration page specifically for Sellers
     */
    public function showSellerRegister()
    {
        return view('auth.register', ['role' => 'seller']);
    }

    /**
     * Unified Registration Logic for both Buyers and Sellers.
     */
    public function registerBuyer(Request $request) { return $this->register($request); }
    public function registerSeller(Request $request) { return $this->register($request); }

    public function register(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Added confirmed for security
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

        // Format Budget for Buyers
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
            'status'         => ($request->role === 'buyer') ? 'approved' : 'pending', // Auto-approve buyers, sellers stay pending
            'grade_level'    => $request->grade_level,
            'monthly_budget' => $finalBudget,
            'shop_name'      => $request->shop_name,
            'contact_number' => $request->contact_number,
            'age'            => $request->age,
            'valid_id'       => $filePath,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! ' . ($request->role === 'seller' ? 'Please wait for admin approval.' : 'You can now log in.'));
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
            if (isset($user->is_blocked) && $user->is_blocked) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been suspended.']);
            }

            // 2. Check for admin approval (Sellers)
            if ($user->status !== 'approved') {
                Auth::logout();
                // Ensure this route exists in web.php
                return redirect()->route('blocked')->withErrors([
                    'email' => 'Your account is currently waiting for admin approval.'
                ]);
            }

            $request->session()->regenerate();
            return $this->redirectUserBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
>>>>>>> origin/SellerStartup2.0
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user();

        if ($user->is_blocked) {
            Auth::logout();
            return redirect()->route('blocked');
        }

        // 🚨 BLOCK SELLERS NOT APPROVED
        if ($user->role === 'seller' && $user->status !== 'approved') {
            Auth::logout();
            return redirect('/pending')->withErrors([
                'email' => 'Your account is waiting for admin approval.'
            ]);
        }

        // ✅ REDIRECT USERS PROPERLY
        return $this->redirectUserBasedOnRole($user);
    }

<<<<<<< HEAD
    private function redirectUserBasedOnRole($user)
    {
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard');
        }

        if ($user->isSeller()) {
            return redirect('/seller/dashboard');
        }

        return redirect()->route('buyer.home'); 
    }

=======
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
>>>>>>> origin/SellerStartup2.0
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
<<<<<<< HEAD

    public function showSignup()
    {
        return view('auth.register');
    }

    public function showBuyerRegister()
    {
        return view('auth.buyer-register');
    }

    public function showSellerRegister()
    {
        return view('auth.seller-register');
    }   

    public function registerBuyer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'buyer',
            'status' => 'approved',
            'grade_level' => $request->grade_level,
            'monthly_budget' => $request->monthly_budget,
        ]);

        return redirect()->route('login');
    }

    public function registerSeller(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'shop_name' => 'required',
            'age' => 'required|integer|min:10',
            'contact_number' => 'required',
            'valid_id' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $filePath = null;

        if ($request->hasFile('valid_id')) {
            $filePath = $request->file('valid_id')->store('valid_ids', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'seller',
            'status' => 'pending',
            'shop_name' => $request->shop_name,
            'contact_number' => $request->contact_number,
            'age' => $request->age,
            'valid_id' => $filePath,
        ]);

        return redirect()->route('pending');
    }

=======

    /**
     * Show the pending approval view.
     */
>>>>>>> origin/SellerStartup2.0
    public function pending()
    {
        return view('auth.pending');
    }
}
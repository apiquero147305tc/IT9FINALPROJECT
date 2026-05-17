<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register', [
            'role' => request('role', 'buyer')
        ]);
    }

    /**
     * Show the registration page specifically for Buyers
     */
    public function showBuyerRegister()
{
    return view('auth.buyer-register');
}

    /**
     * Show the registration page specifically for Sellers
     */
    public function showSellerRegister()
{
    return view('auth.seller-register');
}

    /**
     * Unified Registration Logic for both Buyers and Sellers
     */
    public function registerBuyer(Request $request) { return $this->register($request); }
    public function registerSeller(Request $request) { return $this->register($request); }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:buyer,seller',
        ];

        // Conditional Validation based on Role
        if ($request->role === 'buyer') {
            $rules['grade_level'] = 'required|string';
            $rules['monthly_budget'] = 'required|string';
            $rules['custom_budget'] = 'required_if:monthly_budget,others|nullable|numeric';
        } else {
            $rules['shop_name'] = 'required|string|max:255';
            $rules['age'] = 'required|numeric|min:18';
            $rules['contact_number'] = 'required|digits:11';
            $rules['valid_id'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
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
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => ($request->role === 'buyer') ? 'approved' : 'pending',
            'grade_level' => $request->grade_level,
            'monthly_budget' => $finalBudget,
            'shop_name' => $request->shop_name,
            'contact_number' => $request->contact_number,
            'age' => $request->age,
            'valid_id' => $filePath,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! ' . ($request->role === 'seller' ? 'Please wait for admin approval.' : 'You can now log in.'));
    }

    /**
     * Handle Login Attempts
     */
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    $user = Auth::user();

    // Blocked users
    if ($user->is_blocked) {
        Auth::logout();
        return back()->withErrors([
            'email' => 'Your account has been suspended.'
        ]);
    }

    // Pending sellers
    if ($user->role === 'seller' && $user->status !== 'approved') {
        Auth::logout();

        return redirect()
            ->route('auth.pending')
            ->with('message', 'Your account is waiting for admin approval.');
    }

    $request->session()->regenerate();

    return $this->redirectUserBasedOnRole($user);
}

    /**
     * Helper to route users after successful login
     */
    private function redirectUserBasedOnRole($user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'seller' => redirect()->route('seller.dash'),
            default => redirect()->route('buyer.home'),
        };
    }

    /**
     * Handle Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Show the pending approval view
     */
    public function pending()
    {
        return view('auth.pending');
    }
}
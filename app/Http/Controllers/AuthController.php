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

    /**
     * Fixed: Added Request $request to access the role from URL
     */
    public function registerPage(Request $request)
    {
        return view('auth.register', [
            'role' => $request->role ?? 'buyer'
        ]);
    }

    public function register(Request $request)
    {
        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:buyer,seller',

            // Buyer specific fields
            'grade_level' => 'required_if:role,buyer',
            'monthly_budget' => 'required_if:role,buyer',
            'custom_budget' => 'required_if:monthly_budget,others|nullable|numeric',

            // Seller specific fields
            'shop_name' => 'required_if:role,seller',
            'seller_name' => 'required_if:role,seller',
            // numeric check only applies if the field is present
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
                    'age' => 'You must be 18 years old or above to register as a seller.'
                ])->withInput(); // Keep their data in the form
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
            // Defaulting buyers to approved so they can shop immediately, 
            // unless you want admins to approve every single student.
            'status' => 'approved', 
            'grade_level' => $request->grade_level,
            'monthly_budget' => $finalBudget,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registration successful! You can now log in.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.'
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::user();

        // 🚨 BLOCK USERS NOT APPROVED (Applies to both roles if necessary)
        if ($user->status !== 'approved') {
            Auth::logout();
            return redirect('/pending-approval')->withErrors([
                'email' => 'Your account is waiting for admin approval.'
            ]);
        }

        return $this->redirectUserBasedOnRole($user);
    }

    private function redirectUserBasedOnRole($user)
    {
        // Using direct role string checks to avoid "undefined method" errors
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        if ($user->role === 'seller') {
            return redirect('/seller/dashboard');
        }

        return redirect()->route('buyer.home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showSignup()
    {
        return view('auth.register');
    }
}
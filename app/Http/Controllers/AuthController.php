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

    public function registerPage(Request $request)
    {
        return view('auth.register', [
            'role' => $request->role ?? 'buyer'
        ]);
    }

    public function register(Request $request)
    {
        // 1. Unified Validation
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:buyer,seller',
        ];

        if ($request->role === 'buyer') {
            $rules['grade_level'] = 'required';
            $rules['monthly_budget'] = 'required';
            $rules['custom_budget'] = 'required_if:monthly_budget,others|nullable|numeric';
        } else {
            $rules['shop_name'] = 'required';
            $rules['age'] = 'required|numeric|min:18';
            $rules['contact_number'] = 'required|digits:11';
            $rules['valid_id'] = 'required|file|mimes:jpg,jpeg,png,pdf';
        }

        $request->validate($rules);

        // 2. Handle File Upload (Sellers Only)
        $filePath = null;
        if ($request->hasFile('valid_id')) {
            $filePath = $request->file('valid_id')->store('valid_ids', 'public');
        }

        // 3. Process Budget (Buyers Only)
        $finalBudget = $request->monthly_budget;
        if ($request->monthly_budget === 'others' && $request->filled('custom_budget')) {
            $finalBudget = "₱" . $request->custom_budget;
        }

        // 4. Create User
        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => $request->role,
            'status'         => ($request->role === 'admin') ? 'approved' : 'pending',
            
            // Buyer Fields
            'grade_level'    => $request->grade_level,
            'monthly_budget' => $finalBudget,

            // Seller Fields
            'shop_name'      => $request->shop_name,
            'contact_number' => $request->contact_number,
            'age'            => $request->age,
            'valid_id'       => $filePath,
        ]);

        if ($user->role === 'seller') {
            return redirect('/pending-approval');
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please wait for approval.');
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

        // Check if Approved
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

    public function pending()
    {
        return view('auth.pending');
    }
}
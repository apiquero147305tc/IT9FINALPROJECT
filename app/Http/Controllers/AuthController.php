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
        return view('auth.register');
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
        ]);

        $finalBudget = $request->monthly_budget;

        if ($request->monthly_budget === 'others' && $request->filled('custom_budget')) {
            $finalBudget = "₱" . $request->custom_budget;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'pending',
            'grade_level' => $request->role === 'buyer' ? $request->grade_level : null,
            'monthly_budget' => $request->role === 'buyer' ? $finalBudget : null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please wait for Admin approval before logging in.');
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

    /** @var User $user */
    $user = Auth::user();

    // block unapproved users
    if (!$user->isAdmin() && $user->status !== 'approved') {
        Auth::logout();
        return back()->withErrors([
            'email' => 'Your account is pending admin approval.'
        ]);
    }

    return $this->redirectUserBasedOnRole($user);
}

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
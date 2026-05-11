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
        'role' => $request->role ?? 'buyer'
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
        'age' => 'required_if:role,seller|numeric',
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
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    $request->session()->regenerate();

    /** @var User $user */
    $user = Auth::user();

    // 🚨 BLOCK SELLERS NOT APPROVED
    if ($user->role === 'seller' && $user->status !== 'approved') {

        Auth::logout();

        return redirect('/pending-approval')->withErrors([
            'email' => 'Your account is waiting for admin approval.'
        ]);
    }

    // ✅ REDIRECT USERS PROPERLY
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
        'grade_level' => $request->grade_level,
        'monthly_budget' => $request->monthly_budget,
    ]);

    return redirect()->route('login');
}

public function registerSeller(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'shop_name' => 'required',
        'seller_name' => 'required',
        'age' => 'required|integer|min:18',
        'contact_number' => 'required',
        'valid_id' => 'required|image',
    ]);

    $validIdPath = $request->file('valid_id')->store('valid_ids', 'public');

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'seller',
        'shop_name' => $request->shop_name,
        'age' => $request->age,
        'contact_number' => $request->contact_number,
        'valid_id' => $validIdPath,
    ]);

    return redirect()->route('login');
}

}
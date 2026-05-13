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
        'name' => $request->name, // ✅ FIXED HERE
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

 public function pending()
    {
        return view('auth.pending');
    }


}
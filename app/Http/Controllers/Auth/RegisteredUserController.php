<?php
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|in:buyer,seller',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'spending_limit' => $request->role === 'buyer' ? $request->spending_limit : null,
    ]);

    Auth::login($user);

    // Redirect Switchboard
    return match($user->role) {
        'admin'  => redirect('/admin/dashboard'),
        'seller' => redirect('/seller/dashboard'),
        'buyer'  => redirect('/buyer/dashboard'),
        default  => redirect('/'),
    };
}
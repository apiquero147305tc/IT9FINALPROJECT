<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard with pending approval requests.
     */
    public function dashboard()
    {
        // Fetch users waiting for approval
        $pendingUsers = User::where('status', 'pending')
        ->where('role', '!=', 'admin')
        ->latest()
        ->get();
        
        // Accurate Stats 
        $totalSellers = User::where('role', 'seller')
        ->where('status', 'approved')
        ->count();

       $totalBuyers = User::where('role', 'buyer')
       ->where('status', 'approved')
       ->count();

        return view('admin.dashboard', compact('pendingUsers', 'totalSellers', 'totalBuyers'));
    }

    /**
     * Approve a user so they can log in and use their dashboard.
     */
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved'; // Change status from pending to approved
        $user->save();

        return back()->with('success', "User {$user->name} has been approved!");
    }

    /**
     * Reject a user if they do not meet campus requirements.
     */
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected'; // Mark as rejected
        $user->save();

        return back()->with('error', "User {$user->name} was rejected.");
    }
     
    // --- PRODUCT REQUEST ---
    public function products()
    {
    $pendingProducts = Product::where('status', 'pending')
        ->latest()
        ->get();

    return view('admin.products', compact('pendingProducts'));
    }

    // Approved Product
    public function approveProduct($id)
    {
    $product = Product::findOrFail($id);
    $product->status = 'approved';
    $product->save();

    return back()->with('success', 'Product approved successfully!');
    }

    // Reject Product 
    public function rejectProduct($id)
   {
    $product = Product::findOrFail($id);
    $product->status = 'rejected';
    $product->save();

    return back()->with('error', 'Product rejected!');
   }

   public function manageProducts()
 {
    $products = Product::latest()->get();

    return view('admin.product-manage', compact('products'));
 }

 public function editProduct($id)
 {
    $product = \App\Models\Product::findOrFail($id);

    return view('admin.edit-product', compact('product'));
 }

 public function updateProduct(Request $request, $id)
 {
    $product = \App\Models\Product::findOrFail($id);

    $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'category' => $request->category,
    ]);

    return redirect()->route('admin.products.manage')
        ->with('success', 'Product updated successfully!');
 }

 public function deleteProduct($id)
 {
    $product = \App\Models\Product::findOrFail($id);

    $product->delete();

    return redirect()->route('admin.products.manage')
        ->with('success', 'Product deleted successfully!');
 }
}
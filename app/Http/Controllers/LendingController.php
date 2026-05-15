<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lending;
use App\Models\Product;

class LendingController extends Controller
{
    public function index()
    {
        $products = Product::where('is_lendable', true)
            ->where('stock', '>', 0)
            ->with('images', 'user')
            ->latest()
            ->get();

        return view('lending.index', compact('products'));
    }

    public function create($productId)
    {
        $product = Product::with('user')->findOrFail($productId);

        if (!$product->is_lendable) {
            return back()->with('error', 'This product is not available for lending.');
        }

        return view('lending.create', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'duration_days' => 'required|integer|min:1|max:30',
            'collateral_type' => 'required|in:cash,item,id',
            'collateral_description' => 'required|string|max:500',
            'collateral_value' => 'required|numeric|min:0',
            'purpose' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_lendable) {
            return back()->with('error', 'Product is not available for lending.');
        }

        if ($product->stock <= 0) {
            return back()->with('error', 'Product is out of stock.');
        }

        $lendingFee = ($product->price * 0.10) * ceil($request->duration_days / 7);

        Lending::create([
            'borrower_id' => Auth::id(),
            'lender_id' => $product->user_id,
            'product_id' => $product->id,
            'duration_days' => $request->duration_days,
            'collateral_type' => $request->collateral_type,
            'collateral_description' => $request->collateral_description,
            'collateral_value' => $request->collateral_value,
            'lending_fee' => $lendingFee,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'borrowed_at' => now(),
            'due_date' => now()->addDays($request->duration_days),
        ]);

        return redirect()->route('lending.my-requests')
            ->with('success', 'Lending request submitted! Waiting for seller approval.');
    }

    public function myRequests()
    {
        $requests = Lending::where('borrower_id', Auth::id())
            ->with(['product.images', 'lender'])
            ->latest()
            ->get();

        return view('lending.my-requests', compact('requests'));
    }

    public function sellerLendings()
    {
        $lendings = Lending::where('lender_id', Auth::id())
            ->with(['product.images', 'borrower'])
            ->latest()
            ->get();

        return view('lending.seller-lendings', compact('lendings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,returned,overdue',
        ]);

        $lending = Lending::where('lender_id', Auth::id())
            ->findOrFail($id);

        $product = $lending->product;

        if ($request->status === 'approved') {
            if ($product->stock <= 0) {
                return back()->with('error', 'Product is out of stock.');
            }

            $product->decrement('stock', 1);

            if ($product->stock <= 0) {
                $product->update(['status' => 'sold_out']);
            }

            $lending->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            return back()->with('success', 'Lending request approved! Product reserved.');
        }

        if ($request->status === 'rejected') {
            $lending->update([
                'status' => 'rejected',
                'rejected_at' => now(),
            ]);

            return back()->with('info', 'Lending request rejected.');
        }

        if ($request->status === 'returned') {
            $product->increment('stock', 1);

            if ($product->status === 'sold_out') {
                $product->update(['status' => 'available']);
            }

            $lending->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);

            return back()->with('success', 'Product marked as returned. Stock restored.');
        }

        if ($request->status === 'overdue') {
            $lending->update([
                'status' => 'overdue',
            ]);

            return back()->with('warning', 'Lending marked as overdue.');
        }

        return back();
    }

    public function toggleLendable(Request $request, $productId)
    {
        $product = Product::where('user_id', Auth::id())
            ->findOrFail($productId);

        $product->update([
            'is_lendable' => !$product->is_lendable,
        ]);

        $status = $product->is_lendable ? 'now available' : 'no longer available';

        return back()->with('success', "Product {$status} for lending.");
    }

    public function show($id)
    {
        $lending = Lending::with(['product.images', 'borrower', 'lender'])
            ->findOrFail($id);

        $user = Auth::user();

        if ($lending->borrower_id !== $user->id && 
            $lending->lender_id !== $user->id && 
            !$user->isAdmin()) {
            abort(403);
        }

        return view('lending.show', compact('lending'));
    }
}
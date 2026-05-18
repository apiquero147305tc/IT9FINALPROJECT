<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $lendingFee = ($product->price * 0.10) * ceil((int) $request->duration_days / 7);

        Lending::create([
            'borrower_id' => Auth::id(),
            'lender_id' => $product->user_id,
            'product_id' => $product->id,
            'duration_days' => (int) $request->duration_days,
            'collateral_type' => $request->collateral_type,
            'collateral_description' => $request->collateral_description,
            'collateral_value' => (float) $request->collateral_value,
            'lending_fee' => (float) $lendingFee,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'borrowed_at' => now(),
            'due_date' => now()->addDays((int) $request->duration_days),
        ]);

        return redirect()->route('lending.my-requests')
            ->with('success', 'Lending request submitted! Waiting for seller approval.');
    }

    public function myRequests()
    {
        $user = Auth::user();
        
        $allLoans = Lending::where('borrower_id', $user->id)
            ->with(['product', 'lender'])
            ->latest()
            ->get();
        
        $activeLoans = $allLoans->filter(function ($loan) {
            return $loan->status === 'approved' && is_null($loan->returned_at);
        });
        
        $pendingRequests = $allLoans->filter(function ($loan) {
            return $loan->status === 'pending';
        });
        
        $loanHistory = $allLoans->filter(function ($loan) {
            return $loan->status === 'returned' || $loan->status === 'rejected';
        });
        
        $totalFees = $allLoans->sum('lending_fee');
        
        return view('lending.my-requests', compact(
            'allLoans', 'activeLoans', 'pendingRequests', 'loanHistory', 'totalFees'
        ));
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
           $user->role !== 'admin') {
            abort(403);
        }

        return view('lending.show', compact('lending'));
    }
        public function buyerDashboard()
    {
        $user = Auth::user();

        $allLoans = Lending::where('borrower_id', $user->id)->get();
        $activeLoans = Lending::where('borrower_id', $user->id)
            ->where('status', 'approved')
            ->whereNull('returned_at')
            ->get();
        $pendingRequests = Lending::where('borrower_id', $user->id)
            ->where('status', 'pending')
            ->get();
        $loanHistory = Lending::where('borrower_id', $user->id)
            ->whereNotNull('returned_at')
            ->get();
        // ✅ FIX: Changed 'total_fee' to 'lending_fee' to match database column
        $totalFees = $allLoans->sum('lending_fee');

        return view('lending.buyer', compact(
            'allLoans', 'activeLoans', 'pendingRequests',
            'loanHistory', 'totalFees'
        ));
    }
}
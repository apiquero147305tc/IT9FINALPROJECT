<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lending;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LendingController extends Controller
{
    /**
     * Show the lending marketplace
     */
    public function index()
    {
        $availableProducts = Product::where('stock', '>', 0)
            ->where('user_id', '!=', Auth::id())
            ->with('user')
            ->get();

        $myBorrowings = Lending::where('borrower_id', Auth::id())
            ->with(['product', 'lender', 'collateralProduct'])
            ->orderBy('created_at', 'desc')
            ->get();

        $myLendings = Lending::where('lender_id', Auth::id())
            ->with(['product', 'borrower', 'collateralProduct'])
            ->orderBy('created_at', 'desc')
            ->get();

        $myProducts = Product::where('user_id', Auth::id())
            ->where('stock', '>', 0)
            ->get();

        return view('lending.index', compact(
            'availableProducts',
            'myBorrowings',
            'myLendings',
            'myProducts'
        ));
    }

    /**
     * Show form to request lending
     */
    public function create(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        if ($product->user_id === Auth::id()) {
            return back()->with('error', 'You cannot borrow your own product.');
        }

        $myProducts = Product::where('user_id', Auth::id())
            ->where('stock', '>', 0)
            ->get();

        return view('lending.create', compact('product', 'myProducts'));
    }

    /**
     * Store a new lending request
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'collateral_product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
            'purpose' => 'required|string|max:500',
        ]);

        $product = Product::findOrFail($request->product_id);
        $collateralProduct = Product::findOrFail($request->collateral_product_id);

        if ($collateralProduct->user_id !== Auth::id()) {
            return back()->with('error', 'Collateral item must be your own product.');
        }

        if ($collateralProduct->stock < $request->quantity) {
            return back()->with('error', 'You do not have enough stock of the collateral item.');
        }

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Product does not have enough stock available.');
        }

        Lending::create([
            'borrower_id' => Auth::id(),
            'lender_id' => $product->user_id,
            'product_id' => $request->product_id,
            'collateral_product_id' => $request->collateral_product_id,
            'quantity' => $request->quantity,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return redirect()->route('lending.index')
            ->with('success', 'Lending request submitted! Waiting for lender approval.');
    }

    /**
     * Lender approves the lending request
     */
    public function approve($id)
    {
        $lending = Lending::findOrFail($id);

        if ($lending->lender_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($lending->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $product = Product::findOrFail($lending->product_id);
        $product->stock -= $lending->quantity;
        $product->save();

        $collateral = Product::findOrFail($lending->collateral_product_id);
        $collateral->stock -= $lending->quantity;
        $collateral->save();

        $lending->status = 'active';
        $lending->save();

        return back()->with('success', 'Lending request approved! Product is now borrowed.');
    }

    /**
     * Lender rejects the lending request
     */
    public function reject($id)
    {
        $lending = Lending::findOrFail($id);

        if ($lending->lender_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($lending->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $lending->status = 'rejected';
        $lending->save();

        return back()->with('success', 'Lending request rejected.');
    }

    /**
     * Mark item as returned
     */
    public function returnItem(Request $request, $id)
    {
        $lending = Lending::findOrFail($id);

        if ($lending->borrower_id !== Auth::id() && $lending->lender_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($lending->status !== 'active') {
            return back()->with('error', 'This lending is not active.');
        }

        $request->validate([
            'condition' => 'required|in:good,damaged,lost',
            'damage_description' => 'nullable|string|max:500',
        ]);

        $lending->condition_on_return = $request->condition;
        $lending->damage_description = $request->damage_description;

        if ($request->condition === 'good') {
            $product = Product::findOrFail($lending->product_id);
            $product->stock += $lending->quantity;
            $product->save();

            $collateral = Product::findOrFail($lending->collateral_product_id);
            $collateral->stock += $lending->quantity;
            $collateral->save();

            $lending->status = 'returned';
            $lending->collateral_released = true;
            $lending->save();

            return back()->with('success', 'Item returned successfully! Collateral released.');
        } else {
            $lending->status = 'damaged';
            $lending->collateral_released = false;
            $lending->save();

            return back()->with('warning', 'Item marked as ' . $request->condition . '. Collateral will be kept as replacement.');
        }
    }

    /**
     * Release collateral manually
     */
    public function releaseCollateral($id)
    {
        $lending = Lending::findOrFail($id);

        if ($lending->status !== 'damaged' && $lending->status !== 'lost') {
            return back()->with('error', 'Collateral can only be released for damaged/lost items after resolution.');
        }

        $collateral = Product::findOrFail($lending->collateral_product_id);
        $collateral->stock += $lending->quantity;
        $collateral->save();

        $lending->collateral_released = true;
        $lending->save();

        return back()->with('success', 'Collateral released to borrower.');
    }

    /**
     * Apply for lending (simple version)
     */
    public function apply(Request $request)
    {
        return redirect()->route('lending.index')->with('success', 'Application submitted!');
    }

    /**
     * Repay lending (simple version)
     */
    public function repay(Request $request, $loan)
    {
        return redirect()->route('lending.index')->with('success', 'Repayment processed!');
    }
}
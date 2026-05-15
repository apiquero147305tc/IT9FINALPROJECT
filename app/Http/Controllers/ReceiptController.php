<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    public function show($orderId)
    {
        $order = Order::with(['product', 'product.user', 'user'])
            ->findOrFail($orderId);

        $user = Auth::user();
        $isBuyer = $order->user_id === $user->id;
        $isSeller = $order->product->user_id === $user->id;
        $isAdmin = $user->isAdmin();

        if (!$isBuyer && !$isSeller && !$isAdmin) {
            abort(403, 'Unauthorized access to receipt.');
        }

        return view('receipt.show', compact('order', 'isBuyer', 'isSeller'));
    }

    public function download($orderId)
    {
        $order = Order::with(['product', 'product.user', 'user'])
            ->findOrFail($orderId);

        $user = Auth::user();
        if ($order->user_id !== $user->id && $order->product->user_id !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        return view('receipt.print', compact('order'));
    }
}
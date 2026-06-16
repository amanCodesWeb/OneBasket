<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Show order history for the current user.
     */
    public function index(): View
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('pages.orders.index', compact('orders'));
    }

    /**
     * Show a single order with its items.
     */
    public function show(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product.vendor');

        return view('pages.orders.show', compact('order'));
    }
}

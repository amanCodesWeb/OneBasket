<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * List authenticated user's orders.
     */
    public function index(): JsonResponse
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(20);

        return response()->json($orders);
    }

    /**
     * Show a single order.
     */
    public function show(Order $order): JsonResponse
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $order->load('items.product.vendor');

        return response()->json($order);
    }
}

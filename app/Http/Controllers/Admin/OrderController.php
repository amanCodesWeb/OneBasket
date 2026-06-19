<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * List all orders (admin).
     */
    public function index(Request $request): View
    {
        $query = Order::with('user');

        // Status filter (order_status)
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // Vendor status filter
        if ($request->filled('vendor_status')) {
            $query->where('status', $request->vendor_status);
        }

        // Search by order number or user email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($uq) => $uq->where('email', 'like', "%{$search}%"));
            });
        }

        $orders = $query->latest()->paginate(20);
        $statuses = Order::$orderStatuses;
        $vendorStatuses = Order::$vendorStatuses;

        return view('admin.orders.index', compact('orders', 'statuses', 'vendorStatuses'));
    }

    /**
     * Show order detail (admin).
     */
    public function show(Order $order): View
    {
        $order->load('user', 'items.product.vendor');
        $statuses = Order::$orderStatuses;

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    /**
     * Update order status (admin).
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        // Order-level status update (dropdown)
        if ($request->filled('order_status')) {
            $request->validate([
                'order_status' => ['required', 'in:' . implode(',', Order::$orderStatuses)],
            ]);
            $order->update(['order_status' => $request->order_status]);
            return back()->with('success', 'Order status updated to ' . $order->order_status_label . '.');
        }

        // Vendor fulfillment status update (quick action buttons)
        $request->validate([
            'status' => ['required', 'in:' . implode(',', Order::$vendorStatuses)],
        ]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Fulfillment status updated to ' . $order->status_label . '.');
    }
}

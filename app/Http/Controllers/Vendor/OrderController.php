<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $vendor = auth()->user()->vendor;

        $query = Order::whereHas('items', fn($q) => $q->where('vendor_id', $vendor->id))
            ->with(['items' => fn($q) => $q->where('vendor_id', $vendor->id)->with('product')]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('order_number', 'like', "%{$s}%");
        }

        $orders = $query->latest()->paginate(15);

        // Compute per-order vendor stats
        $orders->each(function ($order) use ($vendor) {
            $vendorItems = $order->items->where('vendor_id', $vendor->id);
            $order->vendor_item_count = $vendorItems->sum('quantity');
            $order->vendor_subtotal = $vendorItems->sum('subtotal');
        });

        $statuses = Order::$statuses;
        $counts = [
            'total' => Order::whereHas('items', fn($q) => $q->where('vendor_id', $vendor->id))->count(),
        ];

        return view('vendor.orders.index', compact('orders', 'statuses', 'counts', 'vendor'));
    }

    public function show(Order $order): View
    {
        $vendor = auth()->user()->vendor;

        // Ensure this order has items from this vendor
        $vendorItems = OrderItem::where('order_id', $order->id)
            ->where('vendor_id', $vendor->id)
            ->with('product')
            ->get();

        if ($vendorItems->isEmpty()) {
            abort(403);
        }

        $order->load('items.product');

        return view('vendor.orders.show', compact('order', 'vendorItems', 'vendor'));
    }

    public function markAsPacked(Order $order): RedirectResponse
    {
        $vendor = auth()->user()->vendor;

        $belongsToVendor = OrderItem::where('order_id', $order->id)
            ->where('vendor_id', $vendor->id)
            ->exists();

        if (! $belongsToVendor) {
            abort(403);
        }

        if ($order->status !== Order::STATUS_CONFIRMED) {
            return back()->with('error', 'Only confirmed orders can be marked as packed.');
        }

        $order->update(['status' => Order::STATUS_PACKED]);

        return redirect()->route('vendor.orders.show', $order)
            ->with('success', 'Order marked as packed successfully.');
    }
}

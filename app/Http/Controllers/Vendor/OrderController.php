<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Allowed vendor status transitions.
     */
    protected array $allowedTransitions = [
        'pending'   => ['packed', 'cancelled'],
        'packed'    => ['pending'], // revert if needed
    ];

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

        $vendorStatuses = Order::$vendorStatuses;

        $vendorBase = Order::whereHas('items', fn($q) => $q->where('vendor_id', $vendor->id));
        $counts = [
            'total'     => (clone $vendorBase)->count(),
            'pending'   => (clone $vendorBase)->where('status', 'pending')->count(),
            'packed'    => (clone $vendorBase)->where('status', 'packed')->count(),
            'picked_up' => (clone $vendorBase)->where('status', 'picked_up')->count(),
            'cancelled' => (clone $vendorBase)->where('status', 'cancelled')->count(),
            'delivered' => (clone $vendorBase)->where('status', 'delivered')->count(),
        ];

        $allowedTransitions = $this->allowedTransitions;
        $vendorStatusLabels = Order::$vendorStatusLabels;

        return view('vendor.orders.index', compact('orders', 'vendorStatuses', 'counts', 'vendor', 'allowedTransitions', 'vendorStatusLabels'));
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

        $allowedTransitions = $this->allowedTransitions;
        $vendorStatusLabels = Order::$vendorStatusLabels;

        return view('vendor.orders.show', compact('order', 'vendorItems', 'vendor', 'allowedTransitions', 'vendorStatusLabels'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|string|in:' . implode(',', Order::$vendorStatuses),
        ]);

        $vendor = auth()->user()->vendor;

        $belongsToVendor = OrderItem::where('order_id', $order->id)
            ->where('vendor_id', $vendor->id)
            ->exists();

        if (! $belongsToVendor) {
            abort(403);
        }

        $targetStatus = $request->status;

        // Check transition is allowed
        $allowed = $this->allowedTransitions[$order->status] ?? [];
        if (! in_array($targetStatus, $allowed)) {
            return back()->with('error', "Cannot change status from {$order->status_label} to " . (new Order)->setAttribute('status', $targetStatus)->status_label . ".");
        }

        $order->update(['status' => $targetStatus]);

        return redirect()->route('vendor.orders.index')
            ->with('success', "Order #{$order->order_number} status updated to " . (Order::$vendorStatusLabels[$targetStatus] ?? $targetStatus) . ".");
    }
}

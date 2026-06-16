<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show checkout review page.
     */
    public function review()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.vendor')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $grouped = $cartItems->groupBy(fn ($item) => $item->product->vendor->business_name ?? 'Unknown');
        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);
        $itemCount = $cartItems->sum('quantity');

        return view('pages.checkout', compact('cartItems', 'grouped', 'subtotal', 'itemCount'));
    }

    /**
     * Place the order — convert cart into an order with items.
     */
    public function place(Request $request): RedirectResponse
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.vendor')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate stock
        foreach ($cartItems as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                return back()->with('error', "Insufficient stock for {$item->product->name}. Only {$item->product->stock_quantity} available.");
            }
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);
            $itemCount = $cartItems->sum('quantity');

            $order = Order::create([
                'user_id'          => Auth::id(),
                'status'           => Order::STATUS_PENDING,
                'subtotal'         => $subtotal,
                'total_item_count' => $itemCount,
                'notes'            => $request->input('notes'),
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cartItem->product_id,
                    'vendor_id'  => $cartItem->product->vendor_id,
                    'quantity'   => $cartItem->quantity,
                    'unit_price' => $cartItem->unit_price,
                    'subtotal'   => $cartItem->subtotal,
                ]);

                // Decrement stock
                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
            }

            // Clear the cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', "Order {$order->order_number} placed successfully!");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }
}

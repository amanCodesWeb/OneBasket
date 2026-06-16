<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Show the cart page — items grouped by vendor.
     */
    public function index(): View
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.vendor', 'product.category')
            ->get();

        $grouped = $cartItems->groupBy(fn ($item) => $item->product->vendor->business_name ?? 'Unknown');

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);
        $itemCount = $cartItems->sum('quantity');

        return view('pages.cart', compact('grouped', 'cartItems', 'subtotal', 'itemCount'));
    }

    /**
     * Add a product to cart (or increment quantity if already in cart).
     */
    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['sometimes', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity < 1) {
            return back()->with('error', 'This product is out of stock.');
        }

        $quantity = (int) ($request->quantity ?? 1);

        $existing = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $quantity;
            if ($newQty > $product->stock_quantity) {
                $newQty = $product->stock_quantity;
            }
            $existing->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'unit_price' => $product->price,
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, Cart $cart): RedirectResponse
    {
        $this->authorizeCart($cart);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $qty = (int) $request->quantity;

        if ($qty < 1) {
            return $this->remove($cart);
        }

        if ($qty > $cart->product->stock_quantity) {
            $qty = $cart->product->stock_quantity;
        }

        $cart->update(['quantity' => $qty]);

        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from cart.
     */
    public function remove(Cart $cart): RedirectResponse
    {
        $this->authorizeCart($cart);
        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear(): RedirectResponse
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    /**
     * Get cart count for the badge (AJAX).
     */
    public function count(): \Illuminate\Http\JsonResponse
    {
        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }

    /**
     * Authorize that the cart item belongs to the current user.
     */
    private function authorizeCart(Cart $cart): void
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'This cart item does not belong to you.');
        }
    }
}

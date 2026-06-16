<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(): JsonResponse
    {
        $items = Cart::where('user_id', Auth::id())
            ->with('product.vendor', 'product.category')
            ->get()
            ->map(fn ($item) => [
                'id'              => $item->id,
                'product_id'      => $item->product_id,
                'product_name'    => $item->product->name,
                'product_slug'    => $item->product->slug,
                'thumbnail'       => $item->product->thumbnail,
                'vendor_name'     => $item->product->vendor?->business_name,
                'vendor_id'       => $item->product->vendor_id,
                'quantity'        => $item->quantity,
                'unit_price'      => (float) $item->unit_price,
                'subtotal'        => (float) $item->subtotal,
                'stock_quantity'  => $item->product->stock_quantity,
            ]);

        $total = $items->sum('subtotal');

        return response()->json([
            'items' => $items,
            'total' => round($total, 2),
            'count' => $items->sum('quantity'),
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['sometimes', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->stock_quantity < 1) {
            return response()->json(['message' => 'Product is out of stock.'], 422);
        }

        $quantity = (int) ($data['quantity'] ?? 1);

        $existing = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $quantity;
            if ($newQty > $product->stock_quantity) {
                $newQty = $product->stock_quantity;
            }
            $existing->update(['quantity' => $newQty]);
            $cart = $existing;
        } else {
            $cart = Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'unit_price' => $product->price,
            ]);
        }

        return response()->json([
            'message' => 'Added to cart.',
            'cart'    => $cart->fresh()->load('product.vendor'),
        ], 201);
    }

    public function update(Request $request, Cart $cart): JsonResponse
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        if ($data['quantity'] < 1) {
            $cart->delete();
            return response()->json(['message' => 'Item removed.']);
        }

        $qty = (int) $data['quantity'];
        if ($qty > $cart->product->stock_quantity) {
            $qty = $cart->product->stock_quantity;
        }

        $cart->update(['quantity' => $qty]);

        return response()->json(['message' => 'Cart updated.', 'cart' => $cart->fresh()->load('product.vendor')]);
    }

    public function destroy(Cart $cart): JsonResponse
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $cart->delete();

        return response()->json(['message' => 'Item removed.']);
    }

    public function clear(): JsonResponse
    {
        Cart::where('user_id', Auth::id())->delete();

        return response()->json(['message' => 'Cart cleared.']);
    }
}

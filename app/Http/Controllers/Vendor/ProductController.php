<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $vendor = auth()->user()->vendor;
        $query = Product::where('vendor_id', $vendor->id)->with('category');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('name', 'like', "%{$s}%");
        }

        $products = $query->latest()->paginate(15);

        return view('vendor.products.index', compact('products', 'vendor'));
    }

    public function create(): View
    {
        $vendor = auth()->user()->vendor;
        $categories = Category::active()->ordered()->with('children')->get();

        return view('vendor.products.form', compact('vendor', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $vendor = auth()->user()->vendor;

        $data = $request->validate([
            'category_id'   => ['nullable', 'exists:categories,id'],
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity'=> ['required', 'integer', 'min:0'],
            'unit'          => ['nullable', 'string', 'max:50'],
            'images'        => ['nullable', 'json'],
        ]);

        $data['vendor_id'] = $vendor->id;
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);

        // Check if vendor products need approval
        $requiresApproval = Setting::boolValue('vendor_products_require_approval', true);

        if ($requiresApproval) {
            $data['is_approved'] = false;
            $data['status'] = 'inactive';
        } else {
            $data['is_approved'] = true;
            $data['status'] = 'active';
        }

        Product::create($data);

        return redirect()->route('vendor.products.index')
            ->with('success', $requiresApproval
                ? 'Product submitted for admin approval.'
                : 'Product created successfully.');
    }

    public function edit(Product $product): View|RedirectResponse
    {
        $vendor = auth()->user()->vendor;

        if ($product->vendor_id !== $vendor->id) {
            abort(403);
        }

        $categories = Category::active()->ordered()->with('children')->get();

        return view('vendor.products.form', compact('product', 'vendor', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $vendor = auth()->user()->vendor;

        if ($product->vendor_id !== $vendor->id) {
            abort(403);
        }

        $data = $request->validate([
            'category_id'   => ['nullable', 'exists:categories,id'],
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity'=> ['required', 'integer', 'min:0'],
            'unit'          => ['nullable', 'string', 'max:50'],
            'images'        => ['nullable', 'json'],
        ]);

        if ($data['name'] !== $product->name) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        }

        // Re-queue for approval if setting is enabled
        $requiresApproval = Setting::boolValue('vendor_products_require_approval', true);
        if ($requiresApproval) {
            $data['is_approved'] = false;
            $data['status'] = 'inactive';
        }

        $product->update($data);

        return redirect()->route('vendor.products.index')
            ->with('success', $requiresApproval
                ? 'Product updated and submitted for re-approval.'
                : 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $vendor = auth()->user()->vendor;

        if ($product->vendor_id !== $vendor->id) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted.');
    }
}

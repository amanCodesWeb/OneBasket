<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('vendor', 'category');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('approval')) {
            if ($request->approval === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->approval === 'approved') {
                $query->where('is_approved', true);
            }
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhereHas('vendor', fn ($v) => $v->where('business_name', 'like', "%{$s}%"));
            });
        }

        $products = $query->latest()->paginate(15);
        $statuses = ['active', 'inactive', 'draft'];
        $vendors  = Vendor::active()->get();
        $pendingCount = Product::where('is_approved', false)->count();

        return view('admin.products.index', compact('products', 'statuses', 'vendors', 'pendingCount'));
    }

    public function create(): View
    {
        $statuses   = ['active', 'inactive', 'draft'];
        $vendors    = Vendor::active()->get();
        $categories = Category::active()->ordered()->with('children')->get();
        $features   = Feature::active()->ordered()->get();

        return view('admin.products.form', compact('statuses', 'vendors', 'categories', 'features'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'vendor_id'     => ['required', 'exists:vendors,id'],
            'category_id'   => ['nullable', 'exists:categories,id'],
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity'=> ['required', 'integer', 'min:0'],
            'unit'          => ['nullable', 'string', 'max:50'],
            'status'        => ['required', 'in:active,inactive,draft'],
            'featured'      => ['boolean'],
            'images_source' => ['nullable', 'in:url,upload'],
            'images_url'    => ['nullable', 'string'],
            'upload_images' => ['nullable', 'array'],
            'upload_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            // Shipping fields
            'weight'        => ['nullable', 'numeric', 'min:0'],
            'length'        => ['nullable', 'numeric', 'min:0'],
            'width'         => ['nullable', 'numeric', 'min:0'],
            'height'        => ['nullable', 'numeric', 'min:0'],
            'items_in_pack' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        $data['featured'] = $request->boolean('featured');
        $data['is_approved'] = true; // Admin-created products are auto-approved

        // Handle images
        $data['images'] = $this->processImages($request);

        $product = Product::create($data);

        // Sync features
        $this->syncFeatures($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load('vendor', 'category', 'features');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $statuses   = ['active', 'inactive', 'draft'];
        $vendors    = Vendor::active()->get();
        $categories = Category::active()->ordered()->with('children')->get();
        $features   = Feature::active()->ordered()->get();

        $product->load('features');

        return view('admin.products.form', compact('product', 'statuses', 'vendors', 'categories', 'features'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'vendor_id'     => ['required', 'exists:vendors,id'],
            'category_id'   => ['nullable', 'exists:categories,id'],
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity'=> ['required', 'integer', 'min:0'],
            'unit'          => ['nullable', 'string', 'max:50'],
            'status'        => ['required', 'in:active,inactive,draft'],
            'featured'      => ['boolean'],
            'images_source' => ['nullable', 'in:url,upload'],
            'images_url'    => ['nullable', 'string'],
            'upload_images' => ['nullable', 'array'],
            'upload_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            // Shipping fields
            'weight'        => ['nullable', 'numeric', 'min:0'],
            'length'        => ['nullable', 'numeric', 'min:0'],
            'width'         => ['nullable', 'numeric', 'min:0'],
            'height'        => ['nullable', 'numeric', 'min:0'],
            'items_in_pack' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['featured'] = $request->boolean('featured');

        if ($data['name'] !== $product->name) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        }

        // Handle images
        $data['images'] = $this->processImages($request, $product);

        $product->update($data);

        // Sync features
        $this->syncFeatures($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    // ── Feature sync ────────────────────────────────────────────────

    private function processImages(Request $request, ?Product $product = null): ?array
    {
        if ($request->images_source === 'upload' && $request->hasFile('upload_images')) {
            $uploaded = [];
            foreach ($request->file('upload_images') as $file) {
                $path = $file->store('products', 'public');
                $uploaded[] = '/storage/' . $path;
            }
            return $uploaded;
        }

        if ($request->images_source === 'url') {
            if ($request->filled('images_url')) {
                $urls = array_map('trim', explode(',', $request->images_url));
                $urls = array_values(array_filter($urls));
                return !empty($urls) ? $urls : null;
            }
            // URL mode with empty input → clear images
            return null;
        }

        // Upload mode without files → keep existing (for update) or null (for create)
        if ($product) {
            return $product->images;
        }

        return null;
    }

    private function syncFeatures(Product $product, Request $request): void
    {
        $features = $request->input('features', []);

        if (empty($features)) {
            $product->features()->detach();
            return;
        }

        $sync = [];
        foreach ($features as $featureId => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value); // multi_select → comma-separated
            }
            if ($value !== '' && $value !== null) {
                $sync[$featureId] = ['value' => $value];
            }
        }

        $product->features()->sync($sync);
    }

    // ── Approval actions ────────────────────────────────────────────

    public function approve(Product $product): RedirectResponse
    {
        $product->update([
            'is_approved' => true,
            'status'      => 'active',
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$product->name}\" approved.");
    }

    public function reject(Product $product): RedirectResponse
    {
        $product->update([
            'is_approved' => false,
            'status'      => 'inactive',
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$product->name}\" rejected.");
    }
}

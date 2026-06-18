<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $categories   = Category::active()->root()->ordered()->get();
        $featured     = Product::active()->approved()->featured()->with('vendor', 'category')->inStock()->take(8)->get();
        $vendors      = Vendor::active()->verified()->take(6)->get();
        $newProducts  = Product::active()->approved()->with('vendor')->latest()->take(4)->get();
        return view('pages.home', compact('categories', 'featured', 'vendors', 'newProducts'));
    }

    public function welcome(): View
    {
        return view('welcome');
    }

    public function categories(): View
    {
        $categories = Category::active()->root()->ordered()->with('children')->get();
        return view('pages.categories', compact('categories'));
    }

    public function category(Category $category): View
    {
        $category->load('children');
        $productIds = [$category->id];
        foreach ($category->children as $child) {
            $productIds[] = $child->id;
        }
        $products = Product::active()->approved()->whereIn('category_id', $productIds)
            ->with('vendor', 'category')
            ->paginate(12);
        return view('pages.category', compact('category', 'products'));
    }

    public function products(Request $request): View
    {
        $query = Product::active()->approved()->with('vendor', 'category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('vendor')) {
            $query->whereHas('vendor', fn($q) => $q->where('slug', $request->vendor));
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }
        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc'  => $query->orderBy('price'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest'     => $query->latest(),
                default      => $query->latest(),
            };
        } else {
            $query->latest();
        }

        $products    = $query->paginate(12)->withQueryString();
        $categories  = Category::active()->root()->ordered()->get();
        $vendors     = Vendor::active()->get();

        return view('pages.products', compact('products', 'categories', 'vendors'));
    }

    public function product(string $slug): View
    {
        $product = Product::active()->approved()
            ->with(['vendor', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Product::active()->approved()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('vendor')
            ->take(4)
            ->get();

        return view('pages.product', compact('product', 'related'));
    }
}

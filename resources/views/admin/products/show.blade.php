@extends('layouts.admin')

@section('title', $product->name)
@section('heading', $product->name)

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition">&larr; Back to Products</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-start gap-4 mb-4">
                    @if($product->thumbnail)
                        <img src="{{ $product->thumbnail }}" alt="" class="w-16 h-16 rounded-xl object-cover">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-600 dark:text-primary-400 text-xl font-bold">
                            {{ substr($product->name, 0, 2) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->vendor?->business_name }} · {{ $product->category?->name ?? 'Uncategorized' }}</p>
                    </div>
                </div>

                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Product Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Price</dt>
                        <dd class="text-gray-900 dark:text-white font-medium">Rs. {{ number_format($product->price, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Compare Price</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $product->compare_price ? 'Rs. '.number_format($product->compare_price, 2) : '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Discount</dt>
                        <dd class="text-gray-900 dark:text-white">
                            @if($product->hasDiscount)
                                <span class="text-green-600 dark:text-green-400">{{ $product->discount_percent }}% off</span>
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Stock Quantity</dt>
                        <dd class="text-gray-900 dark:text-white">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($product->stock_quantity > 10) bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300
                                @elseif($product->stock_quantity > 0) bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300
                                @else bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 @endif">
                                {{ $product->stock_quantity }} {{ $product->unit ?? 'units' }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Unit</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $product->unit ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Slug</dt>
                        <dd class="text-gray-900 dark:text-white font-mono text-xs">{{ $product->slug }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                        <dd>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($product->status)
                                    @case('active') bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 @break
                                    @case('inactive') bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 @break
                                    @case('draft') bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 @break
                                    @default bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400
                                @endswitch
                            ">{{ ucfirst($product->status) }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Featured</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $product->featured ? 'Yes' : 'No' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Created</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $product->created_at->format('M d, Y \\a\\t g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Last Updated</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $product->updated_at->format('M d, Y \\a\\t g:i A') }}</dd>
                    </div>
                </dl>
            </div>

            @if($product->description)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Description</h3>
                    <p class="text-gray-900 dark:text-white text-sm whitespace-pre-line">{{ $product->description }}</p>
                </div>
            @endif

            @if($product->images && count($product->images))
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Images</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($product->images as $image)
                            <img src="{{ $image }}" alt="" class="w-full h-24 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar actions --}}
        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="block w-full text-center bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Edit Product</a>

                    @if($product->status === 'draft' || $product->status === 'inactive')
                        <form method="POST" action="{{ route('admin.products.update', $product) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="vendor_id" value="{{ $product->vendor_id }}">
                            <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="compare_price" value="{{ $product->compare_price }}">
                            <input type="hidden" name="stock_quantity" value="{{ $product->stock_quantity }}">
                            <input type="hidden" name="unit" value="{{ $product->unit }}">
                            <input type="hidden" name="status" value="active">
                            <input type="hidden" name="featured" value="{{ $product->featured ? '1' : '0' }}">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Set Active</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Quick Links</h3>
                <div class="space-y-2 text-sm">
                    <a href="{{ route('admin.products.edit', $product) }}" class="block text-primary-600 dark:text-primary-400 hover:underline">Edit product &rarr;</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Delete product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

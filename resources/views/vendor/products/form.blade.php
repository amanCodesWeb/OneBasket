@extends('vendor.layouts.vendor')

@section('title', isset($product) ? 'Edit Product' : 'Add Product')
@section('heading', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
    <div class="animate-fade-in max-w-3xl">
        <form method="POST" action="{{ isset($product) ? route('vendor.products.update', $product) : route('vendor.products.store') }}"
              class="bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 shadow-sm p-6 space-y-6">
            @csrf
            @if(isset($product)) @method('PUT') @endif

            {{-- Product Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                       class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Category + Unit row --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                    <select name="category_id"
                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="">— Select —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Unit</label>
                    <input type="text" name="unit" value="{{ old('unit', $product->unit ?? '') }}"
                           placeholder="e.g. kg, piece, dozen"
                           class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
            </div>

            {{-- Price + Compare Price + Stock row --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price (Rs.) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price ?? '') }}" required
                           class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('price') border-red-400 @enderror">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Compare Price</label>
                    <input type="number" step="0.01" min="0" name="compare_price" value="{{ old('compare_price', $product->compare_price ?? '') }}"
                           class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock Quantity <span class="text-red-500">*</span></label>
                    <input type="number" min="0" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required
                           class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('stock_quantity') border-red-400 @enderror">
                    @error('stock_quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            {{-- Images (JSON input - simplified for now) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Images (JSON URLs)</label>
                <input type="text" name="images" value="{{ old('images', is_array($product->images ?? null) ? json_encode($product->images) : ($product->images ?? '')) }}"
                       placeholder='["https://example.com/image.jpg"]'
                       class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                <p class="text-xs text-gray-400 mt-1">Enter a JSON array of image URLs, or leave empty.</p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 text-white text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200">
                    {{ isset($product) ? 'Update Product' : 'Add Product' }}
                </button>
                <a href="{{ route('vendor.products.index') }}"
                   class="px-6 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 text-sm font-medium transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Product' : 'New Product')
@section('heading', isset($product) ? 'Edit Product' : 'New Product')

@section('content')
    @push('head')
    <style>
        main { overflow: hidden !important; display: flex !important; flex-direction: column !important; }
    </style>
    @endpush

    <form method="POST" action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" class="flex-1 flex flex-col min-h-0" enctype="multipart/form-data">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        {{-- Always-visible header --}}
        <div class="shrink-0 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1">
                        {{-- Back link inline in header --}}
                        <a href="{{ route('admin.products.index') }}"
                           class="inline-flex items-center gap-1 px-2 py-1.5 text-xs font-medium text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors group shrink-0"
                           title="Back to Products">
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span class="hidden sm:inline">Back</span>
                        </a>

                        <nav class="flex gap-0 -mb-px" role="tablist">
                            <button type="button" role="tab" onclick="switchTab('general')"
                                    class="tab-btn px-4 py-3 text-sm font-medium border-b-2 transition-colors"
                                    id="tab-general" aria-selected="true">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    General
                                </span>
                            </button>
                            <button type="button" role="tab" onclick="switchTab('shipping')"
                                    class="tab-btn px-4 py-3 text-sm font-medium border-b-2 transition-colors"
                                    id="tab-shipping" aria-selected="false">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                    Shipping
                                </span>
                            </button>
                            <button type="button" role="tab" onclick="switchTab('features')"
                                    class="tab-btn px-4 py-3 text-sm font-medium border-b-2 transition-colors"
                                    id="tab-features" aria-selected="false">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                                    </svg>
                                    Features
                                </span>
                            </button>
                        </nav>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.products.index') }}"
                           class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 px-3 py-2">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-5 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500/30">
                            {{ isset($product) ? 'Update Product' : 'Create Product' }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Scrollable content area --}}
            <div class="flex-1 overflow-y-auto min-h-0 px-4 sm:px-6 lg:px-8 py-4">
                <div class="max-w-4xl mx-auto space-y-5">

            {{-- === TAB: General === --}}
            <div class="tab-panel pt-0 space-y-5" id="panel-general">
                {{-- Basic Information --}}
                <div class="bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gradient-to-r from-primary-50/50 to-transparent dark:from-primary-900/10 dark:to-transparent">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Basic Information</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Product name, description, vendor &amp; category</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                                       class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('name') border-red-500 dark:border-red-500 @enderror"
                                       placeholder="e.g. Organic Bananas">
                            </div>
                            @error('name') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Description</label>
                            <textarea name="description" rows="4"
                                      class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('description') border-red-500 dark:border-red-500 @enderror"
                                      placeholder="Describe the product...">{{ old('description', $product->description ?? '') }}</textarea>
                            @error('description') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Vendor + Category --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Vendor <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <select name="vendor_id" required
                                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-8 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition appearance-none @error('vendor_id') border-red-500 dark:border-red-500 @enderror">
                                        <option value="" class="text-gray-400">Select vendor...</option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" {{ old('vendor_id', $product->vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->business_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                                @error('vendor_id') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <select name="category_id"
                                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-8 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition appearance-none @error('category_id') border-red-500 dark:border-red-500 @enderror">
                                        <option value="" class="text-gray-400">No category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}
                                                @if($cat->children->count()) class="font-medium" @endif>
                                                {{ $cat->name }}
                                            </option>
                                            @foreach($cat->children as $child)
                                                <option value="{{ $child->id }}" {{ old('category_id', $product->category_id ?? '') == $child->id ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;— {{ $child->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                                @error('category_id') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pricing & Inventory --}}
                <div class="bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gradient-to-r from-primary-50/50 to-transparent dark:from-primary-900/10 dark:to-transparent">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Pricing &amp; Inventory</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Price, stock quantity, and unit</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            {{-- Price --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Price (Rs.) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-medium text-gray-400 pointer-events-none">Rs.</span>
                                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price ?? '') }}" required
                                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('price') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="0.00">
                                </div>
                                @error('price') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>
                            {{-- Compare Price --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Compare Price (Rs.)</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-medium text-gray-400 pointer-events-none">Rs.</span>
                                    <input type="number" step="0.01" min="0" name="compare_price" value="{{ old('compare_price', $product->compare_price ?? '') }}"
                                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('compare_price') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="0.00">
                                </div>
                                @error('compare_price') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            {{-- Stock --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Stock Quantity <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <input type="number" min="0" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required
                                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('stock_quantity') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="0">
                                </div>
                                @error('stock_quantity') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>
                            {{-- Unit --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Unit</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 4h20M2 8h20M2 12h20M2 16h20M2 20h20"/>
                                    </svg>
                                    <input type="text" name="unit" value="{{ old('unit', $product->unit ?? '') }}"
                                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('unit') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="e.g. kg, piece, liter">
                                </div>
                                @error('unit') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Status & Featured --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Status</label>
                                <div class="relative">
                                    <select name="status" required
                                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 pr-8 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition appearance-none">
                                        @foreach($statuses as $s)
                                            <option value="{{ $s }}" {{ old('status', $product->status ?? 'draft') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>

                            {{-- Featured --}}
                            <div class="flex items-end pb-1">
                                <label class="relative inline-flex items-center gap-3 cursor-pointer">
                                    <input type="hidden" name="featured" value="0">
                                    <input type="checkbox" name="featured" value="1"
                                           class="sr-only peer"
                                           {{ old('featured', $product->featured ?? false) ? 'checked' : '' }}>
                                    <div class="w-10 h-6 rounded-full bg-gray-200 dark:bg-gray-600 peer-checked:bg-primary-500 peer-focus:ring-2 peer-focus:ring-primary-500/30 transition-colors relative after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-4"></div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Featured product</span>
                                        <span class="text-xs text-gray-400">Show in featured listings</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        </div>
                        </div>

                {{-- === Product Images === --}}
                <div class="bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gradient-to-r from-sky-50/50 to-transparent dark:from-sky-900/10 dark:to-transparent">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-sky-50 to-sky-100 dark:from-sky-900/30 dark:to-sky-800/20 flex items-center justify-center text-sky-600 dark:text-sky-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Product Images</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Add images via URL links or upload files</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        {{-- Current images preview --}}
                        @if(isset($product) && is_array($product->images) && count($product->images) > 0)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Current Images
                                    <span class="text-xs text-gray-400 font-normal ml-2">(click X to remove)</span>
                                </label>
                                <div class="flex flex-wrap gap-3" id="current-images-list">
                                    @foreach($product->images as $img)
                                        <div class="current-image-item relative w-20 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm group" data-image="{{ $img }}">
                                            <img src="{{ $img }}" alt="" class="w-20 h-20 object-cover" onerror="this.closest('.current-image-item').style.display='none'">
                                            <button type="button" onclick="deleteCurrentImage(this)"
                                                    class="absolute top-1 right-1 w-5 h-5 rounded-full bg-black/50 hover:bg-red-500 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                                                    title="Remove this image">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="undoDeleteCurrentImage(this)"
                                                    class="undo-btn absolute inset-0 bg-green-500/80 text-white text-xs font-semibold hidden items-center justify-center cursor-pointer"
                                                    title="Undo remove">
                                                Undo
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="delete-images-container"></div>
                            </div>
                        @endif

                        {{-- Source toggle --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image Source</label>
                            <div class="flex gap-5">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="images_source" value="url" class="text-primary-600 focus:ring-primary-500" checked onclick="toggleImageSource('url')">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">URL Links</span>
                                </label>
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="images_source" value="upload" onclick="toggleImageSource('upload')">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Upload Files</span>
                                </label>
                            </div>
                        </div>

                        {{-- URL input --}}
                        <div id="images-url-section">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Image URLs</label>
                            <div class="relative">
                                <svg class="absolute left-3.5 top-3.5 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                <textarea name="images_url" rows="3" placeholder="https://example.com/image1.jpg, https://example.com/image2.jpg"
                                          class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition font-mono">{{ old('images_url', isset($product) && is_array($product->images) ? implode(', ', $product->images) : '') }}</textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-400">Enter image URLs separated by commas</p>
                        </div>

                        {{-- Upload input --}}
                        <div id="images-upload-section" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Upload Images</label>
                            <input type="file" name="upload_images[]" multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-sky-50 dark:file:bg-sky-900/30 file:text-sky-700 dark:file:text-sky-300 hover:file:bg-sky-100 dark:hover:file:bg-sky-900/40 transition cursor-pointer file:cursor-pointer">
                            <p class="mt-1 text-xs text-gray-400">Select multiple images (JPEG, PNG, WebP). Max 2MB each.</p>
                            @error('upload_images.*') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        <p class="text-xs text-gray-400">Images are stored as a JSON array. URLs are stored as-is; uploaded files are saved to storage.</p>
                    </div>
                </div>
            </div>

            {{-- === TAB: Shipping === --}}
            <div class="tab-panel pt-0 space-y-5" id="panel-shipping" style="display: none;">
                <div class="bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gradient-to-r from-amber-50/50 to-transparent dark:from-amber-900/10 dark:to-transparent">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Shipping Details</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Weight, dimensions &amp; packaging</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        {{-- Weight --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Weight (kg)</label>
                            <div class="relative">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                                <input type="number" step="0.01" min="0" name="weight" value="{{ old('weight', $product->weight ?? '') }}"
                                       class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('weight') border-red-500 dark:border-red-500 @enderror"
                                       placeholder="e.g. 1.5">
                            </div>
                            @error('weight') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Dimensions --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dimensions (cm)</label>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="relative">
                                    <input type="number" step="0.01" min="0" name="length" value="{{ old('length', $product->length ?? '') }}"
                                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-3 pr-8 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('length') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="Length">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">cm</span>
                                </div>
                                <div class="relative">
                                    <input type="number" step="0.01" min="0" name="width" value="{{ old('width', $product->width ?? '') }}"
                                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-3 pr-8 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('width') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="Width">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">cm</span>
                                </div>
                                <div class="relative">
                                    <input type="number" step="0.01" min="0" name="height" value="{{ old('height', $product->height ?? '') }}"
                                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-3 pr-8 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('height') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="Height">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">cm</span>
                                </div>
                            </div>
                            @error('length') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            @error('width') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            @error('height') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Items in Pack --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Items in Pack</label>
                            <div class="relative">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <input type="number" min="0" name="items_in_pack" value="{{ old('items_in_pack', $product->items_in_pack ?? '') }}"
                                       class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('items_in_pack') border-red-500 dark:border-red-500 @enderror"
                                       placeholder="e.g. 12">
                                </div>
                                @error('items_in_pack') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- === TAB: Features === --}}
            <div class="tab-panel pt-0 space-y-5" id="panel-features" style="display: none;">
                @if(isset($features) && $features->count())
                <div class="bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gradient-to-r from-purple-50/50 to-transparent dark:from-purple-900/10 dark:to-transparent">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/20 flex items-center justify-center text-purple-600 dark:text-purple-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Product Features</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Dynamic attributes defined in the Features manager</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        @foreach($features as $feature)
                            @php
                                $pivotValue = isset($product) ? $product->features->find($feature->id)?->pivot?->value ?? '' : old("features.{$feature->id}", '');
                            @endphp
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ $feature->name }}
                                </label>

                                @switch($feature->type)
                                    @case('text')
                                        <input type="text" name="features[{{ $feature->id }}]" value="{{ $pivotValue }}"
                                               class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                                               placeholder="Enter {{ strtolower($feature->name) }}…">
                                        @break

                                    @case('boolean')
                                        <label class="relative inline-flex items-center gap-3 cursor-pointer mt-1">
                                            <input type="hidden" name="features[{{ $feature->id }}]" value="0">
                                            <input type="checkbox" name="features[{{ $feature->id }}]" value="1"
                                                   class="sr-only peer"
                                                   {{ $pivotValue == '1' ? 'checked' : '' }}>
                                            <div class="w-10 h-6 rounded-full bg-gray-200 dark:bg-gray-600 peer-checked:bg-green-500 peer-focus:ring-2 peer-focus:ring-green-500/30 transition-colors relative after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-4"></div>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $feature->name }} enabled</span>
                                        </label>
                                        @break

                                    @case('select')
                                        <select name="features[{{ $feature->id }}]"
                                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 pr-8 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition appearance-none">
                                            <option value="">Select {{ strtolower($feature->name) }}…</option>
                                            @if(is_array($feature->options))
                                                @foreach($feature->options as $opt)
                                                    <option value="{{ $opt['value'] ?? $opt['label'] ?? $opt }}" {{ $pivotValue == ($opt['value'] ?? $opt['label'] ?? $opt) ? 'selected' : '' }}>
                                                        {{ $opt['label'] ?? $opt['value'] ?? $opt }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @break

                                    @case('multi_select')
                                        <div class="space-y-2 mt-1">
                                            @php $selectedValues = $pivotValue ? explode(', ', $pivotValue) : []; @endphp
                                            @if(is_array($feature->options))
                                                @foreach($feature->options as $opt)
                                                    @php
                                                        $optValue = $opt['value'] ?? $opt['label'] ?? $opt;
                                                        $optLabel = $opt['label'] ?? $opt['value'] ?? $opt;
                                                    @endphp
                                                    <label class="inline-flex items-center gap-2 mr-4 mb-2 cursor-pointer">
                                                        <input type="checkbox" name="features[{{ $feature->id }}][]" value="{{ $optValue }}"
                                                               class="rounded border-gray-300 dark:border-gray-600 text-primary-600 focus:ring-primary-500 dark:bg-gray-700"
                                                               {{ in_array($optValue, $selectedValues) ? 'checked' : '' }}>
                                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $optLabel }}</span>
                                                    </label>
                                                @endforeach
                                            @endif
                                        </div>
                                        @break
                                @endswitch
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                    <div class="bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 overflow-hidden">
                        <div class="p-12 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No features defined yet.</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Add features in the <a href="{{ route('admin.features.index') }}" class="text-primary-600 dark:text-primary-400 underline">Features manager</a> to customize product attributes.</p>
                        </div>
                    </div>
                @endif
            </div>
                </div>
            </div>

        </form>
    @endsection

<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
    document.getElementById('panel-' + tab).style.display = 'block';
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-primary-600', 'text-primary-600', 'dark:text-primary-400', 'dark:border-primary-400');
        btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300');
        btn.setAttribute('aria-selected', 'false');
    });
    const activeBtn = document.getElementById('tab-' + tab);
    activeBtn.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300');
    activeBtn.classList.add('border-primary-600', 'text-primary-600', 'dark:text-primary-400', 'dark:border-primary-400');
    activeBtn.setAttribute('aria-selected', 'true');
}

function toggleImageSource(source) {
    document.getElementById('images-url-section').style.display = source === 'url' ? 'block' : 'none';
    document.getElementById('images-upload-section').style.display = source === 'upload' ? 'block' : 'none';
}

function deleteCurrentImage(btn) {
    const item = btn.closest('.current-image-item');
    const imgUrl = item.dataset.image;
    // Add hidden input tracking deletion
    const container = document.getElementById('delete-images-container');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'delete_images[]';
    input.value = imgUrl;
    input.id = 'del-' + btoa(imgUrl).replace(/[/+=]/g, '_');
    container.appendChild(input);
    // Hide the image, show undo button
    btn.classList.add('hidden');
    item.querySelector('img').classList.add('hidden');
    item.querySelector('.undo-btn').classList.remove('hidden');
    item.querySelector('.undo-btn').classList.add('flex');
}

function undoDeleteCurrentImage(btn) {
    const item = btn.closest('.current-image-item');
    const imgUrl = item.dataset.image;
    // Remove the hidden input
    const input = document.getElementById('del-' + btoa(imgUrl).replace(/[/+=]/g, '_'));
    if (input) input.remove();
    // Restore image and X button
    btn.classList.remove('flex');
    btn.classList.add('hidden');
    item.querySelector('img').classList.remove('hidden');
    item.querySelector('button[onclick*="deleteCurrentImage"]').classList.remove('hidden');
}

// Initialize with General tab selected
document.addEventListener('DOMContentLoaded', () => switchTab('general'));
</script>

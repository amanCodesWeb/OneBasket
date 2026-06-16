@extends('layouts.admin')

@section('title', $product->name)
@section('heading', $product->name)

@section('content')
    {{-- Back link --}}
    <div class="mb-5 fade-in">
        <a href="{{ route('admin.products.index') }}" 
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Products
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main info column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Product header card --}}
            <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                <div class="flex items-start gap-4 mb-6">
                    @if($product->thumbnail)
                        <img src="{{ $product->thumbnail }}" alt="" class="w-16 h-16 rounded-xl object-cover ring-2 ring-gray-200 dark:ring-gray-700">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 text-xl font-bold ring-2 ring-gray-200 dark:ring-gray-700">
                            {{ substr($product->name, 0, 2) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $product->name }}</h3>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($product->status)
                                    @case('active') bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 ring-1 ring-green-200 dark:ring-green-800 @break
                                    @case('inactive') bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 ring-1 ring-gray-200 dark:ring-gray-600 @break
                                    @case('draft') bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 ring-1 ring-amber-200 dark:ring-amber-800 @break
                                    @default bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 ring-1 ring-gray-200 dark:ring-gray-600
                                @endswitch
                            ">
                                @switch($product->status)
                                    @case('active') <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> @break
                                    @case('inactive') <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> @break
                                    @case('draft') <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> @break
                                @endswitch
                                {{ ucfirst($product->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            {{ $product->vendor?->business_name }}
                            <span class="text-gray-300 dark:text-gray-600">·</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ $product->category?->name ?? 'Uncategorized' }}
                        </p>
                    </div>
                    @if($product->featured)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-xs font-medium ring-1 ring-amber-200 dark:ring-amber-800">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Featured
                        </span>
                    @endif
                </div>

                {{-- Divider --}}
                <div class="section-divider mb-5"></div>

                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Product Details
                </h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div class="flex items-center justify-between sm:flex-col sm:items-start sm:justify-start p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                        <dt class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Price</dt>
                        <dd class="text-gray-900 dark:text-white font-semibold text-base mt-0.5">Rs. {{ number_format($product->price, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between sm:flex-col sm:items-start sm:justify-start p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                        <dt class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Compare Price</dt>
                        <dd class="text-gray-900 dark:text-white mt-0.5">{{ $product->compare_price ? 'Rs. '.number_format($product->compare_price, 2) : '—' }}</dd>
                    </div>
                    <div class="flex items-center justify-between sm:flex-col sm:items-start sm:justify-start p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                        <dt class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Discount</dt>
                        <dd class="mt-0.5">
                            @if($product->hasDiscount)
                                <span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400 font-medium">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $product->discount_percent }}% off
                                </span>
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                    <div class="flex items-center justify-between sm:flex-col sm:items-start sm:justify-start p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                        <dt class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Stock Quantity</dt>
                        <dd class="mt-0.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                @if($product->stock_quantity > 10) bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 ring-1 ring-green-200 dark:ring-green-800
                                @elseif($product->stock_quantity > 0) bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 ring-1 ring-amber-200 dark:ring-amber-800
                                @else bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 ring-1 ring-red-200 dark:ring-red-800 @endif">
                                {{ $product->stock_quantity }} {{ $product->unit ?? 'units' }}
                            </span>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between sm:flex-col sm:items-start sm:justify-start p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                        <dt class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Unit</dt>
                        <dd class="text-gray-900 dark:text-white mt-0.5 font-medium">{{ $product->unit ?? '—' }}</dd>
                    </div>
                    <div class="flex items-center justify-between sm:flex-col sm:items-start sm:justify-start p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                        <dt class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Slug</dt>
                        <dd class="text-gray-900 dark:text-white mt-0.5 font-mono text-xs truncate max-w-full">{{ $product->slug }}</dd>
                    </div>
                    <div class="flex items-center justify-between sm:flex-col sm:items-start sm:justify-start p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                        <dt class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Created</dt>
                        <dd class="text-gray-900 dark:text-white mt-0.5 text-xs">{{ $product->created_at->format('M d, Y \\a\\t g:i A') }}</dd>
                    </div>
                    <div class="flex items-center justify-between sm:flex-col sm:items-start sm:justify-start p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                        <dt class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Last Updated</dt>
                        <dd class="text-gray-900 dark:text-white mt-0.5 text-xs">{{ $product->updated_at->format('M d, Y \\a\\t g:i A') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Description --}}
            @if($product->description)
                <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        Description
                    </h3>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                        <p class="text-gray-900 dark:text-white text-sm whitespace-pre-line leading-relaxed">{{ $product->description }}</p>
                    </div>
                </div>
            @endif

            {{-- Images --}}
            @if($product->images && count($product->images))
                <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Images
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($product->images as $image)
                            <div class="relative group rounded-lg overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700">
                                <img src="{{ $image }}" alt="" class="w-full h-28 object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- Actions card --}}
            <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="inline-flex items-center justify-center gap-2 w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md hover:shadow-primary-500/20">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Product
                    </a>

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
                            <button type="submit" 
                                    class="inline-flex items-center justify-center gap-2 w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md hover:shadow-green-500/20">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Set Active
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Quick Links
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="flex items-center gap-3 p-2.5 rounded-lg text-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-700 dark:hover:text-primary-300 transition-all group">
                        <span class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 group-hover:text-primary-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </span>
                        Edit product &rarr;
                    </a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                          onsubmit="return confirm('Delete this product? This cannot be undone.')" class="block">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                class="flex items-center gap-3 w-full p-2.5 rounded-lg text-sm text-gray-600 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 transition-all group">
                            <span class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:bg-red-100 dark:group-hover:bg-red-900/30 group-hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </span>
                            Delete product
                        </button>
                    </form>
                </div>
            </div>

            {{-- Meta info card --}}
            <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Meta
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-500 dark:text-gray-400">ID</span>
                        <span class="text-gray-900 dark:text-white font-mono text-xs">#{{ $product->id }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-500 dark:text-gray-400">Featured</span>
                        <span class="text-gray-900 dark:text-white">
                            @if($product->featured)
                                <span class="text-green-600 dark:text-green-400 font-medium">Yes</span>
                            @else
                                <span class="text-gray-400">No</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-500 dark:text-gray-400">Created</span>
                        <span class="text-gray-900 dark:text-white text-xs">{{ $product->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

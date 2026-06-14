@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Products</a>
        @if($product->category)
            <span class="mx-2">/</span>
            <a href="{{ route('categories.show', $product->category) }}" class="hover:text-primary-600 dark:hover:text-primary-400">{{ $product->category->name }}</a>
        @endif
        <span class="mx-2">/</span>
        <span class="text-gray-900 dark:text-white">{{ $product->name }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        {{-- Image --}}
        <div class="aspect-square bg-gray-50 dark:bg-gray-900 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            @if($product->thumbnail)
                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                    <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Details --}}
        <div>
            @if($product->vendor)
                <p class="text-sm text-primary-600 dark:text-primary-400 font-medium mb-1">{{ $product->vendor->business_name }}</p>
            @endif
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>

            <div class="mt-4 flex items-baseline gap-3">
                <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $product->formatted_price }}</span>
                @if($product->hasDiscount)
                    <span class="text-lg text-gray-400 line-through">{{ $product->formatted_compare_price }}</span>
                    <span class="bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm font-semibold px-2.5 py-0.5 rounded-full">Save {{ $product->discount_percent }}%</span>
                @endif
            </div>

            @if($product->unit)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Per {{ $product->unit }}</p>
            @endif

            {{-- Stock status --}}
            <div class="mt-6">
                @if($product->stock_quantity > 0)
                    <span class="inline-flex items-center gap-1 text-sm text-green-600 dark:text-green-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        In Stock ({{ $product->stock_quantity }} {{ $product->unit }})
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-sm text-red-500">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        Out of Stock
                    </span>
                @endif
            </div>

            {{-- Description --}}
            @if($product->description)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Description</h3>
                    <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                </div>
            @endif

            {{-- Vendor Info --}}
            @if($product->vendor)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Sold by</h3>
                    <a href="{{ route('products.index', ['vendor' => $product->vendor->slug]) }}" class="flex items-center gap-3 group">
                        @if($product->vendor->logo)
                            <img src="{{ $product->vendor->logo }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold">
                                {{ substr($product->vendor->business_name, 0, 2) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400">{{ $product->vendor->business_name }}</p>
                            <p class="text-xs text-gray-400">Delivery radius: {{ $product->vendor->delivery_radius_km }}km</p>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
        <section class="mt-16">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Products</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $products->total() }} products found</p>
    </div>

    {{-- Search & Filters --}}
    <form method="GET" action="{{ route('products.index') }}" class="mb-8 flex flex-col sm:flex-row gap-3">
        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
               class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
        <select name="category" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="vendor" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
            <option value="">All Vendors</option>
            @foreach($vendors as $v)
                <option value="{{ $v->slug }}" {{ request('vendor') === $v->slug ? 'selected' : '' }}>{{ $v->business_name }}</option>
            @endforeach
        </select>
        <select name="sort" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
        </select>
        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition">Filter</button>
        @if(request()->anyFilled(['search','category','vendor','sort']))
            <a href="{{ route('products.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline self-center">Clear</a>
        @endif
    </form>

    @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium mb-1">No products found</p>
            <p class="text-gray-400 dark:text-gray-500 text-sm">Try adjusting your filters.</p>
        </div>
    @endif
</div>
@endsection

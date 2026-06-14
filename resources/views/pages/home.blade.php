@extends('layouts.app')

@section('title', 'OneBasket — Shop Local')

@section('content')
{{-- Hero section --}}
<div class="relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-teal-800 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                Shop from multiple stores.
                <span class="text-amber-300">One delivery.</span>
            </h1>
            <p class="mt-4 text-lg text-primary-100 dark:text-gray-300">
                Fresh groceries, baked goods, and daily essentials — delivered together from your local vendors.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('products.index') }}" class="bg-white text-primary-700 hover:bg-primary-50 px-8 py-3 rounded-xl font-semibold transition shadow-lg text-sm sm:text-base">
                    Browse Products
                </a>
                <a href="{{ route('categories.index') }}" class="bg-primary-500/20 backdrop-blur-sm text-white border border-white/20 hover:bg-primary-500/30 px-8 py-3 rounded-xl font-semibold transition text-sm sm:text-base">
                    Shop by Category
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Featured Products --}}
    @if($featured->count())
        <section class="mb-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Featured Products</h2>
                <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">View all &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($featured as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Shop by Category --}}
    @if($categories->count())
        <section class="mb-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Shop by Category</h2>
                <a href="{{ route('categories.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">All categories &rarr;</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 text-center hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-md transition">
                        <div class="w-12 h-12 mx-auto rounded-lg bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            @switch($category->slug)
                                @case('groceries') 🍎 @break
                                @case('bakery') 🥖 @break
                                @case('dairy') 🥛 @break
                                @case('beverages') 🥤 @break
                                @case('snacks') 🍪 @break
                                @case('pharmacy') 💊 @break
                                @case('personal-care') 🧴 @break
                                @default 🛒
                            @endswitch
                        </div>
                        <h3 class="mt-3 text-sm font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400">{{ $category->name }}</h3>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- New Arrivals --}}
    @if($newProducts->count())
        <section class="mb-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">New Arrivals</h2>
                <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">View all &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($newProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Local Vendors --}}
    @if($vendors->count())
        <section class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Our Vendors</h2>
                <a href="{{ route('vendors.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">Meet all vendors &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($vendors as $vendor)
                    <a href="{{ route('products.index', ['vendor' => $vendor->slug]) }}" class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-md transition flex items-center gap-4">
                        @if($vendor->logo)
                            <img src="{{ $vendor->logo }}" alt="" class="w-12 h-12 rounded-xl object-cover">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold">
                                {{ substr($vendor->business_name, 0, 2) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400">{{ $vendor->business_name }}</h3>
                            <p class="text-xs text-gray-400">{{ $vendor->products_count ?? 'Free' }} delivery</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

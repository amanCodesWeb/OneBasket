@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-8 slide-up" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            Home
        </a>
        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
        <a href="{{ route('products.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition">Products</a>
        @if($product->category)
            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <a href="{{ route('categories.show', $product->category) }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition">{{ $product->category->name }}</a>
        @endif
        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
        <span class="text-gray-900 dark:text-white font-medium truncate max-w-[200px]">{{ $product->name }}</span>
    </nav>

    {{-- Main product layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

        {{-- Image --}}
        <div class="slide-up">
            <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800/80 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-lg shadow-gray-200/50 dark:shadow-black/20 relative group">
                @if($product->thumbnail)
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                        <svg class="w-32 h-32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                @endif
                {{-- Badges --}}
                @if($product->hasDiscount)
                    <span class="absolute top-4 left-4 bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-lg shadow-lg shadow-red-500/20 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                        -{{ $product->discount_percent }}%
                    </span>
                @endif
                @if($product->featured)
                    <span class="absolute top-4 right-4 bg-amber-500 text-white text-sm font-bold px-3 py-1 rounded-lg shadow-lg shadow-amber-500/20">Featured</span>
                @endif
            </div>
        </div>

        {{-- Details --}}
        <div class="slide-up" style="animation-delay: 0.1s">
            {{-- Vendor label --}}
            @if($product->vendor)
                <a href="{{ route('products.index', ['vendor' => $product->vendor->slug]) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition mb-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                    </svg>
                    {{ $product->vendor->business_name }}
                </a>
            @endif

            {{-- Title --}}
            <h1 class="text-2xl lg:text-4xl font-bold text-gray-900 dark:text-white leading-tight">{{ $product->name }}</h1>

            {{-- Price --}}
            <div class="mt-5 flex items-baseline gap-3">
                <span class="text-4xl font-bold text-gray-900 dark:text-white">{{ $product->formatted_price }}</span>
                @if($product->hasDiscount)
                    <span class="text-xl text-gray-400 line-through">{{ $product->formatted_compare_price }}</span>
                    <span class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-sm font-bold px-3 py-1 rounded-full border border-red-200 dark:border-red-800">Save {{ $product->discount_percent }}%</span>
                @endif
            </div>

            @if($product->unit)
                <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">Per {{ $product->unit }}</p>
            @endif

            {{-- Stock status --}}
            <div class="mt-6">
                @if($product->stock_quantity > 0)
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-3 py-1.5 rounded-full border border-green-200 dark:border-green-800">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            In Stock
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">({{ $product->stock_quantity }} {{ $product->unit }} available)</span>
                    </div>
                    {{-- Stock bar --}}
                    @php $maxStock = 100; $stockPct = min(100, ($product->stock_quantity / $maxStock) * 100); @endphp
                    <div class="mt-2 w-full max-w-xs h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-green-400 to-green-500 transition-all duration-700" style="width: {{ $stockPct }}%"></div>
                    </div>
                @else
                    <span class="inline-flex items-center gap-1.5 text-sm font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-1.5 rounded-full border border-red-200 dark:border-red-800">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        Out of Stock
                    </span>
                @endif
            </div>

            {{-- Add to Cart --}}
            @auth
                @if($product->stock_quantity > 0)
                    <form method="POST" action="{{ route('cart.add') }}" class="mt-6 flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-xl overflow-hidden shadow-sm bg-white dark:bg-gray-800">
                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.parentNode.querySelector('input[type=number]').dispatchEvent(new Event('change'))"
                                    class="w-11 h-11 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition text-lg font-medium">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
                                </svg>
                            </button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                   class="w-16 text-center border-x border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-semibold text-gray-900 dark:text-white focus:ring-0 outline-none py-2 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.parentNode.querySelector('input[type=number]').dispatchEvent(new Event('change'))"
                                    class="w-11 h-11 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition text-lg font-medium">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                            </button>
                        </div>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white px-8 py-3 rounded-xl font-semibold transition shadow-lg shadow-primary-600/25 hover:shadow-primary-600/40">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-8h9.464c.571 0 1.036.433 1.086 1.002l.526 6.823a1.5 1.5 0 01-1.494 1.675H10.5m0 0a3 3 0 00-3 3m3 0a3 3 0 00-3-3m3 3a3 3 0 013 0m-3-3a3 3 0 013 3m-9.75-3h1.965a.75.75 0 00.743-.667l.142-1.143M2.25 6.75h18M7.5 14.25a3 3 0 013 3"/>
                            </svg>
                            Add to Cart
                        </button>
                    </form>
                @else
                    <button disabled class="mt-6 w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 px-8 py-3 rounded-xl font-semibold cursor-not-allowed border border-gray-200 dark:border-gray-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        Out of Stock
                    </button>
                @endif
            @else
                <div class="mt-6 p-4 bg-primary-50 dark:bg-primary-900/20 rounded-xl border border-primary-200 dark:border-primary-800">
                    <p class="text-sm text-primary-700 dark:text-primary-300 mb-3">
                        <span class="font-semibold">Sign in</span> to add items to your cart.
                    </p>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg font-semibold transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                        Login to Purchase
                    </a>
                </div>
            @endauth

            {{-- Description --}}
            @if($product->description)
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 slide-up" style="animation-delay: 0.2s">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="h-px flex-1 bg-gradient-to-r from-primary-500/30 to-transparent"></div>
                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Description</h3>
                        <div class="h-px flex-1 bg-gradient-to-l from-primary-500/30 to-transparent"></div>
                    </div>
                    <div class="bg-white dark:bg-gray-800/40 rounded-xl p-5 border border-gray-100 dark:border-gray-700/50">
                        <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                </div>
            @endif

            {{-- Vendor Info --}}
            @if($product->vendor)
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 slide-up" style="animation-delay: 0.3s">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="h-px flex-1 bg-gradient-to-r from-primary-500/30 to-transparent"></div>
                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Sold by</h3>
                        <div class="h-px flex-1 bg-gradient-to-l from-primary-500/30 to-transparent"></div>
                    </div>
                    <a href="{{ route('products.index', ['vendor' => $product->vendor->slug]) }}" class="flex items-center gap-4 group bg-white dark:bg-gray-800/40 rounded-xl p-4 border border-gray-100 dark:border-gray-700/50 hover:border-primary-200 dark:hover:border-primary-700/50 hover:shadow-md transition card-hover">
                        @if($product->vendor->logo)
                            <img src="{{ $product->vendor->logo }}" alt="" class="w-14 h-14 rounded-xl object-cover ring-2 ring-gray-100 dark:ring-gray-700">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                {{ substr($product->vendor->business_name, 0, 2) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition truncate">{{ $product->vendor->business_name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                    </svg>
                                    Delivery radius: {{ $product->vendor->delivery_radius_km }}km
                                </span>
                            </p>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 group-hover:text-primary-500 transition -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
        <section class="mt-16 lg:mt-20 slide-up" style="animation-delay: 0.4s">
            <div class="flex items-center gap-4 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">You Might Also Like</h2>
                <div class="h-px flex-1 bg-gradient-to-l from-gray-200 dark:from-gray-700 to-transparent"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($related as $item)
                    <div class="fade-in" style="animation-delay: {{ $loop->index * 0.06 }}s">
                        <x-product-card :product="$item" />
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

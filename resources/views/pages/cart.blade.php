@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 fade-in">

    {{-- Page header with gradient text --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
        <div class="slide-up">
            <h1 class="text-3xl font-bold gradient-text">Shopping Cart</h1>
            @if($cartItems->count())
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ $itemCount }} {{ Str::plural('item', $itemCount) }} in your cart
                    </span>
                </p>
            @endif
        </div>
        @if($cartItems->count())
            <div class="flex items-center gap-3 slide-up delay-100">
                <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Clear your entire cart?')">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-400 transition px-3 py-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Clear Cart
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Session messages --}}
    @if(session('success'))
        <div class="mb-8 p-4 rounded-xl bg-primary-50 dark:bg-primary-900/15 border border-primary-200 dark:border-primary-800/50 text-sm text-primary-700 dark:text-primary-300 slide-up flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-8 p-4 rounded-xl bg-red-50 dark:bg-red-900/15 border border-red-200 dark:border-red-800/50 text-sm text-red-700 dark:text-red-300 slide-up flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if($cartItems->count())
        {{-- Grouped by vendor --}}
        @foreach($grouped as $vendorName => $items)
            <div class="mb-8 slide-up card-glow rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                {{-- Vendor header with teal accent strip --}}
                <div class="relative px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-primary-50/80 via-white to-white dark:from-primary-900/10 dark:via-gray-800 dark:to-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h2 class="font-semibold text-gray-900 dark:text-white">{{ $vendorName }}</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full">{{ $items->count() }} {{ Str::plural('item', $items->count()) }}</span>
                    </div>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700/50 stagger-children">
                    @foreach($items as $item)
                        <div class="flex items-center gap-4 px-6 py-5 hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                            {{-- Product image with hover zoom --}}
                            <a href="{{ route('products.show', $item->product->slug) }}" class="w-20 h-20 rounded-xl bg-gray-50 dark:bg-gray-900 overflow-hidden shrink-0 ring-1 ring-gray-200 dark:ring-gray-700 group">
                                @if($item->product->thumbnail)
                                    <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600 transition-transform duration-300 group-hover:scale-110">
                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            {{-- Product info --}}
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="text-sm font-semibold text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition line-clamp-1">
                                    {{ $item->product->name }}
                                </a>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $item->formatted_unit_price }} / {{ $item->product->unit ?? 'each' }}</p>
                                @if($item->product->stock_quantity < 5)
                                    <p class="inline-flex items-center gap-1 text-xs text-amber-600 dark:text-amber-400 mt-1.5 bg-amber-50 dark:bg-amber-900/20 px-2 py-0.5 rounded-full">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Only {{ $item->product->stock_quantity }} left
                                    </p>
                                @endif
                            </div>

                            {{-- Quantity controls with modern styling --}}
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-0.5 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-0.5">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.parentNode.querySelector('input[type=number]').dispatchEvent(new Event('change'))"
                                            class="w-8 h-8 rounded-md flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400 transition text-base font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}"
                                           class="w-12 text-center rounded-md border-0 bg-transparent text-sm font-semibold text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none py-1.5 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                           onchange="this.form.submit()">
                                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.parentNode.querySelector('input[type=number]').dispatchEvent(new Event('change'))"
                                            class="w-8 h-8 rounded-md flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400 transition text-base font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-right min-w-[90px]">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->formatted_subtotal }}</p>
                                @if($item->quantity > 1)
                                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">{{ $item->formatted_unit_price }} each</p>
                                @endif
                            </div>

                            {{-- Remove button with animated hover --}}
                            <form method="POST" action="{{ route('cart.remove', $item) }}" onsubmit="return confirm('Remove this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-gray-300 dark:text-gray-600 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 group" title="Remove item">
                                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Cart Summary & Checkout — elevated card --}}
        <div class="slide-up delay-300 bg-gradient-to-br from-white to-primary-50/30 dark:from-gray-800 dark:to-gray-800/80 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 sm:p-8 card-hover">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div class="space-y-1">
                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Subtotal ({{ $itemCount }} {{ Str::plural('item', $itemCount) }})
                    </p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">Rs. {{ number_format($subtotal, 2) }}</p>
                </div>
                <a href="{{ route('checkout.review') }}" class="group inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-10 py-3.5 rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-primary-600/20 hover:shadow-primary-600/30 active:scale-[0.98]">
                    Proceed to Checkout
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    @else
        {{-- Enhanced empty state --}}
        <div class="text-center py-24 px-6 bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-200 dark:border-gray-700 relative overflow-hidden slide-up">
            {{-- Decorative background circles --}}
            <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-primary-100/50 dark:bg-primary-900/10 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-60 h-60 rounded-full bg-primary-50/50 dark:bg-primary-900/5 blur-3xl"></div>

            <div class="relative">
                {{-- Shopping basket illustration --}}
                <div class="w-24 h-24 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 flex items-center justify-center float">
                    <svg class="w-12 h-12 text-primary-400 dark:text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h-4.5m7.5 0h-3m7.5-3.75h3.75m-11.25 3.75H16.5m0 0a3 3 0 00-3 3m3-3a3 3 0 013 3m-3-3H9.75m0 0a3 3 0 00-3 3M6.75 6.75L5.4 5.4M6.75 6.75h12.75l-1.5 6H8.25l-1.5-6m0 0L5.4 5.4M6.75 6.75H4.5"/>
                    </svg>
                </div>

                {{-- Text --}}
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Your cart is empty</h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">
                    Looks like you haven't added anything yet. Explore our products and discover fresh groceries delivered to your door.
                </p>

                {{-- CTA buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('products.index') }}" class="group inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-7 py-3 rounded-xl font-medium transition-all duration-200 shadow-md shadow-primary-600/20 hover:shadow-primary-600/30 active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                        Browse Products
                    </a>
                    <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition px-5 py-3 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 hover:bg-primary-50/50 dark:hover:bg-primary-900/10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                        Browse Categories
                    </a>
                </div>

                {{-- Helpful quick links --}}
                <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-700/50">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mb-4 uppercase tracking-wider font-medium">Discover what's popular</p>
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <a href="{{ route('products.index') }}" class="text-xs px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 hover:bg-primary-100 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400 transition">Fresh Fruits</a>
                        <a href="{{ route('products.index') }}" class="text-xs px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 hover:bg-primary-100 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400 transition">Vegetables</a>
                        <a href="{{ route('products.index') }}" class="text-xs px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 hover:bg-primary-100 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400 transition">Dairy & Eggs</a>
                        <a href="{{ route('products.index') }}" class="text-xs px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 hover:bg-primary-100 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400 transition">Bakery</a>
                        <a href="{{ route('products.index') }}" class="text-xs px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 hover:bg-primary-100 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400 transition">Beverages</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

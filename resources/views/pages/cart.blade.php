@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Shopping Cart</h1>
        @if($cartItems->count())
            <div class="flex items-center gap-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $itemCount }} {{ Str::plural('item', $itemCount) }}</p>
                <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Clear your entire cart?')">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-600 transition">Clear Cart</button>
                </form>
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-sm text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-sm text-red-700 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    @if($cartItems->count())
        {{-- Grouped by vendor --}}
        @foreach($grouped as $vendorName => $items)
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h2 class="font-semibold text-gray-900 dark:text-white">{{ $vendorName }}</h2>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($items as $item)
                        <div class="flex items-center gap-4 px-6 py-4">
                            {{-- Product image --}}
                            <a href="{{ route('products.show', $item->product->slug) }}" class="w-16 h-16 rounded-lg bg-gray-50 dark:bg-gray-900 overflow-hidden shrink-0">
                                @if($item->product->thumbnail)
                                    <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            {{-- Product info --}}
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition line-clamp-1">
                                    {{ $item->product->name }}
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $item->formatted_unit_price }} / {{ $item->product->unit ?? 'each' }}</p>
                                @if($item->product->stock_quantity < 5)
                                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-0.5">Only {{ $item->product->stock_quantity }} left</p>
                                @endif
                            </div>

                            {{-- Quantity controls --}}
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.parentNode.querySelector('input[type=number]').dispatchEvent(new Event('change'))"
                                            class="w-8 h-8 rounded-lg border border-gray-300 dark:border-gray-600 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm font-medium">
                                        −
                                    </button>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}"
                                           class="w-14 text-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none py-1.5"
                                           onchange="this.form.submit()">
                                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.parentNode.querySelector('input[type=number]').dispatchEvent(new Event('change'))"
                                            class="w-8 h-8 rounded-lg border border-gray-300 dark:border-gray-600 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm font-medium">
                                        +
                                    </button>
                                </form>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-right min-w-[80px]">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item->formatted_subtotal }}</p>
                            </div>

                            {{-- Remove --}}
                            <form method="POST" action="{{ route('cart.remove', $item) }}" onsubmit="return confirm('Remove this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition" title="Remove">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Cart Summary & Checkout --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Subtotal ({{ $itemCount }} {{ Str::plural('item', $itemCount) }})</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rs. {{ number_format($subtotal, 2) }}</p>
                </div>
                <a href="{{ route('checkout.review') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-xl font-semibold transition text-center">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        {{-- Empty cart --}}
        <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
            </svg>
            <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400 mb-1">Your cart is empty</h2>
            <p class="text-sm text-gray-400 dark:text-gray-500 mb-6">Start shopping to add items to your cart.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection

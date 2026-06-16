@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 fade-in">

    {{-- Back link --}}
    <a href="{{ route('cart.index') }}" class="group inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition mb-6">
        <svg class="w-4 h-4 mr-1.5 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Cart
    </a>

    {{-- Page header --}}
    <div class="mb-10 slide-up">
        <h1 class="text-3xl font-bold gradient-text">Checkout</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1.5 flex items-center gap-2">
            <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Review your order before placing it
        </p>
    </div>

    @if(session('error'))
        <div class="mb-8 p-4 rounded-xl bg-red-50 dark:bg-red-900/15 border border-red-200 dark:border-red-800/50 text-sm text-red-700 dark:text-red-300 slide-up flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.place') }}">
        @csrf

        {{-- Items grouped by vendor --}}
        @foreach($grouped as $vendorName => $items)
            <div class="mb-6 slide-up card-glow rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                {{-- Vendor header --}}
                <div class="relative px-6 py-3.5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-primary-50/80 via-white to-white dark:from-primary-900/10 dark:via-gray-800 dark:to-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h2 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $vendorName }}</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full">{{ $items->count() }} {{ Str::plural('item', $items->count()) }}</span>
                    </div>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700/50 stagger-children">
                    @foreach($items as $item)
                        <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                            {{-- Product image --}}
                            <div class="w-14 h-14 rounded-xl bg-gray-50 dark:bg-gray-900 overflow-hidden shrink-0 ring-1 ring-gray-200 dark:ring-gray-700 flex items-center justify-center text-gray-300 dark:text-gray-600">
                                @if($item->product->thumbnail)
                                    <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- Product info --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                    <span class="text-primary-600 dark:text-primary-400 font-medium">{{ $item->formatted_unit_price }}</span>
                                    <span class="mx-1">×</span>
                                    <span>{{ $item->quantity }}</span>
                                </p>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->formatted_subtotal }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Order notes --}}
        <div class="mb-6 slide-up delay-200 card-glow rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-primary-50/80 via-white to-white dark:from-primary-900/10 dark:via-gray-800 dark:to-gray-800">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <label class="text-sm font-semibold text-gray-900 dark:text-white">Order Notes</label>
                    <span class="text-xs text-gray-400 dark:text-gray-500 font-normal">(optional)</span>
                </div>
            </div>
            <div class="p-6">
                <textarea name="notes" rows="3" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all duration-200" placeholder="Any special instructions for the vendor..."></textarea>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Add delivery instructions or notes for your order.</p>
            </div>
        </div>

        {{-- Summary & Place Order --}}
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
                <button type="submit" class="group inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-12 py-3.5 rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-primary-600/20 hover:shadow-primary-600/30 active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Place Order
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

{{-- Extra head for subtle checkout-specific styling --}}
@push('head')
<style>
    /* Smooth number input hide spinner */
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endpush

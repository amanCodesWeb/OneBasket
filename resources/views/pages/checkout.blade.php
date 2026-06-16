@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('cart.index') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Cart
    </a>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Checkout</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Review your order before placing it.</p>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-sm text-red-700 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.place') }}">
        @csrf

        {{-- Items grouped by vendor --}}
        @foreach($grouped as $vendorName => $items)
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h2 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $vendorName }}</h2>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($items as $item)
                        <div class="flex items-center gap-4 px-6 py-4">
                            <div class="w-14 h-14 rounded-lg bg-gray-50 dark:bg-gray-900 overflow-hidden shrink-0 flex items-center justify-center text-gray-300 dark:text-gray-600">
                                @if($item->product->thumbnail)
                                    <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->formatted_unit_price }} × {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item->formatted_subtotal }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Order notes --}}
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order Notes (optional)</label>
            <textarea name="notes" rows="3" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none" placeholder="Any special instructions..."></textarea>
        </div>

        {{-- Summary & Place Order --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Subtotal ({{ $itemCount }} {{ Str::plural('item', $itemCount) }})</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rs. {{ number_format($subtotal, 2) }}</p>
                </div>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-10 py-3 rounded-xl font-semibold transition text-base">
                    Place Order
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

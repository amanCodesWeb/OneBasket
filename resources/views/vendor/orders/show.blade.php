@extends('vendor.layouts.vendor')

@section('title', 'Order #' . $order->order_number)
@section('heading', 'Order #' . $order->order_number)

@section('content')
    <div class="animate-fade-in max-w-3xl">

        {{-- Back link --}}
        <a href="{{ route('vendor.orders.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 mb-4 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to Orders
        </a>

        {{-- Order info card --}}
        <div class="bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 shadow-sm mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order Number</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white font-mono mt-0.5">#{{ $order->order_number }}</p>
                </div>
                <div>
                    {!! $order->status_badge !!}
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-gray-100 dark:border-gray-700/60">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $order->created_at->format('M j, Y') }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $order->created_at->format('g:i A') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Items</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $order->total_item_count }} total</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Your Items</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $vendorItems->count() }} item(s)</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Your Total</p>
                    <p class="text-sm font-bold text-teal-600 dark:text-teal-400 mt-1">Rs. {{ number_format($vendorItems->sum('subtotal'), 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Your Items --}}
        <div class="bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Your Items in this Order</h2>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700/60">
                @foreach($vendorItems as $item)
                    <div class="px-6 py-4 flex items-center gap-4">
                        {{-- Product image --}}
                        <div class="w-14 h-14 rounded-xl bg-gray-100 dark:bg-gray-700 overflow-hidden shrink-0 flex items-center justify-center">
                            @if($item->product && !empty($item->product->images) && is_array($item->product->images) && count($item->product->images) > 0)
                                <img src="{{ $item->product->images[0] }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            @endif
                        </div>

                        {{-- Product details --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $item->product->name ?? 'Product' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Rs. {{ number_format($item->unit_price, 2) }} each</p>
                        </div>

                        {{-- Quantity & subtotal --}}
                        <div class="text-right shrink-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">x{{ $item->quantity }}</p>
                            <p class="text-sm font-bold text-teal-600 dark:text-teal-400">Rs. {{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total summary --}}
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700/60">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Your Subtotal</span>
                    <span class="text-base font-bold text-teal-600 dark:text-teal-400">Rs. {{ number_format($vendorItems->sum('subtotal'), 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Status note --}}
        <div class="mt-4 p-4 rounded-xl bg-amber-50 dark:bg-gray-800/80 border border-amber-200 dark:border-gray-700/50 text-sm text-amber-700 dark:text-gray-300">
            <p class="font-medium">Fulfillment responsibility</p>
            <p class="text-xs mt-1 text-amber-600 dark:text-amber-400">You are responsible for packaging. Once packaging is completed, a delivery agent will pick up the product for delivery.</p>
        </div>

    </div>
@endsection

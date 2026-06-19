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
                    @php $vendorStatusLabel = \App\Models\Order::$vendorStatusLabels[$order->status] ?? $order->status_label; @endphp
                    @php $vendorStatusColor = \App\Models\Order::$vendorStatusColors[$order->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300'; @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border {{ $vendorStatusColor }}">
                        @switch($order->status)
                            @case('pending')
                            @case('confirmed')
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                                @break
                            @case('packed')
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                @break
                            @default
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endswitch
                        {{ $vendorStatusLabel }}
                    </span>
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

        {{-- Vendor actions - quick status update --}}
        @if(!empty($allowedTransitions[$order->status]))
            <div class="mb-6 p-5 rounded-2xl bg-gradient-to-br from-teal-50 to-emerald-50/80 dark:from-teal-900/20 dark:to-emerald-900/10 border border-teal-200/80 dark:border-teal-700/50 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-teal-800 dark:text-teal-300">Update Status</p>
                        <p class="text-xs text-teal-600/70 dark:text-teal-400/60 mt-0.5">
                            Current: <span class="font-medium">{{ $vendorStatusLabels[$order->status] ?? $order->status_label }}</span>
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($allowedTransitions[$order->status] as $transition)
                            <form method="POST" action="{{ route('vendor.orders.update-status', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $transition }}">
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium shadow-sm transition-colors
                                        @switch($transition)
                                            @case('confirmed') bg-sky-600 hover:bg-sky-700 text-white @break
                                            @case('packed') bg-teal-600 hover:bg-teal-700 text-white @break
                                            @case('cancelled') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/50 border border-red-200 dark:border-red-700/50 @break
                                            @default bg-teal-600 hover:bg-teal-700 text-white @endswitch">
                                    @switch($transition)
                                        @case('confirmed')
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                            @break
                                        @case('packed')
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            @break
                                        @case('cancelled')
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            @break
                                    @endswitch
                                    Mark as {{ $vendorStatusLabels[$transition] ?? ucwords(str_replace('_', ' ', $transition)) }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Show picked info when picked up --}}
        @if($order->status === 'picked_up')
            <div class="mb-6 p-5 rounded-2xl bg-green-50 dark:bg-green-900/10 border border-green-200 dark:border-green-700/30 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-green-800 dark:text-green-300">Picked Up</p>
                        <p class="text-xs text-green-600/70 dark:text-green-400/60 mt-0.5">This order has been picked up by the delivery partner.</p>
                    </div>
                </div>
            </div>
        @endif

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

@extends('layouts.app')

@section('title', "Order {$order->order_number}")

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Back link --}}
    <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition mb-8 group slide-up">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        <span>Back to Orders</span>
    </a>

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-sm text-green-700 dark:text-green-300 slide-up delay-100">
            {{ session('success') }}
        </div>
    @endif

    {{-- Order header card --}}
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 slide-up delay-100">
        <div class="absolute top-0 right-0 w-56 h-56 bg-primary-50 dark:bg-primary-900/10 rounded-full blur-3xl -translate-y-1/3 translate-x-1/3 pointer-events-none"></div>
        <div class="relative z-10 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold gradient-text">Order {{ $order->order_number }}</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Placed on {{ $order->created_at->format('F j, Y \\a\\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
                <div>{!! $order->status_badge !!}</div>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>{{ $order->total_item_count }} {{ Str::plural('item', $order->total_item_count) }}</span>
                <span class="text-gray-300 dark:text-gray-600">&middot;</span>
                <span>Total: <span class="font-semibold gradient-text">{{ $order->formatted_subtotal }}</span></span>
            </div>
        </div>
    </div>

    {{-- Order items grouped by vendor --}}
    @php $grouped = $order->items->groupBy(fn($item) => $item->vendor->business_name ?? 'Unknown'); @endphp

    <div class="space-y-6">
        @foreach($grouped as $vendorName => $items)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden slide-up" @if($loop->index > 0) style="animation-delay: {{ $loop->index * 100 }}ms" @endif>
                {{-- Vendor header --}}
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-primary-50/80 to-transparent dark:from-primary-900/15 dark:to-transparent">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center text-primary-600 dark:text-primary-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                            </svg>
                        </div>
                        <h2 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $vendorName }}</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 ml-auto">{{ $items->sum('quantity') }} {{ Str::plural('item', $items->sum('quantity')) }}</span>
                    </div>
                </div>

                {{-- Items list --}}
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($items as $item)
                        <div class="flex items-center gap-4 px-6 py-4 transition-colors hover:bg-gray-50/50 dark:hover:bg-gray-700/20">
                            <div class="w-14 h-14 rounded-xl bg-gray-50 dark:bg-gray-900 overflow-hidden shrink-0 flex items-center justify-center text-gray-300 dark:text-gray-600 border border-gray-100 dark:border-gray-700/50">
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
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    <span class="text-primary-600 dark:text-primary-400 font-medium">{{ $item->formatted_unit_price }}</span>
                                    <span class="text-gray-400 dark:text-gray-500"> &times; </span>
                                    <span>{{ $item->quantity }}</span>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold gradient-text">{{ $item->formatted_subtotal }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Order summary --}}
    <div class="relative mt-8 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden slide-up delay-300">
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-primary-50 dark:bg-primary-900/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>
        <div class="relative z-10 p-6 sm:p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Order Total</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $order->total_item_count }} {{ Str::plural('item', $order->total_item_count) }} &middot; {{ $order->created_at->format('M j, Y') }}</p>
                </div>
                <span class="text-2xl font-bold gradient-text">{{ $order->formatted_subtotal }}</span>
            </div>
            @if($order->notes)
                <div class="mt-6 pt-5 border-t border-gray-100 dark:border-gray-700/50">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 text-gray-400 dark:text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                        </svg>
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Order Notes</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $order->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

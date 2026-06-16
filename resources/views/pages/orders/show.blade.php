@extends('layouts.app')

@section('title', "Order {$order->order_number}")

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Back link --}}
    <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Orders
    </a>

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-sm text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Order header --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">Order {{ $order->order_number }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
            <div>{!! $order->status_badge !!}</div>
        </div>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            {{ $order->total_item_count }} {{ Str::plural('item', $order->total_item_count) }}
            &middot;
            Total: <span class="font-semibold text-gray-900 dark:text-white">{{ $order->formatted_subtotal }}</span>
        </div>
    </div>

    {{-- Order items grouped by vendor --}}
    @php $grouped = $order->items->groupBy(fn($item) => $item->vendor->business_name ?? 'Unknown'); @endphp

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

    {{-- Order summary --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-500 dark:text-gray-400">Order Total</span>
            <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $order->formatted_subtotal }}</span>
        </div>
        @if($order->notes)
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Order Notes</p>
                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $order->notes }}</p>
            </div>
        @endif
    </div>
</div>
@endsection

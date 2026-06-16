@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Orders</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">View your order history.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-sm text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count())
        <div class="space-y-4">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="block bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-md transition p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <span class="text-sm font-mono text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                            <span class="text-xs text-gray-400 dark:text-gray-500 ml-2">{{ $order->created_at->format('M j, Y g:i A') }}</span>
                        </div>
                        <div>{!! $order->status_badge !!}</div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">{{ $order->total_item_count }} {{ Str::plural('item', $order->total_item_count) }}</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $order->formatted_subtotal }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400 mb-1">No orders yet</h2>
            <p class="text-sm text-gray-400 dark:text-gray-500 mb-6">When you place your first order, it will appear here.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection

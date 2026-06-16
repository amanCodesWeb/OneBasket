@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Hero section --}}
    <div class="relative mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-primary-600 via-primary-700 to-teal-800 dark:from-primary-800 dark:via-primary-900 dark:to-gray-900 p-8 sm:p-10 shadow-xl slide-up">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full blur-2xl translate-y-1/3 -translate-x-1/4"></div>
        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-white">My Orders</h1>
            <p class="text-primary-100 text-sm mt-1.5 max-w-lg">Track and review everything you've ordered — all in one place.</p>
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-sm text-green-700 dark:text-green-300 slide-up delay-100">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count())
        <div class="space-y-4 stagger-children">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="card-glow block bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 sm:p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-semibold font-mono text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                                <span class="text-xs text-gray-400 dark:text-gray-500 ml-2">{{ $order->created_at->format('M j, Y g:i A') }}</span>
                            </div>
                        </div>
                        <div>{!! $order->status_badge !!}</div>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-3 border-t border-gray-100 dark:border-gray-700/50">
                        <span class="text-gray-500 dark:text-gray-400">{{ $order->total_item_count }} {{ Str::plural('item', $order->total_item_count) }}</span>
                        <span class="font-semibold gradient-text">{{ $order->formatted_subtotal }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        {{-- Empty state --}}
        <div class="relative text-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden slide-up">
            <div class="absolute top-0 right-0 w-48 h-48 bg-primary-50 dark:bg-primary-900/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="relative z-10">
                <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary-500 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-500 dark:text-gray-400 mb-1">No orders yet</h2>
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-8 max-w-xs mx-auto">When you place your first order, it will appear here. Start exploring what's available.</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-md shadow-primary-600/20 hover:shadow-lg hover:shadow-primary-600/30">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

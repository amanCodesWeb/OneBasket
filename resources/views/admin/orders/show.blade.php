@extends('layouts.admin')

@section('title', "Order {$order->order_number}")
@section('heading', "Order {$order->order_number}")

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 transition">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Orders
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 text-sm">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Order Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Items --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Order Items</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 px-6 py-4">
                            <div class="w-12 h-12 rounded-lg bg-gray-50 dark:bg-gray-900 overflow-hidden shrink-0 flex items-center justify-center text-gray-300 dark:text-gray-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $item->vendor->business_name ?? 'Unknown' }}
                                    &middot;
                                    {{ $item->formatted_unit_price }} × {{ $item->quantity }}
                                </p>
                            </div>
                            <div class="text-right text-sm font-semibold text-gray-900 dark:text-white">{{ $item->formatted_subtotal }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-between">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Total</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $order->formatted_subtotal }}</span>
                </div>
            </div>

            @if($order->notes)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Order Notes</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Customer Info --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Customer</h3>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->user->name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->user->email }}</p>
            </div>

            {{-- Order Info --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Order Info</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                        <dd>{!! $order->status_badge !!}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-gray-400">Placed</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $order->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-gray-400">Items</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $order->total_item_count }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-gray-400">Total</dt>
                        <dd class="font-semibold text-gray-900 dark:text-white">{{ $order->formatted_subtotal }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Update Status --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Update Status</h3>
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none mb-3">
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" @selected($order->status === $s)>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-primary-600 text-white text-sm font-medium hover:bg-primary-700 transition">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

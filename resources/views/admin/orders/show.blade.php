@extends('layouts.admin')

@section('title', "Order {$order->order_number}")
@section('heading')
    <span class="gradient-text">Order #{{ $order->order_number }}</span>
@endsection

@section('content')
    {{-- Back Button --}}
    <div class="mb-6 fade-in">
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 group">
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to Orders
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/15 border border-green-200 dark:border-green-800/50 text-green-700 dark:text-green-300 text-sm flex items-center gap-3 fade-in">
            <svg class="w-5 h-5 shrink-0 text-green-500 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Order Items --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700/50 overflow-hidden card-glow slide-up">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700/50 bg-gradient-to-r from-primary-50/60 to-transparent dark:from-primary-900/10 dark:to-transparent">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Order Items</h3>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 px-6 py-4 hover:bg-primary-50/20 dark:hover:bg-primary-900/5 transition-colors duration-150">
                            <div class="w-12 h-12 rounded-lg bg-primary-50 dark:bg-primary-900/10 border border-primary-100 dark:border-primary-800/30 overflow-hidden shrink-0 flex items-center justify-center text-primary-400 dark:text-primary-500">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                        </svg>
                                        {{ $item->vendor->business_name ?? 'Unknown' }}
                                    </span>
                                    <span class="mx-1.5 text-gray-300 dark:text-gray-600">&middot;</span>
                                    <span>{{ $item->formatted_unit_price }} × {{ $item->quantity }}</span>
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-bold text-primary-700 dark:text-primary-300">{{ $item->formatted_subtotal }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700/50 bg-gradient-to-r from-primary-50/40 to-transparent dark:from-primary-900/8 dark:to-transparent flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Total</span>
                        <span class="text-xs text-gray-400 dark:text-gray-500">({{ $order->total_item_count }} {{ Str::plural('item', $order->total_item_count) }})</span>
                    </div>
                    <span class="text-base font-bold text-gray-900 dark:text-white">{{ $order->formatted_subtotal }}</span>
                </div>
            </div>

            {{-- Order Notes --}}
            @if($order->notes)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700/50 p-6 card-glow slide-up delay-100">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Order Notes</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed pl-6 border-l-2 border-primary-200 dark:border-primary-800">{{ $order->notes }}</p>
                </div>
            @endif

            {{-- Order Timeline --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700/50 p-6 card-glow slide-up delay-200">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Timeline</h3>
                </div>
                <div class="relative">
                    {{-- Vertical line --}}
                    <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                    @php
                        $timelineEvents = collect([
                            ['label' => 'Order Placed', 'time' => $order->created_at, 'icon' => 'shopping-cart', 'active' => true],
                        ]);

                        // Order-level status events
                        if (in_array($order->order_status, ['paid', 'in_progress', 'shipped', 'delivered'])) {
                            $timelineEvents->push(['label' => 'Paid', 'time' => $order->updated_at, 'icon' => 'currency', 'active' => true]);
                        }
                        if (in_array($order->order_status, ['in_progress', 'shipped', 'delivered'])) {
                            $timelineEvents->push(['label' => 'In Progress', 'time' => $order->updated_at, 'icon' => 'refresh', 'active' => true]);
                        }

                        // Vendor milestones (from vendor status)
                        if (in_array($order->status, ['packed', 'picked_up', 'delivered'])) {
                            $timelineEvents->push(['label' => 'Packed by Vendor', 'time' => $order->updated_at, 'icon' => 'package', 'active' => true]);
                        }
                        if (in_array($order->status, ['picked_up', 'delivered'])) {
                            $timelineEvents->push(['label' => 'Picked Up from Vendor', 'time' => $order->updated_at, 'icon' => 'truck', 'active' => true]);
                        }

                        if (in_array($order->order_status, ['shipped', 'delivered'])) {
                            $timelineEvents->push(['label' => 'Shipped', 'time' => $order->updated_at, 'icon' => 'ship', 'active' => true]);
                        }
                        if ($order->order_status === 'delivered') {
                            $timelineEvents->push(['label' => 'Delivered', 'time' => $order->updated_at, 'icon' => 'check', 'active' => true]);
                        }
                        if ($order->order_status === 'cancelled') {
                            $timelineEvents->push(['label' => 'Cancelled', 'time' => $order->updated_at, 'icon' => 'x', 'active' => true]);
                        }
                        if ($order->order_status === 'failed') {
                            $timelineEvents->push(['label' => 'Failed', 'time' => $order->updated_at, 'icon' => 'x', 'active' => true]);
                        }
                    @endphp

                    @foreach($timelineEvents as $event)
                        <div class="relative flex items-start gap-4 pb-5 last:pb-0">
                            <div class="relative z-10 flex items-center justify-center w-6 h-6 rounded-full
                                @if($event['active']) bg-primary-600 dark:bg-primary-500 text-white shadow-sm shadow-primary-600/20
                                @else bg-gray-100 dark:bg-gray-700 text-gray-400 @endif
                            ">
                                @switch($event['icon'])
                                    @case('shopping-cart')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                                        @break
                                    @case('package')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        @break
                                    @case('pickup')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                                        @break
                                    @case('warehouse')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                                        @break
                                    @case('bundle')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4m9-10v10l-8 4m-2-10v10"/></svg>
                                        @break
                                    @case('refresh')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                                        @break
                                    @case('currency')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @break
                                    @case('ship')
                                        <svg class="w-3 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/></svg>
                                        @break
                                    @case('truck')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                                        @break
                                    @case('check')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        @break
                                    @case('x')
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        @break
                                @endswitch
                            </div>
                            <div class="pt-0.5">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $event['label'] }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $event['time']->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Customer Info --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700/50 overflow-hidden card-glow slide-up delay-100">
                {{-- Teal accent strip --}}
                <div class="h-1.5 bg-gradient-to-r from-primary-500 to-primary-400 dark:from-primary-600 dark:to-primary-500"></div>
                <div class="p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-sm font-bold text-primary-700 dark:text-primary-300">
                            {{ substr($order->user->name, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Customer</h3>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Contact Information</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $order->user->name }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            <a href="mailto:{{ $order->user->email }}" class="text-primary-600 dark:text-primary-400 hover:underline truncate">{{ $order->user->email }}</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Info --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700/50 overflow-hidden card-glow slide-up delay-200">
                {{-- Teal accent strip --}}
                <div class="h-1.5 bg-gradient-to-r from-primary-500 to-primary-400 dark:from-primary-600 dark:to-primary-500"></div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Order Info</h3>
                    </div>
                    <dl class="space-y-3 text-sm">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700/50">
                            <dt class="text-gray-500 dark:text-gray-400">Order Status</dt>
                            <dd>{!! $order->order_status_badge !!}</dd>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700/50">
                            <dt class="text-gray-500 dark:text-gray-400">Vendor Status</dt>
                            <dd>{!! $order->status_badge !!}</dd>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700/50">
                            <dt class="text-gray-500 dark:text-gray-400">Placed</dt>
                            <dd class="text-gray-900 dark:text-white text-right">
                                <span class="block">{{ $order->created_at->format('M j, Y') }}</span>
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ $order->created_at->format('g:i A') }}</span>
                            </dd>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700/50">
                            <dt class="text-gray-500 dark:text-gray-400">Items</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $order->total_item_count }}</dd>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <dt class="text-gray-500 dark:text-gray-400">Total</dt>
                            <dd class="font-bold text-base text-primary-700 dark:text-primary-300">{{ $order->formatted_subtotal }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700/50 overflow-hidden card-glow slide-up delay-300">
                {{-- Teal accent strip --}}
                <div class="h-1.5 bg-gradient-to-r from-primary-500 to-primary-400 dark:from-primary-600 dark:to-primary-500"></div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/>
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Update Status</h3>
                    </div>

                    {{-- Ready for pickup banner --}}
                    @if($order->status === 'packed')
                        <div class="mb-4 p-3 rounded-lg bg-teal-50 dark:bg-teal-900/15 border border-teal-200 dark:border-teal-800/50">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 shrink-0 text-teal-600 dark:text-teal-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-teal-800 dark:text-teal-300">Ready for Pickup</p>
                                    <p class="text-xs text-teal-600/80 dark:text-teal-400/70 mt-0.5">Vendor has packed this order. Send a driver to pick it up.</p>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mb-4">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="picked_up">
                            <button type="submit"
                                    class="w-full px-4 py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-500 text-white text-sm font-medium hover:from-green-700 hover:to-emerald-600 active:from-green-800 active:to-emerald-700 focus:ring-2 focus:ring-green-500/50 focus:outline-none transition-all duration-200 shadow-sm shadow-green-600/20">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                                    </svg>
                                    Mark as Picked Up
                                </span>
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                        @csrf
                        @method('PATCH')
                        <div class="relative mb-3">
                            <select name="order_status"
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 outline-none appearance-none transition-all duration-200">
                                @foreach($statuses as $s)
                                    <option value="{{ $s }}" @selected($order->order_status === $s)>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </div>
                        </div>
                        <button type="submit"
                                class="w-full px-4 py-2.5 rounded-lg bg-gradient-to-r from-primary-600 to-primary-500 text-white text-sm font-medium hover:from-primary-700 hover:to-primary-600 active:from-primary-800 active:to-primary-700 focus:ring-2 focus:ring-primary-500/50 focus:outline-none transition-all duration-200 shadow-sm shadow-primary-600/20">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/>
                                </svg>
                                Update Status
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

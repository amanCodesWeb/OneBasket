@extends('vendor.layouts.vendor')

@php
    if (! function_exists('pluralize')) {
        function pluralize($word, $count) { return $count === 1 ? "1 $word" : "$count {$word}s"; }
    }
@endphp

@section('title', 'Orders')
@section('heading', 'Orders')

@section('content')
    {{-- Stats bar --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/50 p-5">
            <div class="absolute top-0 right-0 w-24 h-24 -translate-y-6 translate-x-6 rounded-full bg-amber-500/5 dark:bg-amber-400/5 blur-2xl"></div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Open</p>
                    <p class="text-xl font-bold text-amber-600 dark:text-amber-400 mt-0.5">{{ $counts['pending'] }}</p>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/50 p-5">
            <div class="absolute top-0 right-0 w-24 h-24 -translate-y-6 translate-x-6 rounded-full bg-teal-500/5 dark:bg-teal-400/5 blur-2xl"></div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Packed</p>
                    <p class="text-xl font-bold text-teal-600 dark:text-teal-400 mt-0.5">{{ $counts['packed'] }}</p>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/50 p-5">
            <div class="absolute top-0 right-0 w-24 h-24 -translate-y-6 translate-x-6 rounded-full bg-green-500/5 dark:bg-green-400/5 blur-2xl"></div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Picked Up</p>
                    <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-0.5">{{ $counts['picked_up'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter / Search Bar --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-gray-700/50 p-4 sm:p-5">
            <form method="GET" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
                    <div class="relative flex-1 min-w-0">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order # or email..."
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 outline-none">
                    </div>
                    <div class="relative">
                        <select name="status"
                                class="w-full sm:w-44 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 outline-none appearance-none">
                            <option value="">All Statuses</option>
                            @foreach($vendorStatuses as $s)
                                <option value="{{ $s }}" @selected(request('status') === $s)>{{ $vendorStatusLabels[$s] ?? ucwords(str_replace('_', ' ', $s)) }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </div>
                    </div>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-teal-600 text-white text-sm font-medium focus:ring-2 focus:ring-teal-500/50 focus:outline-none whitespace-nowrap">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('vendor.orders.index') }}"
                           class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-800/60">
                        <th class="text-left px-6 py-3.5 font-semibold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Order #</th>
                        <th class="text-center px-6 py-3.5 font-semibold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Items</th>
                        <th class="text-center px-6 py-3.5 font-semibold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Qty</th>
                        <th class="text-right px-6 py-3.5 font-semibold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Your Total</th>
                        <th class="text-center px-6 py-3.5 font-semibold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                        <th class="text-left px-6 py-3.5 font-semibold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Date</th>
                        <th class="text-center px-6 py-3.5 font-semibold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($orders as $order)
                        <tr class="border-b border-gray-100 dark:border-gray-700/60">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-semibold text-gray-900 dark:text-white">#{{ $order->order_number }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $order->vendor_item_count ? pluralize('item', $order->items->where('vendor_id', $vendor->id)->count()) : '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->vendor_item_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">Rs. {{ number_format($order->vendor_subtotal, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                    @switch($order->status)
                                        @case('pending') bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-700/50 @break
                                        @case('confirmed') bg-sky-50 dark:bg-sky-900/20 text-sky-700 dark:text-sky-300 border border-sky-200 dark:border-sky-700/50 @break
                                        @case('packed') bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-teal-700/50 @break
                                        @case('picked_up') bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-700/50 @break
                                        @case('cancelled') bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-700/50 @break
                                        @default bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 @endswitch
                                ">
                                    @php $vendorLabel = \App\Models\Order::$vendorStatusLabels[$order->status] ?? $order->status_label; @endphp
                                    @switch($order->status)
                                        @case('pending')
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                                            @break
                                        @case('confirmed')
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                                            @break
                                        @case('packed')
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                            @break
                                        @case('picked_up')
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                                            @break
                                        @case('cancelled')
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            @break
                                    @endswitch
                                    {{ $vendorLabel }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                    </svg>
                                    <span>{{ $order->created_at->format('M j, Y') }}</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $order->created_at->format('g:i A') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Gear quick-status --}}
                                    @if(!empty($allowedTransitions[$order->status]))
                                        <button onclick="openDropdown(event, this)"
                                                data-order-id="{{ $order->id }}"
                                                data-order-number="{{ $order->order_number }}"
                                                class="p-2 rounded-lg text-gray-400"
                                                title="Quick update status">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </button>
                                        {{-- Hidden template for dropdown content --}}
                                        <template data-dropdown-for="{{ $order->id }}">
                                            <div class="fixed z-50 w-48 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black/5 dark:ring-white/10 overflow-hidden">
                                                <div class="py-1">
                                                    @foreach($allowedTransitions[$order->status] as $transition)
                                                        <form method="POST" action="{{ route('vendor.orders.update-status', $order) }}" class="block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="{{ $transition }}">
                                                            <button type="submit"
                                                                    class="w-full text-left px-4 py-2 text-sm flex items-center gap-2.5
                                                                    @switch($transition)
                                                                        @case('confirmed') text-sky-700 dark:text-sky-300 @break
                                                                        @case('packed') text-teal-700 dark:text-teal-300 @break
                                                                        @case('cancelled') text-red-700 dark:text-red-300 @break
                                                                        @default text-gray-700 dark:text-gray-300 @endswitch">
                                                                @switch($transition)
                                                                    @case('confirmed')
                                                                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                                                        @break
                                                                    @case('packed')
                                                                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                                                        @break
                                                                    @case('cancelled')
                                                                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                                        @break
                                                                @endswitch
                                                                {{ $vendorStatusLabels[$transition] ?? ucwords(str_replace('_', ' ', $transition)) }}
                                                            </button>
                                                        </form>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </template>
                                    @endif

                                    {{-- Details link --}}
                                    <a href="{{ route('vendor.orders.show', $order) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/20 border border-teal-200 dark:border-teal-700/30">
                                        Details
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No orders yet</p>
                                    @if(request()->anyFilled(['search', 'status']))
                                        <a href="{{ route('vendor.orders.index') }}" class="text-sm text-teal-600 dark:text-teal-400">Clear filters</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
        <div class="mt-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700/50 p-3">
                {{ $orders->links() }}
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    let activePopup = null;

    function openDropdown(event, btn) {
        event.stopPropagation();
        closeDropdown();

        const orderId = btn.dataset.orderId;
        const template = document.querySelector(`template[data-dropdown-for="${orderId}"]`);
        if (!template) return;

        const clone = template.content.cloneNode(true);
        const popup = clone.firstElementChild;

        const rect = btn.getBoundingClientRect();
        popup.style.bottom = (window.innerHeight - rect.top + 4) + 'px';
        popup.style.right = (window.innerWidth - rect.right) + 'px';

        document.body.appendChild(popup);
        activePopup = popup;
    }

    function closeDropdown() {
        if (activePopup) {
            activePopup.remove();
            activePopup = null;
        }
    }

    document.addEventListener('click', function(e) {
        if (activePopup && !activePopup.contains(e.target)) {
            closeDropdown();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDropdown();
    });
</script>
@endpush

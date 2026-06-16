@extends('layouts.admin')

@section('title', 'Orders')
@section('heading', 'Orders')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <form method="GET" class="flex items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order # or email..."
                   class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none w-64">
            <select name="status" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                <option value="">All Statuses</option>
                @foreach($statuses as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white text-sm font-medium hover:bg-primary-700 transition">Filter</button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-primary-600 transition">Clear</a>
            @endif
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <th class="text-left px-6 py-3 font-medium text-gray-500 dark:text-gray-400">Order #</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500 dark:text-gray-400">Customer</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500 dark:text-gray-400">Items</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500 dark:text-gray-400">Total</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500 dark:text-gray-400">Date</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 font-mono text-sm font-medium text-gray-900 dark:text-white">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $order->user->name }}<br><span class="text-xs text-gray-400">{{ $order->user->email }}</span></td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $order->total_item_count }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">{{ $order->formatted_subtotal }}</td>
                            <td class="px-6 py-4">{!! $order->status_badge !!}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M j, Y') }}<br><span class="text-xs">{{ $order->created_at->format('g:i A') }}</span></td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection

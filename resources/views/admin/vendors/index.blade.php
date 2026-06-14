@extends('layouts.admin')

@section('title', 'Vendors')
@section('heading', 'Vendors')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex gap-2">
            <a href="{{ route('admin.vendors.index') }}" class="px-3 py-1.5 text-sm rounded-lg {{ !request('status') ? 'bg-primary-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }} transition">All</a>
            @foreach($statuses as $s)
                <a href="{{ route('admin.vendors.index', ['status' => $s]) }}" class="px-3 py-1.5 text-sm rounded-lg {{ request('status') === $s ? 'bg-primary-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }} transition capitalize">{{ $s }}</a>
            @endforeach
        </div>
        <div class="flex gap-3">
            <form method="GET" action="{{ route('admin.vendors.index') }}">
                <input type="text" name="search" placeholder="Search vendors..." value="{{ request('search') }}"
                       class="w-full sm:w-64 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
            </form>
            <a href="{{ route('admin.vendors.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
                + New Vendor
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if($vendors->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left px-4 py-3 font-medium text-gray-500 dark:text-gray-400">Business</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-500 dark:text-gray-400">Owner</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-500 dark:text-gray-400">Contact</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-500 dark:text-gray-400">Status</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-500 dark:text-gray-400">Verified</th>
                            <th class="text-right px-4 py-3 font-medium text-gray-500 dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($vendors as $vendor)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if($vendor->logo)
                                            <img src="{{ $vendor->logo }}" alt="" class="w-8 h-8 rounded-lg object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-600 dark:text-primary-400 text-xs font-bold">
                                                {{ substr($vendor->business_name, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.vendors.show', $vendor) }}" class="font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400">
                                                {{ $vendor->business_name }}
                                            </a>
                                            <div class="text-xs text-gray-400">Radius: {{ $vendor->delivery_radius_km }}km</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $vendor->user?->name ?? '—' }}
                                    <div class="text-xs text-gray-400">{{ $vendor->user?->email }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $vendor->phone ?? '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @switch($vendor->status)
                                            @case('active') bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 @break
                                            @case('pending') bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 @break
                                            @case('suspended') bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 @break
                                            @case('rejected') bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 @break
                                            @default bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400
                                        @endswitch
                                    ">{{ ucfirst($vendor->status) }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $vendor->verified_at ? $vendor->verified_at->format('M d, Y') : '—' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.vendors.show', $vendor) }}" class="text-primary-600 dark:text-primary-400 hover:underline text-sm">View</a>
                                    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="ml-3 text-amber-600 dark:text-amber-400 hover:underline text-sm">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $vendors->links() }}
            </div>
        @else
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                <p class="text-lg font-medium mb-1">No vendors yet</p>
                <p class="text-sm">Create your first vendor to get started.</p>
                <a href="{{ route('admin.vendors.create') }}" class="mt-4 inline-block bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">+ New Vendor</a>
            </div>
        @endif
    </div>
@endsection

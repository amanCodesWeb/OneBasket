@extends('layouts.admin')

@section('title', $vendor->business_name)
@section('heading', $vendor->business_name)

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.vendors.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition">&larr; Back to Vendors</a>
    </div>

    @if(session('vendor_password'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-medium text-green-800 dark:text-green-200">Vendor Approved!</p>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">Share these credentials with the vendor:</p>
                    <div class="mt-3 p-3 rounded-lg bg-green-100 dark:bg-green-900/40 font-mono text-sm">
                        <p><span class="text-green-600 dark:text-green-400">Email:</span> <strong class="text-green-800 dark:text-green-200">{{ session('vendor_email') }}</strong></p>
                        <p class="mt-1"><span class="text-green-600 dark:text-green-400">Password:</span> <strong class="text-green-800 dark:text-green-200">{{ session('vendor_password') }}</strong></p>
                    </div>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">Make sure to save this — it will not be shown again.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Business Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Business Name</dt>
                        <dd class="text-gray-900 dark:text-white font-medium">{{ $vendor->business_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Slug</dt>
                        <dd class="text-gray-900 dark:text-white font-mono text-xs">{{ $vendor->slug }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Owner</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $vendor->user?->name }} ({{ $vendor->user?->email }})</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                        <dd>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($vendor->status)
                                    @case('active') bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 @break
                                    @case('pending') bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 @break
                                    @case('suspended') bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 @break
                                    @case('rejected') bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 @break
                                    @default bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400
                                @endswitch
                            ">{{ ucfirst($vendor->status) }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Phone</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $vendor->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">WhatsApp</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $vendor->whatsapp ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Delivery Radius</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $vendor->delivery_radius_km }} km</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Commission Rate</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $vendor->commission_rate ? $vendor->commission_rate . '%' : '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Verified</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $vendor->verified_at ? $vendor->verified_at->format('M d, Y \\a\\t g:i A') : 'Not verified' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Joined</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $vendor->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            @if($vendor->description)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Description</h3>
                    <p class="text-gray-900 dark:text-white text-sm whitespace-pre-line">{{ $vendor->description }}</p>
                </div>
            @endif

            @if($vendor->address)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Address</h3>
                    <p class="text-gray-900 dark:text-white text-sm">{{ $vendor->address }}</p>
                </div>
            @endif
        </div>

        {{-- Sidebar actions --}}
        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Actions</h3>
                <div class="space-y-2">
                    @if($vendor->status !== 'active')
                        <form method="POST" action="{{ route('admin.vendors.approve', $vendor) }}">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Approve & Verify</button>
                        </form>
                    @endif
                    @if($vendor->status === 'active')
                        <form method="POST" action="{{ route('admin.vendors.suspend', $vendor) }}">
                            @csrf
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition" onclick="return confirm('Suspend this vendor?')">Suspend</button>
                        </form>
                    @endif
                    @if($vendor->status === 'suspended')
                        <form method="POST" action="{{ route('admin.vendors.activate', $vendor) }}">
                            @csrf
                            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Reactivate</button>
                        </form>
                    @endif
                    @if($vendor->status !== 'rejected')
                        <form method="POST" action="{{ route('admin.vendors.reject', $vendor) }}">
                            @csrf
                            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition" onclick="return confirm('Reject this vendor?')">Reject</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Quick Links</h3>
                <div class="space-y-2 text-sm">
                    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="block text-primary-600 dark:text-primary-400 hover:underline">Edit vendor &rarr;</a>
                    <form method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}" onsubmit="return confirm('Delete this vendor? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Delete vendor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('vendor.layouts.vendor')

@section('title', 'Vendor Dashboard')
@section('heading', 'Vendor Dashboard')

@section('content')
    @if(!$vendor)
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-6 text-center">
            <p class="text-amber-700 dark:text-amber-300">You don't have a vendor profile yet. Contact the admin to set one up.</p>
        </div>
    @elseif($vendor->isPending())
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-6 text-center">
            <p class="text-amber-700 dark:text-amber-300">Your vendor profile is <strong>pending approval</strong>. You'll be notified once it's reviewed.</p>
        </div>
    @elseif($vendor->isSuspended())
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6 text-center">
            <p class="text-red-700 dark:text-red-300">Your account has been suspended. Please contact support.</p>
        </div>
    @elseif($vendor->isActive())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                <p class="text-lg font-bold text-green-600 dark:text-green-400 mt-1 capitalize">{{ $vendor->status }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Delivery Radius</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $vendor->delivery_radius_km }} km</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Products</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $vendor->products()->count() }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $vendor->created_at->format('M Y') }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Business Name</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $vendor->business_name }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $vendor->phone ?? '—' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <a href="{{ route('vendor.profile.edit') }}" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:border-primary-500/50 transition group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">Edit Profile</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Update your business details and settings</p>
                    </div>
                </div>
            </a>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 group cursor-default">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Products</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage your products (coming soon)</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

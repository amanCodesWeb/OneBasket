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
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $vendor->created_at->format('M Y') }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400">Product management coming soon.</p>
        </div>
    @endif
@endsection

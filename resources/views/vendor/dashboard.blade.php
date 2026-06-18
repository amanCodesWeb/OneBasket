@extends('vendor.layouts.vendor')

@section('title', 'Vendor Dashboard')
@section('heading', 'Vendor Dashboard')

@section('content')
    @if(!$vendor)
        <div class="animate-fade-in">
            <div class="bg-gradient-to-br from-amber-50 to-amber-100/80 dark:from-amber-900/20 dark:to-amber-800/10 border border-amber-200/80 dark:border-amber-700/50 rounded-2xl p-8 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-amber-100 dark:bg-amber-800/30 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-500 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <p class="text-amber-700 dark:text-amber-300 text-lg font-medium">You don't have a vendor profile yet.</p>
                <p class="text-amber-600/70 dark:text-amber-400/60 text-sm mt-1">Contact the admin to set one up.</p>
            </div>
        </div>
    @elseif($vendor->isPending())
        <div class="animate-fade-in">
            <div class="bg-gradient-to-br from-amber-50 to-amber-100/80 dark:from-amber-900/20 dark:to-amber-800/10 border border-amber-200/80 dark:border-amber-700/50 rounded-2xl p-8 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-amber-100 dark:bg-amber-800/30 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-500 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-amber-700 dark:text-amber-300 text-lg font-medium">Pending Approval</p>
                <p class="text-amber-600/70 dark:text-amber-400/60 text-sm mt-1">Your vendor profile is <strong>pending approval</strong>. You'll be notified once it's reviewed.</p>
            </div>
        </div>
    @elseif($vendor->isSuspended())
        <div class="animate-fade-in">
            <div class="bg-gradient-to-br from-red-50 to-red-100/80 dark:from-red-900/20 dark:to-red-800/10 border border-red-200/80 dark:border-red-700/50 rounded-2xl p-8 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-800/30 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-500 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <p class="text-red-700 dark:text-red-300 text-lg font-medium">Account Suspended</p>
                <p class="text-red-600/70 dark:text-red-400/60 text-sm mt-1">Your account has been suspended. Please contact support.</p>
            </div>
        </div>
    @elseif($vendor->isActive())
        {{-- Welcome header with gradient text --}}
        <div class="animate-fade-in mb-8">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-teal-600 via-teal-600 to-emerald-700 dark:from-teal-700 dark:via-teal-800 dark:to-emerald-900 p-6 sm:p-8 shadow-lg">
                {{-- Decorative background pattern --}}
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-white/30 blur-2xl"></div>
                    <div class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full bg-white/20 blur-xl"></div>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <span class="text-white/80 text-sm font-medium tracking-wide uppercase">Vendor Portal</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mt-2">
                        Welcome back, <span class="text-white/90">{{ $vendor->business_name }}</span>
                    </h1>
                    <p class="text-teal-100/80 text-sm sm:text-base mt-1 max-w-xl">
                        Manage your business, view stats, and track performance all in one place.
                    </p>
                </div>
            </div>
        </div>

        {{-- Stats grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            {{-- Status card --}}
            <div class="group animate-slide-up bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-5 sm:p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                    <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-4.5 h-4.5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-white capitalize">
                    @if($vendor->isActive())
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                            {{ $vendor->status }}
                        </span>
                    @else
                        {{ $vendor->status }}
                    @endif
                </p>
            </div>

            {{-- Delivery Radius card --}}
            <div class="group animate-slide-up bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-5 sm:p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300" style="animation-delay: 0.05s;">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Delivery Radius</p>
                    <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-4.5 h-4.5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $vendor->delivery_radius_km }} <span class="text-sm font-normal text-gray-500 dark:text-gray-400">km</span></p>
            </div>

            {{-- Products card --}}
            <div class="group animate-slide-up bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-5 sm:p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Products</p>
                    <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-4.5 h-4.5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $vendor->products()->count() }}</p>
            </div>

            {{-- Member Since card --}}
            <div class="group animate-slide-up bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-5 sm:p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300" style="animation-delay: 0.15s;">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</p>
                    <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-4.5 h-4.5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $vendor->created_at->format('M Y') }}</p>
            </div>

            {{-- Business Name card --}}
            <div class="group animate-slide-up bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-5 sm:p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Business Name</p>
                    <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-4.5 h-4.5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-white truncate">{{ $vendor->business_name }}</p>
            </div>

            {{-- Phone card --}}
            <div class="group animate-slide-up bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-5 sm:p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300" style="animation-delay: 0.25s;">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</p>
                    <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-4.5 h-4.5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $vendor->phone ?? '—' }}</p>
            </div>
        </div>

        {{-- Quick links --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Edit Profile --}}
            <a href="{{ route('vendor.profile.edit') }}" class="group animate-slide-up bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300" style="animation-delay: 0.3s;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 dark:from-teal-600 dark:to-emerald-700 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors duration-200">Edit Profile</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Update your business details and settings</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 group-hover:text-teal-500 group-hover:translate-x-0.5 transition-all duration-200 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            {{-- Products --}}
            <a href="{{ route('vendor.products.index') }}" class="group animate-slide-up bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300" style="animation-delay: 0.35s;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 dark:from-teal-600 dark:to-emerald-700 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors duration-200">My Products</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage your product catalog</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 group-hover:text-teal-500 group-hover:translate-x-0.5 transition-all duration-200 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>
    @endif
@endsection

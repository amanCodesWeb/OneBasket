@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    {{-- Hero section with gradient accent --}}
    <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-br from-primary-600 via-primary-700 to-gray-900 dark:from-primary-800 dark:via-gray-900 dark:to-gray-950 p-6 sm:p-8 fade-in">
        <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <path fill="#ffffff" d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,79.6,-45.8C87.4,-32.5,90,-15.9,88.5,0.3C87,16.4,81.4,32.9,72.2,47.1C63,61.3,50.2,73.3,35.4,81.1C20.6,88.9,3.8,92.6,-12.8,89.9C-29.4,87.3,-45.9,78.4,-58.2,65.8C-70.5,53.2,-78.7,36.9,-82,19.2C-85.3,1.5,-83.7,-17.5,-76.1,-32.8C-68.5,-48.1,-54.9,-59.7,-40.1,-66.9C-25.3,-74.1,-9.4,-76.8,4.5,-73.6C18.4,-70.3,30.6,-61.8,44.7,-76.4Z" transform="translate(100 100)"/>
            </svg>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/10 text-white/80 text-xs font-medium backdrop-blur-sm border border-white/10">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                    All systems operational
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-1">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="text-primary-100/80 text-sm sm:text-base max-w-xl">Here's what's happening across OneBasket today.</p>
        </div>
    </div>

    {{-- Stats cards with stagger animation --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 stagger-children">
        <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_users']) }}</p>
                        <span class="text-xs text-green-500 font-medium">+12%</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-400">New today</span>
                    <span class="font-medium text-primary-600 dark:text-primary-400">—</span>
                </div>
            </div>
        </div>

        <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Admins</p>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_admins']) }}</p>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/20 flex items-center justify-center text-amber-600 dark:text-amber-400 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-400">Last login</span>
                    <span class="font-medium text-gray-600 dark:text-gray-300">Today</span>
                </div>
            </div>
        </div>

        <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Products</p>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_products']) }}</p>
                        <span class="text-xs text-green-500 font-medium">{{ $stats['active_products'] }} active</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/20 flex items-center justify-center text-purple-600 dark:text-purple-400 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-400">Low stock</span>
                    <span class="font-medium text-amber-600 dark:text-amber-400">—</span>
                </div>
            </div>
        </div>

        <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Vendors</p>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_vendors']) }}</p>
                        <span class="text-xs text-amber-500 font-medium">{{ $stats['pending_vendors'] }} pending</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/20 flex items-center justify-center text-blue-600 dark:text-blue-400 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-400">Approval rate</span>
                    <span class="font-medium text-primary-600 dark:text-primary-400">—</span>
                </div>
            </div>
        </div>

        <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Vendor Accounts</p>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_businesses']) }}</p>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/30 dark:to-teal-800/20 flex items-center justify-center text-teal-600 dark:text-teal-400 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-400">Active accounts</span>
                    <span class="font-medium text-green-600 dark:text-green-400">—</span>
                </div>
            </div>
        </div>

        <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Customers</p>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_customers']) }}</p>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/20 flex items-center justify-center text-green-600 dark:text-green-400 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-400">New this week</span>
                    <span class="font-medium text-primary-600 dark:text-primary-400">—</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Getting Started / Modules section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 stagger-children">
        <div class="lg:col-span-2 card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Platform Overview</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Your marketplace at a glance</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-xs font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                    Live
                </span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="text-center p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                    <p class="text-2xl font-bold gradient-text">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total Users</p>
                </div>
                <div class="text-center p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_products']) }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Products</p>
                </div>
                <div class="text-center p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($stats['total_vendors']) }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Vendors</p>
                </div>
                <div class="text-center p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                    <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ number_format($stats['total_customers']) }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Customers</p>
                </div>
            </div>
        </div>

        <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                    <p class="text-xs text-gray-400">Common tasks</p>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('admin.products.create') }}" class="flex items-center gap-3 p-2.5 rounded-lg text-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-700 dark:hover:text-primary-300 transition-all group">
                    <span class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 group-hover:text-primary-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </span>
                    New Product
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 p-2.5 rounded-lg text-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-700 dark:hover:text-primary-300 transition-all group">
                    <span class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 group-hover:text-primary-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </span>
                    Manage Products
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 p-2.5 rounded-lg text-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-700 dark:hover:text-primary-300 transition-all group">
                    <span class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 group-hover:text-primary-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </span>
                    View Site
                </a>
            </div>
        </div>
    </div>

    {{-- Modules placeholder upgraded --}}
    <div class="mt-6 card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-8 text-center">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-400 mb-4">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Getting Started</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-5">
            The foundation is ready. Modules for vendors, products, orders, pickups, packing, and deliveries will be built next.
        </p>
        <div class="flex flex-wrap justify-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-xs font-medium border border-primary-200 dark:border-primary-800">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                Vendors
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-medium border border-gray-200 dark:border-gray-600">
                Orders
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-medium border border-gray-200 dark:border-gray-600">
                Pickups
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-medium border border-gray-200 dark:border-gray-600">
                Packing
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-medium border border-gray-200 dark:border-gray-600">
                Deliveries
            </span>
        </div>
    </div>
@endsection

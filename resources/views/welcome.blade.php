@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
    <div class="text-center max-w-3xl mx-auto">
        <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white tracking-tight">
            Shop from multiple stores.<br>
            <span class="text-primary-600 dark:text-primary-400">One delivery.</span>
        </h1>
        <p class="mt-6 text-lg text-gray-500 dark:text-gray-400 leading-relaxed">
            OneBasket brings your local vendors together. Add products from different stores
            to a single cart, checkout once, and receive everything in one consolidated package.
        </p>
        <div class="mt-10 flex items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg text-base font-medium transition shadow-sm">
                Get started
            </a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 px-8 py-3 rounded-lg text-base font-medium transition">
                        Dashboard
                    </a>
                @endif
            @endauth
        </div>
    </div>

    {{-- Feature cards --}}
    <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-lg bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-600 dark:text-primary-400 mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Multi-Store Shopping</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Browse products from multiple local vendors and add them all to one cart.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-lg bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-600 dark:text-primary-400 mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Consolidated Fulfillment</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Your products are collected, packed, and delivered as one package.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-lg bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-600 dark:text-primary-400 mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Real-Time Tracking</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Track your order from vendor preparation to pickup to your doorstep.</p>
        </div>
    </div>
</div>
@endsection

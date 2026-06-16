@extends('layouts.app')

@section('title', 'Welcome to OneBasket')

@section('content')
{{-- ─── Hero Section ──────────────────────────────────────────── --}}
<div class="relative overflow-hidden gradient-animate">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -right-32 w-[30rem] h-[30rem] hero-circle opacity-50"></div>
        <div class="absolute -bottom-40 -left-40 w-[35rem] h-[35rem] hero-circle opacity-30"></div>
        <div class="absolute top-1/3 left-1/4 w-72 h-72 hero-circle opacity-30"></div>
        {{-- Floating shapes --}}
        <svg class="absolute top-16 left-[10%] w-8 h-8 text-white/10 float" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"/>
        </svg>
        <svg class="absolute bottom-24 right-[15%] w-6 h-6 text-white/10 float-delayed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
        </svg>
        <div class="absolute top-1/2 right-[8%] w-3 h-3 bg-white/20 rounded-full float" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-1/3 left-[5%] w-4 h-4 border border-white/20 rounded float-delayed"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 lg:py-36">
        <div class="text-center max-w-4xl mx-auto">
            {{-- Tag --}}
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 mb-6 text-xs font-semibold tracking-wider uppercase text-white/90 bg-white/10 backdrop-blur-sm rounded-full border border-white/10 slide-up">
                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                Now available in your area
            </span>

            {{-- Heading --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-[1.05] tracking-tight fade-in">
                Your entire neighborhood
                <span class="gradient-text-warm block mt-1">in one basket.</span>
            </h1>

            {{-- Description --}}
            <p class="mt-6 text-lg sm:text-xl text-primary-100/90 max-w-2xl mx-auto leading-relaxed slide-up delay-100">
                OneBasket brings your local vendors together. Add products from different stores
                to a single cart, checkout once, and receive everything in one consolidated package.
            </p>

            {{-- CTA --}}
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 slide-up delay-200">
                <a href="{{ route('register') }}"
                   class="group relative inline-flex items-center gap-2 bg-white text-primary-700 hover:text-primary-600 px-8 py-3.5 rounded-xl font-semibold transition-all shadow-lg shadow-black/10 hover:shadow-xl hover:shadow-primary-500/20 text-sm sm:text-base overflow-hidden">
                    <span class="relative z-10">Get started — it's free</span>
                    <svg class="relative z-10 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                    <div class="absolute inset-0 bg-gradient-to-r from-white via-primary-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </a>
                <a href="{{ route('products.index') }}"
                   class="group inline-flex items-center gap-2 bg-primary-500/10 backdrop-blur-sm text-white border border-white/20 hover:bg-primary-500/20 hover:border-white/30 px-8 py-3.5 rounded-xl font-semibold transition-all text-sm sm:text-base">
                    Browse products
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Bottom fade to content --}}
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-gray-50 dark:from-gray-950 to-transparent pointer-events-none"></div>
</div>

{{-- ─── How It Works ──────────────────────────────────────────── --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
    <div class="text-center mb-14 fade-in">
        <span class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider uppercase text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-full">Simple process</span>
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">How it works</h2>
        <p class="mt-3 text-gray-500 dark:text-gray-400 max-w-xl mx-auto">Three simple steps to get fresh goods from local vendors</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-10 stagger-children">
        {{-- Step 1 --}}
        <div class="relative card-glow bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-8 text-center">
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-primary-600 text-white text-sm font-bold flex items-center justify-center shadow-lg shadow-primary-600/30">1</div>
            <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 mb-5 mt-2">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Multi-Store Shopping</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Browse products from multiple local vendors and add them all to one cart.</p>
        </div>

        {{-- Step 2 --}}
        <div class="relative card-glow bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-8 text-center">
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-primary-600 text-white text-sm font-bold flex items-center justify-center shadow-lg shadow-primary-600/30">2</div>
            <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 mb-5 mt-2">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Consolidated Fulfillment</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Your products are collected, packed, and delivered as one package.</p>
        </div>

        {{-- Step 3 --}}
        <div class="relative card-glow bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-8 text-center">
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-primary-600 text-white text-sm font-bold flex items-center justify-center shadow-lg shadow-primary-600/30">3</div>
            <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 mb-5 mt-2">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Real-Time Tracking</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Track your order from vendor preparation to pickup to your doorstep.</p>
        </div>
    </div>
</div>

{{-- ─── Trust Bar ─────────────────────────────────────────────── --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 sm:pb-28">
    <div class="fade-in">
        <div class="bg-gradient-to-r from-primary-50 via-white to-primary-50 dark:from-gray-800/50 dark:via-gray-900/50 dark:to-gray-800/50 rounded-3xl border border-primary-100 dark:border-gray-700/40 p-8 sm:p-12 text-center">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Ready to simplify your shopping?
                </h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8">
                    Join hundreds of neighbors who already shop local with OneBasket.
                </p>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-8 py-3.5 rounded-xl font-semibold transition-all shadow-lg shadow-primary-600/20 hover:shadow-xl hover:shadow-primary-600/30 text-sm sm:text-base">
                    Create your free account
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

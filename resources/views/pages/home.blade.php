@extends('layouts.app')

@section('title', 'OneBasket — Shop Local')

@section('content')
{{-- ─── Hero Section ──────────────────────────────────────────── --}}
<div class="relative overflow-hidden gradient-animate">
    {{-- Decorative background elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -right-24 w-96 h-96 hero-circle opacity-60"></div>
        <div class="absolute -bottom-32 -left-32 w-[30rem] h-[30rem] hero-circle opacity-40"></div>
        <div class="absolute top-1/4 left-1/2 w-64 h-64 hero-circle opacity-30"></div>
        {{-- Floating geometric shapes --}}
        <div class="absolute top-20 right-[15%] w-6 h-6 border-2 border-white/20 rounded-lg float opacity-40"></div>
        <div class="absolute bottom-28 left-[10%] w-4 h-4 bg-white/10 rounded-full float-delayed opacity-50"></div>
        <div class="absolute top-1/3 left-[8%] w-3 h-3 bg-primary-300/20 rounded-full float opacity-30" style="animation-delay: 0.8s;"></div>
        <div class="absolute bottom-1/3 right-[12%] w-5 h-5 border border-primary-200/20 rounded-full float-delayed opacity-40"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-block px-4 py-1.5 mb-5 text-xs font-semibold tracking-wider uppercase text-white/90 bg-white/10 backdrop-blur-sm rounded-full border border-white/10 slide-up">
                Your Local Marketplace
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-[1.1] tracking-tight fade-in">
                Shop from multiple stores.
                <span class="gradient-text-warm block mt-2">One delivery.</span>
            </h1>
            <p class="mt-5 text-lg sm:text-xl text-primary-100/90 max-w-2xl mx-auto leading-relaxed slide-up delay-100">
                Fresh groceries, baked goods, and daily essentials — delivered together from your local vendors.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 slide-up delay-200">
                <a href="{{ route('products.index') }}"
                   class="group relative inline-flex items-center gap-2 bg-white text-primary-700 hover:text-primary-600 px-8 py-3.5 rounded-xl font-semibold transition-all shadow-lg shadow-black/10 hover:shadow-xl hover:shadow-primary-500/20 text-sm sm:text-base overflow-hidden">
                    <span class="relative z-10">Browse Products</span>
                    <svg class="relative z-10 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                    <div class="absolute inset-0 bg-gradient-to-r from-white via-primary-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </a>
                <a href="{{ route('categories.index') }}"
                   class="group inline-flex items-center gap-2 bg-primary-500/10 backdrop-blur-sm text-white border border-white/20 hover:bg-primary-500/20 hover:border-white/30 px-8 py-3.5 rounded-xl font-semibold transition-all text-sm sm:text-base">
                    Shop by Category
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Bottom wave transition --}}
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-gray-50 dark:from-gray-950 to-transparent pointer-events-none"></div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

    {{-- ─── Featured Products ─────────────────────────────────── --}}
    @if($featured->count())
        <section class="mb-20">
            <div class="flex items-center justify-between mb-8 fade-in">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Featured Products</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Handpicked favorites from local vendors</p>
                </div>
                <a href="{{ route('products.index', ['sort' => 'newest']) }}"
                   class="group inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                    View all
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 stagger-children">
                @foreach($featured as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Section divider --}}
    <div class="section-divider mb-20"></div>

    {{-- ─── Shop by Category ──────────────────────────────────── --}}
    @if($categories->count())
        <section class="mb-20">
            <div class="flex items-center justify-between mb-8 fade-in">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Shop by Category</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Find exactly what you're craving</p>
                </div>
                <a href="{{ route('categories.index') }}"
                   class="group inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                    All categories
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 stagger-children">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category) }}"
                       class="group card-glow bg-white dark:bg-gray-800/80 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 text-center hover:border-primary-200 dark:hover:border-primary-700 transition-all">
                        <div class="w-14 h-14 mx-auto rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm">
                            @switch($category->slug)
                                @case('groceries') 🍎 @break
                                @case('bakery') 🥖 @break
                                @case('dairy') 🥛 @break
                                @case('beverages') 🥤 @break
                                @case('snacks') 🍪 @break
                                @case('pharmacy') 💊 @break
                                @case('personal-care') 🧴 @break
                                @default 🛒
                            @endswitch
                        </div>
                        <h3 class="mt-4 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            {{ $category->name }}
                        </h3>
                        @if($category->products_count ?? false)
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">{{ $category->products_count }} items</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Section divider --}}
    <div class="section-divider mb-20"></div>

    {{-- ─── New Arrivals ──────────────────────────────────────── --}}
    @if($newProducts->count())
        <section class="mb-20">
            <div class="flex items-center justify-between mb-8 fade-in">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">New Arrivals</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Fresh from the vendors</p>
                </div>
                <a href="{{ route('products.index', ['sort' => 'newest']) }}"
                   class="group inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                    View all
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 stagger-children">
                @foreach($newProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Section divider --}}
    <div class="section-divider mb-20"></div>

    {{-- ─── Local Vendors ─────────────────────────────────────── --}}
    @if($vendors->count())
        <section class="mb-8">
            <div class="flex items-center justify-between mb-8 fade-in">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Our Vendors</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Meet the local businesses behind your order</p>
                </div>
                <a href="{{ route('vendors.index') }}"
                   class="group inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                    Meet all vendors
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 stagger-children">
                @foreach($vendors as $vendor)
                    <a href="{{ route('products.index', ['vendor' => $vendor->slug]) }}"
                       class="group card-glow bg-white dark:bg-gray-800/80 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-5 hover:border-primary-200 dark:hover:border-primary-700 transition-all flex items-center gap-4">
                        @if($vendor->logo)
                            <div class="relative shrink-0">
                                <img src="{{ $vendor->logo }}" alt="" class="w-14 h-14 rounded-xl object-cover shadow-sm ring-2 ring-gray-50 dark:ring-gray-800">
                            </div>
                        @else
                            <div class="w-14 h-14 shrink-0 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold text-lg shadow-sm ring-2 ring-gray-50 dark:ring-gray-800">
                                {{ substr($vendor->business_name, 0, 2) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors truncate">
                                {{ $vendor->business_name }}
                            </h3>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $vendor->products_count ?? 'Free' }} delivery
                                </p>
                            </div>
                        </div>
                        <svg class="ml-auto w-5 h-5 text-gray-300 dark:text-gray-600 group-hover:text-primary-400 group-hover:translate-x-0.5 transition-all shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ─── Trust / Stats Bar ─────────────────────────────────── --}}
    <section class="mt-16 mb-8 fade-in">
        <div class="bg-gradient-to-r from-primary-50 via-white to-primary-50 dark:from-gray-800/50 dark:via-gray-900/50 dark:to-gray-800/50 rounded-3xl border border-primary-100 dark:border-gray-700/40 p-8 sm:p-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="space-y-1">
                    <p class="text-3xl font-bold gradient-text">50+</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Local Vendors</p>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-bold gradient-text">1K+</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Products</p>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-bold gradient-text">10K+</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Happy Customers</p>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-bold gradient-text">99%</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">On-Time Delivery</p>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

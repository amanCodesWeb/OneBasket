@extends('layouts.app')

@section('title', 'Our Vendors')

@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-white via-primary-50/30 to-white dark:from-gray-900 dark:via-primary-950/20 dark:to-gray-900">
        {{-- Decorative blobs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-primary-200/20 dark:bg-primary-800/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-32 -left-20 w-96 h-96 bg-primary-100/30 dark:bg-primary-900/10 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-50 dark:bg-primary-900/20 border border-primary-200/50 dark:border-primary-800/30 text-primary-600 dark:text-primary-400 text-xs font-medium tracking-wide mb-6 fade-in">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $vendors->count() }} trusted vendor{{ $vendors->count() !== 1 ? 's' : '' }} on OneBasket</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight slide-up">
                    Our <span class="gradient-text">Vendors</span>
                </h1>
                <p class="mt-4 sm:mt-5 text-lg sm:text-xl text-gray-500 dark:text-gray-400 max-w-2xl mx-auto slide-up" style="animation-delay: 0.1s;">
                    Browse trusted local businesses near you. Fresh produce, quality goods — all from vendors in your community.
                </p>
                {{-- Search / Filter Bar --}}
                <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 max-w-xl mx-auto slide-up" style="animation-delay: 0.2s;">
                    <div class="relative flex-1">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                        <input type="text" id="vendor-search" placeholder="Search vendors by name or product..."
                               class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 pl-11 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    </div>
                    <button class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium transition shadow-sm shadow-primary-600/20 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/>
                        </svg>
                        <span>Filter</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Vendors Grid --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        @if($vendors->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" id="vendors-grid">
                @foreach($vendors as $index => $vendor)
                    <a href="{{ route('products.index', ['vendor' => $vendor->slug]) }}"
                       class="group bg-white dark:bg-gray-800/90 rounded-2xl border border-gray-200 dark:border-gray-700/80 p-6 card-hover hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-lg hover:shadow-primary-600/5 dark:hover:shadow-primary-900/20 relative overflow-hidden"
                       style="animation: slideUp 0.4s ease-out forwards; animation-delay: {{ $index * 0.05 }}s; opacity: 0;">

                        {{-- Teal accent stripe top --}}
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-400 to-primary-600 dark:from-primary-500 dark:to-primary-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <div class="flex items-center gap-4">
                            @if($vendor->logo)
                                <img src="{{ $vendor->logo }}" alt="{{ $vendor->business_name }}"
                                     class="w-14 h-14 rounded-xl object-cover ring-2 ring-gray-100 dark:ring-gray-700 group-hover:ring-primary-200 dark:group-hover:ring-primary-800 transition-all duration-300">
                            @else
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold text-lg ring-2 ring-primary-100 dark:ring-primary-900/30 group-hover:ring-primary-300 dark:group-hover:ring-primary-700 transition-all duration-300">
                                    {{ substr($vendor->business_name, 0, 2) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 truncate transition-colors duration-200">
                                    {{ $vendor->business_name }}
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                    {{ $vendor->user?->name ?? 'Vendor' }}
                                </p>
                            </div>
                        </div>

                        @if($vendor->description)
                            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                {{ $vendor->description }}
                            </p>
                        @endif

                        <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700/50 flex items-center justify-between text-xs text-gray-400 dark:text-gray-500">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                                <span>{{ $vendor->delivery_radius_km }} km radius</span>
                            </span>
                            @if($vendor->verified_at)
                                <span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400 font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Verified</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-gray-400 dark:text-gray-600">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                    </svg>
                                    <span>Pending</span>
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 fade-in">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-100 dark:bg-gray-800 mb-6">
                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Vendors Available Yet</h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                    We're growing our marketplace. Check back soon or
                    <a href="{{ route('vendor.apply') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium underline underline-offset-2">apply to become a vendor</a>.
                </p>
            </div>
        @endif
    </section>

    {{-- CTA Section (when vendors exist) --}}
    @if($vendors->count())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 sm:pb-20">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-600 to-primary-800 dark:from-primary-700 dark:to-primary-950 px-6 py-12 sm:px-12 sm:py-16 text-center">
                <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-10 -left-10 w-60 h-60 bg-white/5 rounded-full blur-3xl"></div>
                </div>
                <div class="relative">
                    <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3">Are You a Local Vendor?</h2>
                    <p class="text-primary-100 max-w-lg mx-auto mb-6">
                        Join OneBasket and start selling to customers in your area. Simple setup, reliable payments.
                    </p>
                    <a href="{{ route('vendor.apply') }}"
                       class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-white text-primary-700 font-semibold hover:bg-primary-50 transition shadow-lg shadow-black/10 card-hover">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        <span>Become a Vendor</span>
                    </a>
                </div>
            </div>
        </section>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('vendor-search');
            const grid = document.getElementById('vendors-grid');
            if (!searchInput || !grid) return;

            const cards = grid.querySelectorAll('a');

            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase().trim();

                cards.forEach(card => {
                    const name = card.querySelector('h2')?.textContent?.toLowerCase() || '';
                    const desc = card.querySelector('p.line-clamp-2')?.textContent?.toLowerCase() || '';
                    const vendor = card.querySelector('.text-gray-500.truncate')?.textContent?.toLowerCase() || '';

                    const match = name.includes(query) || desc.includes(query) || vendor.includes(query);
                    card.style.display = match ? '' : 'none';
                });
            });
        });
    </script>
    @endpush
@endsection

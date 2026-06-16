<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — OneBasket</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased flex flex-col">
    <script>
        if (localStorage.getItem('onebasket-theme') === 'dark' ||
            (!localStorage.getItem('onebasket-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    {{-- Navigation — fixed + glass on scroll via JS --}}
    <header id="main-header" class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200/80 dark:border-gray-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-primary-600 dark:text-primary-400 font-bold text-lg">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        OneBasket
                    </a>
                </div>

                {{-- Nav links (desktop) --}}
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Products
                    </a>
                    <a href="{{ route('categories.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Categories
                    </a>
                    <a href="{{ route('vendors.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Vendors
                    </a>
                </nav>

                {{-- Right side: cart, auth, dark toggle --}}
                <div class="flex items-center gap-2">
                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-8h9.464c.571 0 1.036.433 1.086 1.002l.526 6.823a1.5 1.5 0 01-1.494 1.675H10.5m0 0a3 3 0 00-3 3m3 0a3 3 0 00-3-3m3 3a3 3 0 013 0m-3-3a3 3 0 013 3m-9.75-3h1.965a.75.75 0 00.743-.667l.142-1.143M2.25 6.75h18M7.5 14.25a3 3 0 013 3"/>
                        </svg>
                        @php $cartCount = auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->sum('quantity') : 0; @endphp
                        @if($cartCount)
                            <span class="absolute -top-0.5 -right-0.5 flex items-center justify-center w-5 h-5 rounded-full bg-primary-600 text-white text-[10px] font-bold shadow-sm ring-2 ring-white dark:ring-gray-900 badge-pulse">{{ min($cartCount, 99) }}</span>
                        @endif
                    </a>

                    {{-- Theme toggle --}}
                    <button id="theme-toggle" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition" title="Toggle theme">
                        <svg class="w-5 h-5 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    {{-- Auth links (desktop) --}}
                    @auth
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'vendor' ? route('vendor.dashboard') : route('orders.index')) }}"
                           class="hidden md:inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ auth()->user()->name }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                            @csrf
                            <button type="submit" class="px-3 py-2 text-sm font-medium rounded-lg text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 transition shadow-sm">
                            Sign In
                        </a>
                    @endauth

                    {{-- Hamburger (mobile) --}}
                    <button id="mobile-menu-toggle" class="md:hidden p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition" aria-label="Menu">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('products.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">Products</a>
                <a href="{{ route('categories.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">Categories</a>
                <a href="{{ route('vendors.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">Vendors</a>
                <hr class="my-2 border-gray-200 dark:border-gray-700">
                @auth
                    <a href="{{ route('orders.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">My Orders</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2.5 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition">Sign In</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Create Account</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Page content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 text-primary-600 dark:text-primary-400 font-bold text-lg mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        OneBasket
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Your local marketplace for fresh groceries and essentials.</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Quick Links</h3>
                    <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                        <li><a href="{{ route('products.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition">Products</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition">Categories</a></li>
                        <li><a href="{{ route('vendors.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition">Vendors</a></li>
                        <li><a href="{{ route('vendor.apply') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition">Become a Vendor</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Support</h3>
                    <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                        <li><a href="#" class="hover:text-primary-600 dark:hover:text-primary-400 transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-primary-600 dark:hover:text-primary-400 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-primary-600 dark:hover:text-primary-400 transition">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-800 text-center text-sm text-gray-400 dark:text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- JS --}}
    <script>
        // Theme toggle
        document.getElementById('theme-toggle')?.addEventListener('click', function() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.setItem('onebasket-theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu on link click
        document.querySelectorAll('#mobile-menu a, #mobile-menu button').forEach(el => {
            el.addEventListener('click', function() {
                document.getElementById('mobile-menu')?.classList.add('hidden');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>

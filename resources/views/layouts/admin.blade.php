<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased">
    <script>
        if (localStorage.getItem('onebasket-theme') === 'dark' ||
            (!localStorage.getItem('onebasket-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside class="hidden lg:flex lg:flex-col w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-2 h-16 px-6 border-b border-gray-200 dark:border-gray-800">
                <a href="/" class="flex items-center gap-2 text-lg font-bold text-primary-600 dark:text-primary-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    OneBasket
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium @if(request()->routeIs('admin.dashboard')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 @endif transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Management</p>
                <a href="{{ route('admin.vendors.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium @if(request()->routeIs('admin.vendors.*')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 @endif transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Vendors
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium @if(request()->routeIs('admin.products.*')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 @endif transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium @if(request()->routeIs('admin.orders.*')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 @endif transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Orders
                </a>

                <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Operations</p>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition opacity-50">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Pickups
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition opacity-50">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    Packing
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition opacity-50">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Deliveries
                </a>

                <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Settings</p>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition opacity-50">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
            </nav>
        </aside>

        {{-- Main content area --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top bar --}}
            <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 h-16 flex items-center justify-between px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    {{-- Mobile menu toggle --}}
                    <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <h1 class="text-lg font-semibold text-gray-900 dark:text-white">@yield('heading', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-3">
                    <button id="admin-theme-toggle" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition" title="Toggle theme">
                        <svg class="w-5 h-5 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500 dark:text-gray-400 hidden sm:inline">{{ auth()->user()?->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 dark:text-gray-400 hover:text-red-500 transition">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50 dark:bg-gray-950">
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-sm">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Theme toggle JS --}}
    <script>
        document.getElementById('admin-theme-toggle')?.addEventListener('click', function() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('onebasket-theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('onebasket-theme', 'dark');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

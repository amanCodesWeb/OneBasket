<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }} Vendor</title>
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
                <a href="{{ route('vendor.dashboard') }}" class="flex items-center gap-2 text-lg font-bold text-primary-600 dark:text-primary-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    My Store
                </a>
            </div>
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <a href="{{ route('vendor.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium @if(request()->routeIs('vendor.dashboard')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 @endif transition">
                    Dashboard
                </a>
                <a href="{{ route('vendor.profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium @if(request()->routeIs('vendor.profile.edit')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 @endif transition">
                    Profile
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 h-16 flex items-center justify-between px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-900 dark:text-white">@yield('heading', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <button id="theme-toggle" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 dark:text-gray-400 hover:text-red-500 transition">Logout</button>
                    </form>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50 dark:bg-gray-950">
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 text-sm">{{ session('success') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        document.getElementById('theme-toggle')?.addEventListener('click', function() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.setItem('onebasket-theme', html.classList.contains('dark') ? 'dark' : 'light');
        });
    </script>
    @stack('scripts')
</body>
</html>

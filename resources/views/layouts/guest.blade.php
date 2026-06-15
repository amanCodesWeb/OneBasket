<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .guest-bg {
            background: linear-gradient(135deg, #f0fdfa 0%, #e0f2fe 50%, #f0fdfa 100%);
        }
        .dark .guest-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        .guest-bg::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(13, 148, 136, 0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 50%, rgba(99, 102, 241, 0.04) 0%, transparent 50%);
            pointer-events: none;
        }
    </style>
</head>
<body class="min-h-screen guest-bg text-gray-900 dark:text-gray-100 antialiased flex flex-col items-center justify-center px-4 relative">
    <script>
        if (localStorage.getItem('onebasket-theme') === 'dark' ||
            (!localStorage.getItem('onebasket-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2 text-2xl font-bold text-primary-600 dark:text-primary-400">
                <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span>OneBasket</span>
            </a>
        </div>

        <div class="bg-white/90 dark:bg-gray-800/90 rounded-2xl shadow-xl border border-gray-200/80 dark:border-gray-700/50 p-6 sm:p-8 backdrop-blur-xl">
            @yield('content')
        </div>

        <p class="text-center mt-6 text-sm text-gray-400 dark:text-gray-600">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>

    @stack('scripts')
</body>
</html>

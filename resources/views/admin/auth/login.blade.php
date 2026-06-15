<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .admin-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        .admin-bg::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(13, 148, 136, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 50%, rgba(99, 102, 241, 0.06) 0%, transparent 50%);
            pointer-events: none;
        }
    </style>
</head>
<body class="min-h-screen admin-bg text-gray-100 antialiased flex flex-col items-center justify-center px-4 relative">
    <script>
        if (localStorage.getItem('onebasket-theme') === 'dark' ||
            (!localStorage.getItem('onebasket-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <div class="w-full max-w-md relative z-10">
        {{-- Logo / Branding --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-primary-600/20 border border-primary-500/30 mb-4">
                <svg class="w-7 h-7 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">OneBasket</h1>
            <p class="mt-1 text-sm text-gray-500">Administrator Panel</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-gray-800/70 border border-gray-700/50 rounded-2xl p-8 shadow-xl backdrop-blur-xl">
            <h2 class="text-lg font-semibold text-white mb-1">Welcome back</h2>
            <p class="text-sm text-gray-500 mb-6">Sign in to your admin account to continue.</p>

            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-900/30 border border-red-800/40 text-red-300 text-sm">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ url('/admin/login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Email address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               class="w-full rounded-xl border border-gray-600 bg-gray-700/50 pl-10 pr-4 py-2.5 text-sm text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('email') border-red-500 @enderror"
                               placeholder="admin@example.com">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required
                               class="w-full rounded-xl border border-gray-600 bg-gray-700/50 pl-10 pr-4 py-2.5 text-sm text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('password') border-red-500 @enderror"
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer hover:text-gray-300 transition">
                        <input type="checkbox" name="remember"
                               class="rounded border-gray-600 bg-gray-700 text-primary-500 focus:ring-primary-500 focus:ring-offset-0 cursor-pointer">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('login') }}" class="text-sm text-primary-400 hover:text-primary-300 transition">
                        Public login &rarr;
                    </a>
                </div>

                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-500 text-white font-medium py-2.5 rounded-xl transition shadow-lg shadow-primary-600/20">
                    Sign in to Admin
                </button>
            </form>
        </div>

        {{-- Footer --}}
        <p class="text-center mt-8 text-xs text-gray-600">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>
</html>

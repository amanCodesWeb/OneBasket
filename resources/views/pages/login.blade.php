@extends('layouts.guest')

@section('title', 'Login — OneBasket')

@section('content')
    {{-- Brand icon with float animation --}}
    <div class="text-center mb-8 fade-in">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 shadow-lg shadow-primary-500/20 mb-4 float">
            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold gradient-text">Welcome back</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1.5">Sign in to your account to continue.</p>
    </div>

    {{-- Glass card with glow --}}
    <div class="glass rounded-2xl p-6 sm:p-8 card-glow slide-up">
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div class="fade-in delay-100">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-primary-500">
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800/50 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500/40 focus:border-primary-500 outline-none transition-all duration-200 @error('email') border-red-400 focus:ring-red-500/40 focus:border-red-500 @enderror"
                           placeholder="you@example.com">
                </div>
                @error('email')
                    <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="fade-in delay-200">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-primary-500">
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" required
                           class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800/50 pl-10 pr-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500/40 focus:border-primary-500 outline-none transition-all duration-200 @error('password') border-red-400 focus:ring-red-500/40 focus:border-red-500 @enderror"
                           placeholder="••••••••">
                </div>
                @error('password')
                    <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="fade-in delay-300 flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 cursor-pointer hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200 group">
                    <input type="checkbox" name="remember"
                           class="rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-primary-600 focus:ring-primary-500 focus:ring-offset-0 cursor-pointer transition-all duration-200">
                    <span class="group-hover:text-gray-700 dark:group-hover:text-gray-300">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-500 font-medium transition-colors duration-200">Forgot password?</a>
                @endif
            </div>

            {{-- Subtle divider --}}
            <div class="section-divider"></div>

            {{-- Submit button --}}
            <div class="fade-in delay-400">
                <button type="submit"
                        class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-primary-600 to-primary-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition-all duration-300 hover:shadow-xl hover:shadow-primary-600/30 hover:from-primary-500 hover:to-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500/40 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-900 active:scale-[0.98]">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Sign in
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                    {{-- Shimmer sweep on hover --}}
                    <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 bg-gradient-to-r from-transparent via-white/15 to-transparent skew-x-[-20deg]"></div>
                </button>
            </div>
        </form>
    </div>

    {{-- Register link --}}
    <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400 fade-in delay-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-500 font-semibold transition-colors duration-200">Create one</a>
    </p>

    {{-- Security badge --}}
    <div class="mt-6 text-center fade-in delay-600">
        <span class="inline-flex items-center gap-1.5 text-xs text-gray-400 dark:text-gray-500">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
            Secured with encryption
        </span>
    </div>
@endsection

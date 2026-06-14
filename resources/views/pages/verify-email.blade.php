@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
    <div class="text-center">
        <div class="w-12 h-12 mx-auto rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-600 dark:text-amber-400 mb-4">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Verify your email</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
            We sent a verification link to <strong class="text-gray-700 dark:text-gray-300">{{ auth()->user()?->email }}</strong>.
            <br>Please check your inbox and click the link to activate your account.
        </p>

        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                Resend verification email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="text-sm text-gray-500 dark:text-gray-400 hover:text-red-500 transition">
                Logout
            </button>
        </form>
    </div>
@endsection

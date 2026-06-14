@extends('layouts.app')

@section('title', 'Our Vendors')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Our Vendors</h1>

    @if($vendors->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vendors as $vendor)
                <a href="{{ route('products.index', ['vendor' => $vendor->slug]) }}" class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-md transition">
                    <div class="flex items-center gap-4">
                        @if($vendor->logo)
                            <img src="{{ $vendor->logo }}" alt="" class="w-14 h-14 rounded-xl object-cover">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold text-lg">
                                {{ substr($vendor->business_name, 0, 2) }}
                            </div>
                        @endif
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400">{{ $vendor->business_name }}</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $vendor->user?->name }}</p>
                        </div>
                    </div>
                    @if($vendor->description)
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400 line-clamp-2">{{ $vendor->description }}</p>
                    @endif
                    <div class="mt-4 flex items-center gap-4 text-xs text-gray-400">
                        <span>Radius: {{ $vendor->delivery_radius_km }}km</span>
                        @if($vendor->verified_at)
                            <span class="text-green-500">✓ Verified</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <p class="text-gray-500 dark:text-gray-400">No vendors available yet.</p>
        </div>
    @endif
</div>
@endsection

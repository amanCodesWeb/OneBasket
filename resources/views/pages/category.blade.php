@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <a href="{{ route('categories.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition">&larr; All Categories</a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $category->name }}</h1>
        @if($category->description)
            <p class="mt-1 text-gray-500 dark:text-gray-400">{{ $category->description }}</p>
        @endif
    </div>

    @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <p class="text-gray-500 dark:text-gray-400">No products found in this category.</p>
        </div>
    @endif
</div>
@endsection

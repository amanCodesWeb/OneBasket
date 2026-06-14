@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Shop by Category</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-md transition">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400">{{ $category->name }}</h2>
                @if($category->description)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $category->description }}</p>
                @endif
                @if($category->children->count())
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($category->children as $child)
                            <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2.5 py-1 rounded-full">{{ $child->name }}</span>
                        @endforeach
                    </div>
                @endif
            </a>
        @endforeach
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Page header --}}
    <div class="text-center mb-12 slide-up">
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">
            Shop by <span class="gradient-text">Category</span>
        </h1>
        <div class="mt-3 mx-auto h-1 w-20 bg-gradient-to-r from-primary-500 to-primary-400 rounded-full"></div>
        <p class="mt-4 text-gray-500 dark:text-gray-400 max-w-lg mx-auto text-sm">
            Browse our curated categories to find exactly what you need — from fresh produce to pantry staples.
        </p>
    </div>

    {{-- Categories grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}"
               class="group relative bg-white dark:bg-gray-800/80 rounded-2xl border border-gray-200 dark:border-gray-700/80 overflow-hidden hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-xl hover:shadow-primary-500/5 dark:hover:shadow-black/20 transition-all duration-300 card-hover">
                {{-- Top accent bar --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-primary-500 to-primary-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                <div class="p-6">
                    {{-- Category icon & name --}}
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 shadow-sm ring-1 ring-primary-200/50 dark:ring-primary-700/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $category->name }}</h2>
                                @if($category->products_count ?? false)
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $category->products_count }} product{{ $category->products_count !== 1 ? 's' : '' }}</p>
                                @endif
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 group-hover:text-primary-500 transition-colors shrink-0 mt-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </div>

                    {{-- Description --}}
                    @if($category->description)
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">{{ $category->description }}</p>
                    @endif

                    {{-- Subcategories --}}
                    @if($category->children->count())
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($category->children->take(4) as $child)
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-600/50 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400 hover:border-primary-200 dark:hover:border-primary-700 transition">{{ $child->name }}</span>
                                @endforeach
                                @if($category->children->count() > 4)
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-gray-100 dark:bg-gray-700/60 text-gray-400 dark:text-gray-500">+{{ $category->children->count() - 4 }} more</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    @if($categories->isEmpty())
        {{-- Empty state --}}
        <div class="text-center py-20 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/80 shadow-sm">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">No categories yet</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Categories will appear here once they are set up.</p>
        </div>
    @endif
</div>
@endsection

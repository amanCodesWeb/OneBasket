@extends('layouts.admin')

@section('title', $category->name)
@section('heading', $category->name)

@section('content')
    {{-- Back link --}}
    <div class="mb-5 fade-in">
        <a href="{{ route('admin.categories.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Categories
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Info card --}}
            <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                <div class="flex items-start gap-4 mb-6">
                    @if($category->image)
                        <img src="{{ $category->image }}" alt="" class="w-16 h-16 rounded-xl object-cover ring-2 ring-gray-200 dark:ring-gray-700">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 text-xl font-bold ring-2 ring-gray-200 dark:ring-gray-700">
                            {{ substr($category->name, 0, 2) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $category->name }}</h3>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($category->is_active) bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 ring-1 ring-green-200 dark:ring-green-800
                                @else bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 ring-1 ring-gray-200 dark:ring-gray-600 @endif">
                                <span class="w-1.5 h-1.5 rounded-full @if($category->is_active) bg-green-500 @else bg-gray-400 @endif"></span>
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        @if($category->parent)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Subcategory of <span class="font-medium text-gray-700 dark:text-gray-300">{{ $category->parent->name }}</span>
                            </p>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Top-level category</p>
                        @endif
                    </div>
                </div>

                @if($category->description)
                    <div class="section-divider mb-5"></div>
                    <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Description</h4>
                    <p class="text-gray-700 dark:text-gray-300 text-sm whitespace-pre-line leading-relaxed">{{ $category->description }}</p>
                @endif
            </div>

            {{-- Subcategories --}}
            @if($category->children->count())
                <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                    <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Subcategories ({{ $category->children->count() }})
                    </h4>
                    <div class="space-y-2">
                        @foreach($category->children as $child)
                            <a href="{{ route('admin.categories.show', $child) }}"
                               class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 text-xs font-bold">
                                    {{ substr($child->name, 0, 2) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $child->name }}</span>
                                    <span class="text-xs text-gray-400 ml-2">{{ $child->products_count ?? $child->products()->count() }} products</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-primary-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Products in this category --}}
            @if($category->products->count())
                <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                    <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Products ({{ $category->products->count() }})
                    </h4>
                    <div class="space-y-2">
                        @foreach($category->products as $product)
                            <a href="{{ route('admin.products.show', $product) }}"
                               class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors group">
                                @if($product->thumbnail)
                                    <img src="{{ $product->thumbnail }}" alt="" class="w-10 h-10 rounded-lg object-cover ring-1 ring-gray-200 dark:ring-gray-700">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 text-xs font-bold ring-1 ring-gray-200 dark:ring-gray-700">
                                        {{ substr($product->name, 0, 2) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $product->name }}</span>
                                    <span class="text-xs text-gray-400 ml-2">Rs. {{ number_format($product->price, 2) }}</span>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    @if($product->is_approved) bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400
                                    @else bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 @endif">
                                    {{ $product->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- Actions --}}
            <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.categories.edit', $category) }}"
                       class="inline-flex items-center justify-center gap-2 w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md hover:shadow-primary-500/20">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Category
                    </a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                          onsubmit="return confirm('Delete this category? Products in it will lose their category assignment.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md hover:shadow-red-500/20">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete Category
                        </button>
                    </form>
                </div>
            </div>

            {{-- Meta --}}
            <div class="card-glow bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 p-6">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Meta</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-500 dark:text-gray-400">ID</span>
                        <span class="text-gray-900 dark:text-white font-mono text-xs">#{{ $category->id }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-500 dark:text-gray-400">Slug</span>
                        <code class="text-gray-900 dark:text-white font-mono text-xs">{{ $category->slug }}</code>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-500 dark:text-gray-400">Sort Order</span>
                        <span class="text-gray-900 dark:text-white">{{ $category->sort_order }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-500 dark:text-gray-400">Created</span>
                        <span class="text-gray-900 dark:text-white text-xs">{{ $category->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

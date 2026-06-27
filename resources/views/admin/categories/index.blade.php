@extends('layouts.admin')

@section('title', 'Categories')
@section('heading', 'Categories')

@section('content')
    {{-- Header --}}
    <div class="relative mb-6 overflow-hidden rounded-xl bg-gradient-to-r from-primary-600/10 via-transparent to-transparent dark:from-primary-800/10 p-4 sm:p-5 fade-in">
        <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-primary-500 to-primary-300 rounded-full"></div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10">
            <div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Category Management</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ $categories->total() }} categor{{ ($categories->total()) !== 1 ? 'ies' : 'y' }}
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.categories.create') }}"
                   class="inline-flex items-center gap-1.5 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md hover:shadow-primary-500/20 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Category
                </a>
            </div>
        </div>
    </div>

    {{-- Categories table --}}
    <div class="slide-up bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 overflow-hidden shadow-sm">
        @if($categories->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Name</th>
                            <th class="text-left px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Parent</th>
                            <th class="text-left px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Slug</th>
                            <th class="text-center px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Products</th>
                            <th class="text-center px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Order</th>
                            <th class="text-center px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Status</th>
                            <th class="text-right px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                        @foreach($categories as $cat)
                            <tr class="table-row hover:bg-primary-50/40 dark:hover:bg-primary-900/10">
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if($cat->image)
                                            <img src="{{ $cat->image }}" alt="" class="w-9 h-9 rounded-lg object-cover ring-1 ring-gray-200 dark:ring-gray-700">
                                        @else
                                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-600 dark:text-primary-400 text-xs font-bold ring-1 ring-gray-200 dark:ring-gray-700">
                                                {{ substr($cat->name, 0, 2) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $cat->name }}</span>
                                            @if($cat->description)
                                                <p class="text-xs text-gray-400 truncate max-w-[200px]">{{ Str::limit($cat->description, 60) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-gray-600 dark:text-gray-400">
                                    {{ $cat->parent?->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3.5">
                                    <code class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ $cat->slug }}</code>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2rem] px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $cat->products_count > 0 ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }}">
                                        {{ $cat->products_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-center text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $cat->sort_order }}
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        @if($cat->is_active) bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 ring-1 ring-green-200 dark:ring-green-800
                                        @else bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 ring-1 ring-gray-200 dark:ring-gray-600 @endif">
                                        <span class="w-1.5 h-1.5 rounded-full @if($cat->is_active) bg-green-500 @else bg-gray-400 @endif"></span>
                                        {{ $cat->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.categories.show', $cat) }}"
                                           class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            View
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $cat) }}"
                                           class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                              onsubmit="return confirm('Delete this category? Products in it will lose their category assignment.')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                               title="Delete category">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3.5 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30">
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-16 px-6">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center text-primary-400 mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <p class="text-base font-semibold text-gray-900 dark:text-white mb-1">No categories yet</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Create your first category to organize products.</p>
                <a href="{{ route('admin.categories.create') }}"
                   class="inline-flex items-center gap-1.5 bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md hover:shadow-primary-500/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Category
                </a>
            </div>
        @endif
    </div>
@endsection

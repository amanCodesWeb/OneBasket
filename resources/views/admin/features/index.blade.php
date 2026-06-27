@extends('layouts.admin')

@section('title', 'Product Features')
@section('heading', 'Product Features')

@section('content')
    {{-- Header --}}
    <div class="relative mb-6 overflow-hidden rounded-xl bg-gradient-to-r from-primary-600/10 via-transparent to-transparent dark:from-primary-800/10 p-4 sm:p-5 fade-in">
        <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-primary-500 to-primary-300 rounded-full"></div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10">
            <div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Feature Management</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ $features->total() }} feature{{ ($features->total()) !== 1 ? 's' : '' }}
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.features.create') }}"
                   class="inline-flex items-center gap-1.5 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md hover:shadow-primary-500/20 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Feature
                </a>
            </div>
        </div>
    </div>

    {{-- Features table --}}
    <div class="slide-up bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 overflow-hidden shadow-sm">
        @if($features->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Feature</th>
                            <th class="text-center px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Type</th>
                            <th class="text-left px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Options</th>
                            <th class="text-center px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Products</th>
                            <th class="text-center px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Order</th>
                            <th class="text-center px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Status</th>
                            <th class="text-right px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                        @foreach($features as $feature)
                            <tr class="table-row hover:bg-primary-50/40 dark:hover:bg-primary-900/10">
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/20 flex items-center justify-center text-purple-600 dark:text-purple-400 text-xs font-bold ring-1 ring-gray-200 dark:ring-gray-700">
                                            {{ substr($feature->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $feature->name }}</span>
                                            <p class="text-xs text-gray-400">
                                                <code class="text-[10px] font-mono">{{ $feature->slug }}</code>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        @switch($feature->type)
                                            @case('text') bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 ring-1 ring-blue-200 dark:ring-blue-800 @break
                                            @case('boolean') bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 ring-1 ring-green-200 dark:ring-green-800 @break
                                            @case('select') bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 ring-1 ring-amber-200 dark:ring-amber-800 @break
                                            @case('multi_select') bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 ring-1 ring-purple-200 dark:ring-purple-800 @break
                                        @endswitch">
                                        {{ str_replace('_', ' ', ucfirst($feature->type)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-gray-600 dark:text-gray-400 text-xs max-w-[200px] truncate">
                                    @if(in_array($feature->type, ['select', 'multi_select']) && $feature->options)
                                        {{ collect($feature->options)->pluck('label')->implode(', ') }}
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2rem] px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $feature->products_count > 0 ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }}">
                                        {{ $feature->products_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-center text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $feature->sort_order }}
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        @if($feature->is_active) bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 ring-1 ring-green-200 dark:ring-green-800
                                        @else bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 ring-1 ring-gray-200 dark:ring-gray-600 @endif">
                                        <span class="w-1.5 h-1.5 rounded-full @if($feature->is_active) bg-green-500 @else bg-gray-400 @endif"></span>
                                        {{ $feature->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.features.edit', $feature) }}"
                                           class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.features.destroy', $feature) }}"
                                              onsubmit="return confirm('Delete this feature? Products using it will lose this data.')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                               title="Delete feature">
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
                {{ $features->links() }}
            </div>
        @else
            <div class="text-center py-16 px-6">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/20 flex items-center justify-center text-purple-400 mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                    </svg>
                </div>
                <p class="text-base font-semibold text-gray-900 dark:text-white mb-1">No features yet</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Create features like "Organic", "Size", "Weight" to attach dynamic data to products.</p>
                <a href="{{ route('admin.features.create') }}"
                   class="inline-flex items-center gap-1.5 bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md hover:shadow-primary-500/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Feature
                </a>
            </div>
        @endif
    </div>
@endsection

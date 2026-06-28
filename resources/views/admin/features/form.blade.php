@extends('layouts.admin')

@section('title', isset($feature) ? 'Edit Feature' : 'New Feature')
@section('heading', isset($feature) ? 'Edit Feature' : 'New Feature')

@section('content')
    @push('head')
    <style>
        main { overflow: hidden !important; display: flex !important; flex-direction: column !important; }
    </style>
    @endpush

    <form method="POST" action="{{ isset($feature) ? route('admin.features.update', $feature) : route('admin.features.store') }}" class="flex-1 flex flex-col min-h-0">
        @csrf
        @if(isset($feature)) @method('PUT') @endif

        {{-- Always-visible header with Back + Save --}}
        <div class="shrink-0 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.features.index') }}"
                       class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg px-2 py-1.5 transition-colors shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="hidden sm:inline">Back</span>
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.features.index') }}"
                       class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 px-3 py-2">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500/30">
                        {{ isset($feature) ? 'Update Feature' : 'Create Feature' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Scrollable content --}}
        <div class="flex-1 overflow-y-auto min-h-0 px-4 sm:px-6 lg:px-8 py-4">
            <div class="max-w-2xl mx-auto space-y-5">

                <div class="bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gradient-to-r from-purple-50/50 to-transparent dark:from-purple-900/10 dark:to-transparent">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/20 flex items-center justify-center text-purple-600 dark:text-purple-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Feature Details</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Define dynamic attributes vendors can attach to products</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Feature Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $feature->name ?? '') }}" required
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('name') border-red-500 dark:border-red-500 @enderror"
                                   placeholder="e.g. Organic, Weight, Size">
                            @error('name') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug', $feature->slug ?? '') }}"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 font-mono focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('slug') border-red-500 dark:border-red-500 @enderror"
                                   placeholder="Auto-generated from name">
                            @error('slug') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Type --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Feature Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="type-selection">
                                @php $types = ['text' => 'Text', 'boolean' => 'Yes/No', 'select' => 'Select', 'multi_select' => 'Multi Select']; @endphp
                                @foreach($types as $val => $label)
                                    <label class="relative flex items-center justify-center p-3 rounded-lg border-2 cursor-pointer transition-all duration-150
                                        {{ old('type', $feature->type ?? 'text') === $val ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-600' }}">
                                        <input type="radio" name="type" value="{{ $val }}"
                                               class="sr-only"
                                               {{ old('type', $feature->type ?? 'text') === $val ? 'checked' : '' }}
                                               onchange="this.closest('label').querySelector('input').checked = true; document.querySelectorAll('#type-selection label').forEach(l => l.classList.remove('border-primary-500','bg-primary-50','dark:bg-primary-900/20','text-primary-700','dark:text-primary-300')); this.closest('label').classList.add('border-primary-500','bg-primary-50','dark:bg-primary-900/20','text-primary-700','dark:text-primary-300'); toggleOptions()">
                                        <span class="text-sm font-medium">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('type') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Options (for select/multi_select) --}}
                        <div id="options-field" class="{{ in_array(old('type', $feature->type ?? 'text'), ['select', 'multi_select']) ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Options <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Define options as a JSON array of objects with label and value:</p>
                            <textarea name="options" rows="4"
                                      class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 font-mono focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition @error('options') border-red-500 dark:border-red-500 @enderror"
                                      placeholder='[{"label": "Small", "value": "small"}, {"label": "Medium", "value": "medium"}, {"label": "Large", "value": "large"}]'>{{ old('options', is_array($feature->options ?? null) ? json_encode($feature->options, JSON_PRETTY_PRINT) : ($feature->options ?? '[]')) }}</textarea>
                            @error('options') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Sort Order + Active --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Sort Order</label>
                                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $feature->sort_order ?? 0) }}"
                                       class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                            </div>
                            <div class="flex items-end pb-1">
                                <label class="relative inline-flex items-center gap-3 cursor-pointer">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="sr-only peer"
                                           {{ old('is_active', $feature->is_active ?? true) ? 'checked' : '' }}>
                                    <div class="w-10 h-6 rounded-full bg-gray-200 dark:bg-gray-600 peer-checked:bg-primary-500 peer-focus:ring-2 peer-focus:ring-primary-500/30 transition-colors relative after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-4"></div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    function toggleOptions() {
        const selected = document.querySelector('input[name="type"]:checked');
        const optionsField = document.getElementById('options-field');
        if (selected && (selected.value === 'select' || selected.value === 'multi_select')) {
            optionsField.classList.remove('hidden');
        } else {
            optionsField.classList.add('hidden');
        }
    }
    toggleOptions();
    </script>
    @endpush
@endsection

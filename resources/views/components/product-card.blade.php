@props(['product'])
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg hover:border-primary-200 dark:hover:border-primary-700 transition group">
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="aspect-square bg-gray-50 dark:bg-gray-900 relative overflow-hidden">
            @if($product->thumbnail)
                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            @endif
            @if($product->hasDiscount)
                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">-{{ $product->discount_percent }}%</span>
            @endif
            @if($product->featured)
                <span class="absolute top-2 right-2 bg-amber-500 text-white text-xs font-bold px-2 py-0.5 rounded">Featured</span>
            @endif
        </div>
        <div class="p-4">
            <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">{{ $product->vendor?->business_name ?? 'Unknown' }}</p>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition line-clamp-2">{{ $product->name }}</h3>
            <div class="mt-2 flex items-center gap-2">
                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $product->formatted_price }}</span>
                @if($product->hasDiscount)
                    <span class="text-sm text-gray-400 line-through">{{ $product->formatted_compare_price }}</span>
                @endif
            </div>
            @if($product->stock_quantity < 5 && $product->stock_quantity > 0)
                <p class="mt-1 text-xs text-amber-600 dark:text-amber-400">Only {{ $product->stock_quantity }} left</p>
            @endif
            @if($product->stock_quantity === 0)
                <p class="mt-1 text-xs text-red-500">Out of stock</p>
            @endif
        </div>
    </a>
</div>

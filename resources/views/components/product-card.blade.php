@props(['product'])
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg hover:border-primary-200 dark:hover:border-primary-700 transition group flex flex-col">
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
        <div class="p-4 flex-1">
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

    {{-- Add to Cart --}}
    <div class="px-4 pb-4 mt-auto">
        @auth
            @if($product->stock_quantity > 0)
                <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                           class="w-14 text-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none py-1.5">
                    <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-xs font-semibold py-2 px-3 rounded-lg transition flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                        Add
                    </button>
                </form>
            @else
                <button disabled class="w-full bg-gray-100 dark:bg-gray-700 text-gray-400 text-xs font-semibold py-2 px-3 rounded-lg cursor-not-allowed">
                    Out of Stock
                </button>
            @endif
        @else
            <a href="{{ route('login') }}" class="block w-full text-center bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-semibold py-2 px-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                Login to Buy
            </a>
        @endauth
    </div>
</div>

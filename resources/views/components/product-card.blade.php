@props(['product'])
<div class="bg-white dark:bg-gray-800/80 rounded-2xl border border-gray-100 dark:border-gray-700/50 overflow-hidden card-hover group flex flex-col shadow-sm hover:shadow-lg relative">
    {{-- Product image area --}}
    <a href="{{ route('products.show', $product->slug) }}" class="block relative overflow-hidden">
        <div class="aspect-square bg-gray-50 dark:bg-gray-900 relative">
            @if($product->thumbnail)
                <img src="{{ $product->thumbnail }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                     loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                    <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            @endif

            {{-- Gradient overlay at bottom of image --}}
            <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
        </div>

        {{-- Badges --}}
        @if($product->hasDiscount)
            <span class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-[11px] font-bold px-2.5 py-1 rounded-lg shadow-lg shadow-red-500/20">
                -{{ $product->discount_percent }}%
            </span>
        @endif
        @if($product->featured)
            <span class="absolute top-3 right-3 bg-gradient-to-r from-amber-400 to-amber-500 text-white text-[11px] font-bold px-2.5 py-1 rounded-lg shadow-lg shadow-amber-500/20 badge-pulse">
                ★ Featured
            </span>
        @endif

        {{-- Quick view overlay --}}
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300 flex items-center justify-center">
            <span class="text-white text-xs font-semibold bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                Quick view
            </span>
        </div>
    </a>

    {{-- Product info --}}
    <div class="p-4 sm:p-5 flex-1 flex flex-col">
        {{-- Vendor name --}}
        <p class="text-[11px] font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1.5">
            {{ $product->vendor?->business_name ?? 'Unknown' }}
        </p>

        {{-- Product name --}}
        <a href="{{ route('products.show', $product->slug) }}" class="block">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-2 leading-snug">
                {{ $product->name }}
            </h3>
        </a>

        {{-- Rating placeholder --}}
        <div class="mt-1.5 flex items-center gap-1.5">
            <div class="flex items-center gap-0.5">
                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <svg class="w-3.5 h-3.5 text-gray-200 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <span class="text-[11px] text-gray-400 dark:text-gray-500">(4.0)</span>
        </div>

        {{-- Price row --}}
        <div class="mt-auto pt-3 flex items-baseline gap-2">
            @if($product->hasDiscount)
                <span class="text-lg font-bold text-primary-600 dark:text-primary-400">{{ $product->formatted_price }}</span>
                <span class="text-sm text-gray-400 dark:text-gray-500 line-through">{{ $product->formatted_compare_price }}</span>
            @else
                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $product->formatted_price }}</span>
            @endif
        </div>

        {{-- Stock indicator --}}
        @if($product->stock_quantity < 5 && $product->stock_quantity > 0)
            <p class="mt-1.5 flex items-center gap-1 text-[11px] text-amber-600 dark:text-amber-400 font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                Only {{ $product->stock_quantity }} left
            </p>
        @endif
        @if($product->stock_quantity === 0)
            <p class="mt-1.5 text-[11px] text-red-500 font-medium">Out of stock</p>
        @endif
    </div>

    {{-- Add to Cart / Action area --}}
    <div class="px-4 sm:px-5 pb-4 sm:pb-5 mt-auto">
        @auth
            @if($product->stock_quantity > 0)
                <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="relative">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                               class="w-14 text-center rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none py-2 transition-all">
                    </div>
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white text-xs font-semibold py-2.5 px-3 rounded-xl transition-all shadow-md shadow-primary-600/20 hover:shadow-lg hover:shadow-primary-600/30 flex items-center justify-center gap-1.5 group/btn">
                        <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-8h9.464c.571 0 1.036.433 1.086 1.002l.526 6.823a1.5 1.5 0 01-1.494 1.675H10.5m0 0a3 3 0 00-3 3m3 0a3 3 0 00-3-3m3 3a3 3 0 013 0m-3-3a3 3 0 013 3m-9.75-3h1.965a.75.75 0 00.743-.667l.142-1.143M2.25 6.75h18M7.5 14.25a3 3 0 013 3"/>
                        </svg>
                        Add to Cart
                    </button>
                </form>
            @else
                <button disabled
                        class="w-full bg-gray-100 dark:bg-gray-700/50 text-gray-400 dark:text-gray-500 text-xs font-semibold py-2.5 px-3 rounded-xl cursor-not-allowed flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    Out of Stock
                </button>
            @endif
        @else
            <a href="{{ route('login') }}"
               class="block w-full text-center bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-700/30 text-gray-500 dark:text-gray-400 text-xs font-semibold py-2.5 px-3 rounded-xl hover:from-gray-100 hover:to-gray-200 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all border border-gray-200 dark:border-gray-600/50">
                Sign in to purchase
            </a>
        @endauth
    </div>
</div>

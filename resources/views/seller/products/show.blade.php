<x-layouts.seller-dashboard>
    <div class="space-y-8 font-sans antialiased">
        <!-- Header / Back Button -->
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('seller.products.index') }}"
                class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors font-semibold">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Products
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('seller.products.edit', $product) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-bold text-sm rounded-xl shadow-sm hover:bg-red-100 dark:hover:bg-red-900/30 hover:shadow transition-all duration-200 border border-red-100 dark:border-red-900/30">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Product
                </a>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-in-up">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-8">
                <!-- Image Section -->
                <div class="p-8 bg-gray-50 dark:bg-gray-800 flex items-center justify-center min-h-[300px]">
                    @if($product->images->count() > 0)
                        <img src="{{ $product->images->first()->display_url }}" alt="{{ $product->name }}"
                            class="max-h-[300px] w-auto max-w-full object-contain rounded-2xl shadow-sm hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="flex flex-col items-center justify-center text-gray-300 dark:text-gray-600">
                            <svg class="w-24 h-24 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-400 dark:text-gray-500 font-medium text-lg">No image available</span>
                        </div>
                    @endif
                </div>

                <!-- Content Section -->
                <div class="p-8 lg:pl-0 lg:pr-8 lg:py-8 flex flex-col justify-center">

                    <div class="mb-6">
                        <!-- Status Badge -->
                        @if($product->status === 'approved')
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800/30 mb-4">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                                </span>
                                Admin Approved
                            </span>
                        @elseif($product->status === 'rejected')
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800/30 mb-4">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                                </span>
                                Rejected
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800/30 mb-4">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-yellow-400"></span>
                                </span>
                                Pending Admin Approval
                            </span>
                        @endif

                        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h1>
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                            <span
                                class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg border border-gray-200 dark:border-gray-700">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            <span>•</span>
                            <span>Added {{ $product->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-baseline gap-3 mb-4">
                            @if($product->discounted_price)
                                <span
                                    class="text-4xl font-bold text-red-600 dark:text-red-400">${{ number_format((float) $product->discounted_price, 2) }}</span>
                                <span
                                    class="text-xl text-gray-400 dark:text-gray-500 line-through font-medium">${{ number_format((float) $product->price, 2) }}</span>
                            @else
                                <span
                                    class="text-4xl font-bold text-gray-900 dark:text-white">${{ number_format((float) $product->price, 2) }}</span>
                            @endif
                        </div>

                        <div class="prose prose-red dark:prose-invert text-gray-600 dark:text-gray-300 max-w-none">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide mb-2">
                                Description</h3>
                            <p class="leading-relaxed">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.seller-dashboard>
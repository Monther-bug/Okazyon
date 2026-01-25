<x-layouts.admin-dashboard>
    <x-slot:title>{{ __('products.management') }}</x-slot>
        <x-slot:header>{{ __('products.title') }}</x-slot>

            <div class="space-y-6">

                <!-- Filters -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">

                    <form method="GET" class="flex-1 flex flex-col sm:flex-row gap-4">
                        <!-- Search -->
                        <div class="relative flex-1 max-w-lg">
                            <div class="absolute inset-y-0 start-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 rtl:pr-10 rtl:pl-3 pr-3 py-2 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out"
                                placeholder="{{ __('products.search_placeholder') }}">
                        </div>

                        <!-- Status Filter -->
                        <select name="status" onchange="this.form.submit()"
                            class="block w-40 pl-3 pr-10 py-2 text-base border-slate-300 dark:border-slate-600 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white">
                            <option value="">{{ __('products.all_status') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                {{ __('products.status_pending') }}
                            </option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                {{ __('products.status_approved') }}
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                {{ __('products.status_rejected') }}
                            </option>
                        </select>
                    </form>
                </div>

                <!-- Products Table -->
                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-700/50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('products.product') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('products.seller') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('products.category') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('products.price') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('products.status') }}
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">{{ __('products.actions') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                @forelse($products as $product)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($product->image_url)
                                                        <img class="h-10 w-10 rounded-lg object-cover border border-slate-200 dark:border-slate-600"
                                                            src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                                    @elseif($product->images->count() > 0)
                                                        <img class="h-10 w-10 rounded-lg object-cover border border-slate-200 dark:border-slate-600"
                                                            src="{{ $product->images->first()->display_url }}"
                                                            alt="{{ $product->name }}">
                                                    @else
                                                        <div
                                                            class="h-10 w-10 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-400 font-bold">
                                                            P
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-medium text-slate-900 dark:text-white max-w-[200px] truncate"
                                                        title="{{ $product->name }}">
                                                        {{ $product->name }}
                                                    </div>
                                                    @if($product->is_featured)
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                                            {{ __('products.featured') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-900 dark:text-white">
                                                {{ $product->user->name ?? __('products.unknown') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">
                                                {{ $product->category->name ?? __('products.unknown') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            @if($product->discounted_price && $product->discounted_price < $product->price)
                                                <div class="flex flex-col items-center">
                                                    <span class="text-slate-400 line-through text-xs">
                                                        ${{ number_format($product->price, 2) }}
                                                    </span>
                                                    <span class="text-red-600 font-bold">
                                                        ${{ number_format($product->discounted_price, 2) }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-slate-900 dark:text-white font-medium">
                                                    ${{ number_format($product->price, 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($product->status === 'approved')
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 rounded-full border border-emerald-200 dark:border-emerald-500/20">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    {{ __('products.status_approved') }}
                                                </span>
                                            @elseif($product->status === 'rejected')
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 rounded-full border border-red-200 dark:border-red-500/20">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                    {{ __('products.status_rejected') }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 rounded-full border border-amber-200 dark:border-amber-500/20">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                    {{ __('products.status_pending') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('admin.products.edit', $product) }}"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">{{ __('products.review') }}</a>
                                                <button type="button" @click="$dispatch('open-delete-modal', { 
                                                                            action: '{{ route('admin.products.destroy', $product) }}', 
                                                                            title: '{{ __('products.delete_confirm_title') }}', 
                                                                            message: '{{ __('products.delete_confirm_message_named', ['name' => $product->name]) }}' 
                                                                        })"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    {{ __('products.delete') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="h-12 w-12 text-slate-300 dark:text-slate-600 mb-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                <p class="text-base font-medium">{{ __('products.no_products_found') }}</p>
                                                <p class="text-sm mt-1">{{ __('products.adjust_filters') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div
                            class="bg-white dark:bg-slate-800 px-4 py-3 border-t border-slate-200 dark:border-slate-700 sm:px-6">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
</x-layouts.admin-dashboard>
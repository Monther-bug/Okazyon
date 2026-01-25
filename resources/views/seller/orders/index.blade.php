<x-layouts.seller-dashboard>
    <x-slot:title>{{ __('orders.title') }}</x-slot>
        <x-slot:header>{{ __('orders.title') }}</x-slot>

            <div class="min-h-[500px]">

                <!-- Header & Search Bar -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 mb-8 animate-fade-in-up">
                    <form method="GET" action="{{ route('seller.orders.index') }}"
                        class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- Search Input -->
                        <div class="flex-1 w-full">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="{{ __('orders.search_placeholder') }}"
                                    class="block w-full pl-11 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all shadow-sm">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3 shrink-0">
                            <button type="submit"
                                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                {{ __('products.search') }}
                            </button>

                            <a href="{{ route('seller.orders.export') }}"
                                class="px-6 py-3 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md flex items-center gap-2"
                                style="background-color: #16a34a;">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('products.export') }}
                            </a>

                            @if(request('search'))
                                <a href="{{ route('seller.orders.index') }}"
                                    class="p-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl transition-all border border-gray-200 dark:border-gray-700"
                                    title="Clear search">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                @if($orders->isEmpty())
                    <!-- Empty State -->
                    <div
                        class="flex flex-col items-center justify-center min-h-[400px] text-center p-12 bg-gray-50/50 dark:bg-gray-800/50 rounded-3xl animate-fade-in-up">
                        <div
                            class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('orders.no_orders') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto text-center">
                            {{ __('dashboard.waiting_for_orders') }}</p>
                    </div>
                @else
                    <!-- Data Table -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="bg-gray-50/50 dark:bg-gray-800/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-6 py-4">{{ __('orders.id') }}</th>
                                        <th class="px-6 py-4">{{ __('orders.customer') }}</th>
                                        <th class="px-6 py-4">{{ __('orders.total') }}</th>
                                        <th class="px-6 py-4">{{ __('orders.status') }}</th>
                                        <th class="px-6 py-4">{{ __('orders.date') }}</th>
                                        <th class="px-6 py-4 text-right">{{ __('orders.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach($orders as $order)
                                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer"
                                            onclick="window.location='{{ route('seller.orders.show', $order) }}'">
                                            <td class="px-6 py-4">
                                                <span class="font-bold text-gray-900 dark:text-white">#{{ $order->id }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span
                                                        class="font-medium text-gray-900 dark:text-white text-sm">{{ $order->buyer->name ?? __('orders.unknown_user') }}</span>
                                                    <span class="text-xs text-gray-500">{{ $order->buyer->email ?? '' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="font-bold text-gray-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $statusClass = match ($order->status) {
                                                        'delivered' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                                        'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                                        'processing' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                                        default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400', // Pending
                                                    };
                                                    $statusLabel = __('orders.status_' . $order->status);
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $statusClass }}">
                                                    @if($order->status === 'pending')
                                                        <span
                                                            class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5 animate-pulse"></span>
                                                    @elseif($order->status === 'delivered')
                                                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @endif
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $order->created_at->format('M d, Y') }}
                                                <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('seller.orders.show', $order) }}"
                                                    class="inline-flex items-center justify-center p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors group-hover:opacity-100 opacity-0 group-hover:translate-x-0 translate-x-2 transition-all duration-200">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            </div>
</x-layouts.seller-dashboard>
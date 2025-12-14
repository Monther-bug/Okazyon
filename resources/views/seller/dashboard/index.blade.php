<x-layouts.seller-dashboard>
    <x-slot:title>Overview</x-slot>
        <x-slot:header>Dashboard</x-slot>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Revenue Card -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-red-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 dark:bg-red-900/10 rounded-xl text-red-600 dark:text-red-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span
                            class="flex items-center text-xs font-semibold text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg">
                            +12.5%
                            <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                        </span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">$24,500</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Revenue</p>
                </div>

                <!-- Orders Card -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/10 rounded-xl text-blue-600 dark:text-blue-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span
                            class="flex items-center text-xs font-semibold text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg">
                            +4.2%
                            <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                        </span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">582</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Orders</p>
                </div>

                <!-- Products Card -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="p-3 bg-purple-50 dark:bg-purple-900/10 rounded-xl text-purple-600 dark:text-purple-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span
                            class="flex items-center text-xs font-semibold text-gray-400 bg-gray-50 dark:bg-gray-800 px-2 py-1 rounded-lg">
                            0.0%
                        </span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">124</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Active Products</p>
                </div>

                <!-- Rating Card -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-50 dark:bg-amber-900/10 rounded-xl text-amber-600 dark:text-amber-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <span
                            class="flex items-center text-xs font-semibold text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg">
                            Top Rated
                        </span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">4.8</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Average Rating</p>
                </div>
            </div>

            <!-- Charts & Tables Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Bar Chart Section -->
                <div
                    class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Monthly Revenue</h3>
                        <select
                            class="text-sm border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 focus:ring-red-500 focus:border-red-500">
                            <option>Last 6 Months</option>
                            <option>This Year</option>
                        </select>
                    </div>

                    <!-- CSS Only Bar Chart -->
                    <div class="h-64 flex items-end justify-between gap-2 sm:gap-4 px-2">
                        @foreach([65, 45, 75, 55, 85, 95] as $index => $height)
                            <div class="flex flex-col items-center gap-2 group w-full">
                                <div
                                    class="relative w-full bg-gray-100 dark:bg-gray-800 rounded-xl h-full flex items-end overflow-hidden">
                                    <div class="w-full bg-red-500 dark:bg-red-600 rounded-t-xl transition-all duration-500 hover:bg-red-600 dark:hover:bg-red-500 relative group-hover:scale-y-110 origin-bottom"
                                        style="height: {{ $height }}%">
                                        <div
                                            class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-xs font-bold py-1 px-2 rounded pointer-events-none transition-opacity">
                                            ${{ $height }}k
                                        </div>
                                    </div>
                                </div>
                                <span
                                    class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'][$index] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Orders -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Orders</h3>
                        <a href="{{ route('seller.orders.index') }}"
                            class="text-sm font-semibold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">View
                            All</a>
                    </div>

                    <div class="flex-1 overflow-y-auto p-4 space-y-4 max-h-[400px]">
                        @forelse($recent_orders ?? [] as $order)
                                            <div
                                                class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer group">
                                                <div
                                                    class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xl font-bold text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                                    {{ substr($order->customer_name ?? 'C', 0, 1) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                                        {{ $order->customer_name ?? 'Customer' }}</h4>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $order->created_at->diffForHumans() }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                                        ${{ number_format($order->total_amount, 2) }}</p>
                                                    <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full
                                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' :
                            ($order->status === 'cancelled' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' :
                                'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400') }}">
                                                        {{ $order->status }}
                                                    </span>
                                                </div>
                                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center h-48 text-center">
                                <div
                                    class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No recent orders found</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
</x-layouts.seller-dashboard>
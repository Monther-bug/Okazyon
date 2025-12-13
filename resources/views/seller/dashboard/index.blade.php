<x-layouts.seller-dashboard>
    <x-slot:heading>Overview</x-slot:heading>
    <x-slot:subheading>Welcome back! Here's what's happening with your store today.</x-slot:subheading>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-10">
        <!-- Card 1: Total Sales -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:shadow-none dark:border dark:border-gray-700 hover:-translate-y-1 transition-transform duration-300 border border-gray-100 flex flex-col justify-between h-40 group relative overflow-hidden">
            <!-- Background Decoration -->
            <div
                class="absolute -right-6 -top-6 w-24 h-24 bg-red-50 dark:bg-red-900/10 rounded-full group-hover:scale-125 transition-transform duration-500">
            </div>

            <div class="relative flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Sales</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 tracking-tight">$0.00</h3>
                </div>
                <div class="p-3 bg-red-100/50 dark:bg-red-900/30 rounded-xl text-red-600 dark:text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="relative mt-auto flex items-center text-sm">
                <span class="text-green-500 font-semibold flex items-center mr-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    0%
                </span>
                <span class="text-gray-400 dark:text-gray-500">vs last month</span>
            </div>
        </div>

        <!-- Card 2: Orders -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:shadow-none dark:border dark:border-gray-700 hover:-translate-y-1 transition-transform duration-300 border border-gray-100 flex flex-col justify-between h-40 group relative overflow-hidden">
            <div
                class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 dark:bg-blue-900/10 rounded-full group-hover:scale-125 transition-transform duration-500">
            </div>

            <div class="relative flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 tracking-tight">0</h3>
                </div>
                <div class="p-3 bg-blue-100/50 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="relative mt-auto flex items-center text-sm">
                <span class="text-gray-400 dark:text-gray-500">No recent orders</span>
            </div>
        </div>

        <!-- Card 3: Customers -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:shadow-none dark:border dark:border-gray-700 hover:-translate-y-1 transition-transform duration-300 border border-gray-100 flex flex-col justify-between h-40 group relative overflow-hidden">
            <div
                class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 dark:bg-green-900/10 rounded-full group-hover:scale-125 transition-transform duration-500">
            </div>

            <div class="relative flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Customers</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 tracking-tight">0</h3>
                </div>
                <div class="p-3 bg-green-100/50 dark:bg-green-900/30 rounded-xl text-green-600 dark:text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="relative mt-auto flex items-center text-sm">
                <a href="#" class="text-green-600 dark:text-green-400 font-medium hover:underline">View customer list
                    &rarr;</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Chart Section (Placeholder) -->
        <div
            class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 min-h-[400px] flex flex-col transition-colors duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Revenue Analytics</h3>
                <select
                    class="text-sm border-gray-200 dark:border-gray-600 rounded-lg text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-700 focus:ring-red-500 focus:border-red-500">
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>This Year</option>
                </select>
            </div>

            <div
                class="flex-1 flex items-center justify-center bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 relative overflow-hidden group">
                <div class="text-center z-10 relative">
                    <div
                        class="w-16 h-16 bg-white dark:bg-gray-800 rounded-full shadow-md flex items-center justify-center mx-auto mb-4 text-gray-400 dark:text-gray-500 group-hover:scale-110 transition-transform duration-300 group-hover:text-red-500 dark:group-hover:text-red-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-gray-900 dark:text-white font-medium">No Data Available</h4>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 max-w-xs mx-auto">Sales analytics will
                        appear here once you start processing orders.</p>
                </div>

                <!-- Decorative Grid Lines -->
                <div class="absolute inset-0"
                    style="background-image: radial-gradient(#e5e7eb 1px, transparent 1px); background-size: 20px 20px; opacity: 0.5;">
                </div>
                <div class="absolute inset-0 dark:block hidden"
                    style="background-image: radial-gradient(#374151 1px, transparent 1px); background-size: 20px 20px; opacity: 0.5;">
                </div>
            </div>
        </div>

        <!-- Recent Activity Column -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Recent Activity</h3>

            <div class="space-y-6">
                <!-- Empty State -->
                <div class="text-center py-10">
                    <div
                        class="w-12 h-12 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400 dark:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">No activity yet.</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="#"
                    class="block w-full py-2 px-4 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 text-sm font-semibold rounded-lg text-center transition-colors">
                    View All Activity
                </a>
            </div>
        </div>
    </div>
</x-layouts.seller-dashboard>
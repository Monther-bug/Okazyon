<x-layouts.admin-dashboard>
    <x-slot:title>Orders Management</x-slot>
        <x-slot:header>Orders</x-slot>

            <div class="space-y-6">

                <!-- Filters -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">

                    <form method="GET" class="flex-1 flex flex-col sm:flex-row gap-4">
                        <!-- Search -->
                        <div class="relative flex-1 max-w-lg">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-3 py-2 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out"
                                placeholder="Search by Order ID or Customer Name...">
                        </div>

                        <!-- Status Filter -->
                        <select name="status" onchange="this.form.submit()"
                            class="block w-40 pl-3 pr-10 py-2 text-base border-slate-300 dark:border-slate-600 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                Processing</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped
                            </option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </form>
                </div>

                <!-- Orders Table -->
                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-700/50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Order ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                #{{ $order->id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-8 w-8 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-red-700 dark:text-red-300 font-bold text-xs">
                                                    {{ substr($order->buyer?->name ?? 'G', 0, 1) }}
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                        {{ $order->buyer?->name ?? 'Guest User' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                                            {{ $order->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-white">
                                            ${{ number_format((float) $order->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-500/10 dark:text-amber-400 border-amber-200 dark:border-amber-500/20',
                                                    'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/10 dark:text-blue-400 border-blue-200 dark:border-blue-500/20',
                                                    'shipped' => 'bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-400 border-red-200 dark:border-red-500/20',
                                                    'delivered' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20',
                                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-400 border-red-200 dark:border-red-500/20',
                                                ];
                                                $currentClass = $statusClasses[$order->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300';
                                            @endphp
                                            <span
                                                class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full border {{ $currentClass }} capitalize">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">View
                                                Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="h-12 w-12 text-slate-300 dark:text-slate-600 mb-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                                <p class="text-base font-medium">No orders found</p>
                                                <p class="text-sm mt-1">Try adjusting your filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div
                            class="bg-white dark:bg-slate-800 px-4 py-3 border-t border-slate-200 dark:border-slate-700 sm:px-6">
                            {{ $orders->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
</x-layouts.admin-dashboard>
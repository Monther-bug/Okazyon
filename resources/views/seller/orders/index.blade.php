<x-layouts.seller-dashboard>
    <div x-data="{ search: '' }" class="min-h-screen">

        <!-- Main Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Orders</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage and track your customer orders.</p>
            </div>
        </div>

        <!-- Content Area -->
        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center min-h-[60vh] text-center p-8">
                <div
                    class="w-24 h-24 bg-gradient-to-tr from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-3xl flex items-center justify-center mb-6 shadow-xl shadow-gray-200/50 dark:shadow-black/50 ring-1 ring-gray-100 dark:ring-gray-800">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No orders yet</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-sm mb-8 leading-relaxed">
                    You haven't received any orders for your products yet. Check back later!
                </p>
            </div>
        @else
            <!-- Order List -->
            <div
                class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-100/50 dark:shadow-black/20 overflow-hidden">
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50/50 dark:bg-gray-800/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold border-b border-gray-100 dark:border-gray-800">
                                <th class="px-8 py-5">Order ID</th>
                                <th class="px-6 py-5">Customer</th>
                                <th class="px-6 py-5">Total</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5">Date</th>
                                <th class="px-6 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($orders as $order)
                                <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors duration-200">
                                    <td class="px-8 py-5">
                                        <span class="font-bold text-gray-900 dark:text-white">#{{ $order->id }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 font-bold text-xs">
                                                {{ substr($order->buyer->name ?? 'U', 0, 1) }}
                                            </div>
                                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $order->buyer->name ?? 'Unknown User' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="font-bold text-gray-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/30',
                                                'processing' => 'bg-blue-50 text-blue-700 border-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800/30',
                                                'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/30',
                                                'cancelled' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/30',
                                            ];
                                            $statusColor = $statusColors[$order->status] ?? $statusColors['pending'];
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColor }}">
                                            @if($order->status == 'pending')
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                                </span>
                                            @elseif($order->status == 'processing')
                                                 <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            @elseif($order->status == 'delivered')
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @elseif($order->status == 'cancelled')
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            @endif
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('seller.orders.show', $order) }}"
                                                class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-colors group-hover:text-blue-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>
</x-layouts.seller-dashboard>

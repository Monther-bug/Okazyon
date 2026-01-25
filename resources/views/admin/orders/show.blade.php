<x-layouts.admin-dashboard>
    <x-slot:title>{{ __('orders.order_number') }}{{ $order->id }}</x-slot>
        <x-slot:header>{{ __('orders.order_details') }}</x-slot>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: Order Items & Status -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Order Items -->
                    <div
                        class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('orders.order_items') }}
                            </h3>
                            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $order->items->count() }}
                                {{ __('categories.items') }}</span>
                        </div>
                        <ul role="list" class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($order->items as $item)
                                <li class="p-6 flex items-center gap-4">
                                    <div
                                        class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700">
                                        @if($item->product->images && is_array($item->product->images) && count($item->product->images) > 0)
                                            <img src="{{ asset('storage/' . $item->product->images[0]) }}"
                                                alt="{{ $item->product->name }}"
                                                class="h-full w-full object-cover object-center">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-slate-400">
                                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-slate-900 dark:text-white truncate">
                                            {{ $item->product->name }}
                                        </h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                                            {{ __('orders.qty') }}: {{ $item->quantity }} &times;
                                            ${{ number_format((float) $item->price, 2) }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">
                                            ${{ number_format($item->quantity * (float) $item->price, 2) }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div
                            class="bg-slate-50 dark:bg-slate-700/50 p-6 flex justify-between items-center border-t border-slate-200 dark:border-slate-700">
                            <span
                                class="text-base font-medium text-slate-900 dark:text-white">{{ __('orders.total_amount') }}</span>
                            <span
                                class="text-xl font-bold text-red-600 dark:text-red-400">${{ number_format((float) $order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <!-- Status Update -->
                    <div
                        class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                            {{ __('orders.update_status') }}</h3>
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST"
                            class="flex flex-col sm:flex-row gap-4 items-end">
                            @csrf
                            @method('PUT')
                            <div class="w-full sm:w-auto flex-1">
                                <label for="status"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('orders.status') }}</label>
                                <select name="status" id="status"
                                    class="block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                        {{ __('orders.status_pending') }}
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                        {{ __('orders.status_processing') }}
                                    </option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                        {{ __('orders.status_shipped') }}
                                    </option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                        {{ __('orders.status_delivered') }}
                                    </option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        {{ __('orders.status_cancelled') }}
                                    </option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                {{ __('orders.update_status') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Customer & Info -->
                <div class="space-y-6">

                    <!-- Customer Info -->
                    <div
                        class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                            {{ __('orders.customer_info') }}</h3>
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="h-12 w-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-300 font-bold text-lg">
                                {{ substr($order->buyer?->name ?? 'G', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-base font-medium text-slate-900 dark:text-white">
                                    {{ $order->buyer?->name ?? __('orders.guest_user') }}
                                </p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    {{ $order->buyer?->email ?? __('orders.no_email') }}
                                </p>
                            </div>
                        </div>
                        @if($order->buyer?->phone)
                            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mt-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $order->buyer->phone }}
                            </div>
                        @endif
                    </div>

                    <!-- Delivery Address -->
                    <div
                        class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                            {{ __('orders.delivery_address') }}</h3>
                        <div class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            @if($order->delivery_address)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->delivery_address) }}"
                                    target="_blank"
                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 underline">
                                    {{ $order->delivery_address }}
                                </a>
                            @else
                                <span class="italic text-slate-400">{{ __('orders.no_address') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Order Metadata -->
                    <div
                        class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">{{ __('orders.metadata') }}
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">{{ __('orders.placed_on') }}</span>
                                <span
                                    class="font-medium text-slate-900 dark:text-white">{{ $order->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">{{ __('orders.last_updated') }}</span>
                                <span
                                    class="font-medium text-slate-900 dark:text-white">{{ $order->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</x-layouts.admin-dashboard>
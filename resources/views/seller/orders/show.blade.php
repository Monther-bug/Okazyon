<x-layouts.seller-dashboard>
    <x-slot:heading>Order #{{ $order->id }}</x-slot:heading>
    <x-slot:subheading>Manage order status and view details.</x-slot:subheading>

    <div class="space-y-8">

        <!-- Top Actions / Status -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <a href="{{ route('seller.orders.index') }}"
                class="flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Orders
            </a>

            <form action="{{ route('seller.orders.update', $order) }}" method="POST" class="flex items-center gap-3">
                @csrf
                @method('PUT')
                <div class="relative">
                    <select name="status" onchange="this.form.submit()"
                        class="appearance-none pl-4 pr-10 py-2.5 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm font-bold shadow-sm focus:border-red-500 focus:ring-red-500">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                        </option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-100/50 dark:shadow-black/20 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Order Items</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Products in this order from your store.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach($sellerItems as $item)
                                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="h-16 w-16 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shrink-0">
                                                    @if($item->product->images->count() > 0)
                                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item->product->images->first()->image_url) }}"
                                                            class="h-full w-full object-cover">
                                                    @else
                                                        <div
                                                            class="h-full w-full flex items-center justify-center text-gray-400">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900 dark:text-white">
                                                        {{ $item->product->name }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">${{ number_format($item->price, 2) }} x
                                                        {{ $item->quantity }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-right font-bold text-gray-900 dark:text-white">
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <td class="px-8 py-4 font-bold text-gray-700 dark:text-gray-300 text-right">Your
                                        Subtotal</td>
                                    <td class="px-8 py-4 font-bold text-xl text-red-600 dark:text-red-400 text-right">
                                        ${{ number_format($sellerItems->sum(fn($i) => $i->price * $i->quantity), 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Customer & Shipping -->
            <div class="space-y-6">
                <!-- Customer Info -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-100/50 dark:shadow-black/20 p-6">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Customer Details</h3>
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 font-bold text-lg">
                            {{ substr($order->buyer->name ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $order->buyer->name ?? 'Unknown' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->buyer->email ?? 'No email' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <div>
                            <p class="text-xs font-bold uppercase text-gray-400 mb-1">Phone Number</p>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $order->buyer->phone_number ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase text-gray-400 mb-1">Delivery Address</p>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $order->delivery_address ?? 'No address provided' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-100/50 dark:shadow-black/20 p-6">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Order Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Order Placed</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div
                            class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                            <span class="text-base font-bold text-gray-900 dark:text-white">Total Amount</span>
                            <span
                                class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format((float) $order->total_amount, 2) }}</span>
                        </div>
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-800 mt-3">
                            <p class="text-xs text-gray-400 text-center">
                                This total represents the entire order value, including items from other sellers.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.seller-dashboard>
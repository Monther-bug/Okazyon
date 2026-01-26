<x-layouts.seller-dashboard>
    <x-slot:title>{{ __('navigation.overview') }}</x-slot>
        <x-slot:header>{{ __('dashboard.dashboard') }}</x-slot>

            <div class="space-y-6 font-sans antialiased">

                <!-- Welcome Section -->
                <div class="relative overflow-hidden p-8 animate-fade-in-up"
                    style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.2); border-radius: 24px;">

                    <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full opacity-10"
                        style="background: white; filter: blur(60px);"></div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="max-w-2xl">
                            <h1 class="text-3xl md:text-4xl font-bold mb-2" style="color: white; line-height: 1.2;">
                                {{ __('dashboard.welcome_back', ['name' => auth()->user()->name]) }}
                            </h1>
                            <p class="text-base opacity-90" style="color: rgba(255, 255, 255, 0.9);">
                                {{ __('dashboard.check_performance') }} <span
                                    class="font-semibold">{{ date('F Y') }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-2.5 rounded-full px-5 py-2.5"
                            style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                            <div class="h-2 w-2 rounded-full relative" style="background: #10b981;">
                                <div class="absolute inset-0 rounded-full animate-ping"
                                    style="background: #10b981; opacity: 0.75;"></div>
                            </div>
                            <span class="text-sm font-semibold whitespace-nowrap" style="color: white;">{{ __('dashboard.all_systems_operational') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                    <!-- Revenue Card -->
                    <div class="group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 animate-fade-in-up bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                        style="box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.1s; animation-fill-mode: backwards;">

                        <div class="flex items-start justify-between mb-5">
                            <div class="rounded-xl p-3"
                                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <!-- Iconax: Money Receive -->
                                <i class="iconsax text-2xl" icon-name="wallet-money" style="color: white;"></i>
                            </div>
                            <!-- Trends can be calculated later -->
                        </div>

                        <div>
                            <p class="text-sm font-medium mb-1 text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.total_revenue') }}</p>
                            <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                                ${{ number_format($totalRevenue, 2) }}</p>
                        </div>
                    </div>

                    <!-- Orders Card -->
                    <div class="group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 animate-fade-in-up bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                        style="box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.2s; animation-fill-mode: backwards;">

                        <div class="flex items-start justify-between mb-5">
                            <div class="rounded-xl p-3"
                                style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <!-- Iconax: Shopping Bag -->
                                <i class="iconsax text-2xl" icon-name="receipt-list" style="color: white;"></i>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium mb-1 text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.total_orders') }}</p>
                            <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $totalOrders }}
                            </p>
                        </div>
                    </div>

                    <!-- Products Card -->
                    <div class="group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 animate-fade-in-up bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                        style="box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.3s; animation-fill-mode: backwards;">

                        <div class="flex items-start justify-between mb-5">
                            <div class="rounded-xl p-3"
                                style="background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);">
                                <!-- Iconax: 3D Box -->
                                <i class="iconsax text-2xl" type="bulk" icon-name="box" style="color: white;"></i>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium mb-1 text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.active_products') }}</p>
                            <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $totalProducts }}
                            </p>
                        </div>
                    </div>

                    <!-- Pending Orders Card (Replaced Rating) -->
                    <div class="group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 animate-fade-in-up bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                        style="box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.4s; animation-fill-mode: backwards;">

                        <div class="flex items-start justify-between mb-5">
                            <div class="rounded-xl p-3"
                                style="background: linear-gradient(135deg, #fad0c4 0%, #ffd1ff 100%);">
                                <!-- Iconax: Clock -->
                                <i class="iconsax text-2xl" type="bulk" icon-name="clock"></i>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium mb-1 text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.pending_orders') }}</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $pendingOrders }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Revenue Chart -->
                    <div class="lg:col-span-2 rounded-2xl p-6 animate-fade-in-up bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                        style="box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.5s; animation-fill-mode: backwards;">

                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold mb-1 text-gray-900 dark:text-white">
                                    {{ __('dashboard.revenue_analytics') }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('dashboard.monthly_performance') }}
                                </p>
                            </div>
                        </div>

                        <!-- Bar Chart -->
                        <div class="flex h-64 items-end gap-2 sm:gap-4">
                            @php
                                $maxEarning = max($monthlyEarnings) ?: 1;
                            @endphp
                            @foreach($monthlyEarnings as $index => $earning)
                                @php
                                    $heightPercentage = ($earning / $maxEarning) * 100;
                                    // Ensure simple animation or at least proper height usage
                                @endphp
                                <div class="group relative flex-1 h-full flex flex-col justify-end gap-2">
                                    <!-- Tooltip -->
                                    <div
                                        class="absolute -top-10 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10">
                                        <div class="rounded-lg px-2.5 py-1.5 text-xs font-bold shadow-lg whitespace-nowrap"
                                            style="background: #111827; color: white;">
                                            ${{ number_format($earning, 2) }}
                                        </div>
                                    </div>
                                    <!-- Bar -->
                                    <div class="relative h-full rounded-t-lg overflow-hidden bg-gray-100 dark:bg-gray-800">
                                        <div class="absolute bottom-0 w-full rounded-t-lg transition-all duration-500 group-hover:opacity-80"
                                            style="height: {{ $heightPercentage }}%; background: linear-gradient(to top, #ef4444, #f87171);">
                                        </div>
                                    </div>
                                    <span class="text-xs font-medium text-center" style="color: #9ca3af;">
                                        {{ $months[$index] ?? '' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="rounded-2xl p-6 animate-fade-in-up bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                        style="box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.6s; animation-fill-mode: backwards;">

                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ __('dashboard.recent_orders') }}</h3>
                            <a href="{{ route('seller.orders.index') }}"
                                class="text-sm font-semibold transition-colors hover:underline text-red-600 dark:text-red-400">
                                {{ __('dashboard.view_all') }} →
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($recentOrders ?? [] as $order)
                                                    <div class="flex items-center gap-3 p-3.5 rounded-xl transition-all hover:scale-[1.02] bg-gray-50 dark:bg-gray-800/50 border border-transparent hover:border-gray-200 dark:hover:border-gray-700 hover:bg-white dark:hover:bg-gray-800"
                                                        onclick="window.location='{{ route('seller.orders.show', $order) }}'"
                                                        style="cursor: pointer;">

                                                        <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-600 to-red-500 flex items-center justify-center text-white shadow-lg shadow-red-500/20 text-2xl">
                                    <i class="iconsax" type="bulk" icon-name="shop"></i>
                                </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-slate-900 dark:text-white truncate">
                                                                {{ $order->buyer->name ?? __('orders.unknown_user') }}
                                                            </p>
                                                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                                                {{ __('orders.order_number') }}{{ $order->id ?? 'N/A' }} &bull;
                                                                {{ $order->created_at?->diffForHumans() ?? __('orders.just_now') }}
                                                            </p>
                                                        </div>

                                                        <div class="text-right">
                                                            <p class="text-sm font-bold mb-1 text-gray-900 dark:text-white">
                                                                ${{ number_format($order->total_amount, 2) }}
                                                            </p>
                                                            <span class="inline-block rounded-md px-2 py-0.5 text-[10px] font-bold uppercase"
                                                                style="{{ $order->status === 'delivered' ? 'background: #d1fae5; color: #065f46;' :
                                ($order->status === 'cancelled' ? 'background: #fee2e2; color: #991b1b;' :
                                    'background: #fef3c7; color: #92400e;') }}">
                                                                {{ $order->status }}
                                                            </span>
                                                        </div>
                                                    </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-12 text-center">
                                    <div class="rounded-full p-4 mb-3 bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium mb-1 text-gray-500 dark:text-gray-400">
                                        {{ __('dashboard.no_orders_yet') }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ __('dashboard.waiting_for_orders') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <style>
                @keyframes grow-bar {
                    from {
                        height: 0%;
                    }

                    to {
                        height:
                            {{ $height ?? 0 }}
                            %;
                    }
                }
            </style>
</x-layouts.seller-dashboard>
<x-layouts.admin-dashboard>
    <x-slot:title>Overview</x-slot>
        <x-slot:header>{{ __('dashboard.dashboard') }}</x-slot>

            <div class="space-y-6 font-sans antialiased">

                <!-- Top Header & Date -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                            {{ __('admin.welcome_message', ['name' => auth()->user()->name]) }}
                        </h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ __('admin.welcome_subtitle') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            {{ __('admin.live_updates') }}
                        </span>
                        <div
                            class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-600 dark:text-slate-300 font-medium">
                            {{ now()->translatedFormat('M d, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Modern Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Revenue -->
                    <div
                        class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-2 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            {{ __('admin.total_revenue') }}</h3>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                            ${{ number_format($totalRevenue, 2) }}
                        </p>
                    </div>

                    <!-- Orders -->
                    <div
                        class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-2 rounded-lg bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            {{ __('admin.total_orders') }}</h3>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                            {{ number_format($totalOrders) }}
                        </p>
                    </div>

                    <!-- Users -->
                    <div
                        class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-2 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('admin.total_users') }}
                        </h3>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                            {{ number_format($totalUsers) }}
                        </p>
                    </div>

                    <!-- Products -->
                    <div
                        class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            {{ __('admin.total_products') }}</h3>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                            {{ number_format($totalProducts) }}
                        </p>
                    </div>
                </div>

                <!-- Main Content Split -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Revenue Chart (Line Chart for Modern Look) -->
                    <div
                        class="lg:col-span-2 p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                                    {{ __('admin.revenue_overview') }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('admin.revenue_subtitle') }}
                                </p>
                            </div>
                        </div>

                        <div class="h-80 w-full">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <!-- Recent Activity / Orders -->
                    <div
                        class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                            {{ __('admin.recent_orders') }}</h3>

                        <div class="flow-root">
                            <ul role="list" class="-my-5 divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($recentOrders ?? [] as $order)
                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-300 font-bold text-xs">
                                                    {{ substr($order->buyer?->name ?? 'G', 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate">
                                                    {{ $order->buyer?->name ?? __('admin.guest_user') }}
                                                </p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                                    {{ __('admin.order_number', ['id' => $order->id]) }} &bull;
                                                    {{ $order->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex flex-col items-end text-sm font-semibold text-slate-900 dark:text-white">
                                                ${{ number_format($order->total_amount, 2) }}
                                                <span
                                                    class="text-[10px] font-normal {{ $order->status === 'delivered' ? 'text-emerald-500' : 'text-amber-500' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-4 text-center text-sm text-slate-500">{{ __('admin.no_recent_orders') }}
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="mt-6">
                            <a href="#"
                                class="block w-full py-2 px-4 border border-slate-300 dark:border-slate-600 rounded-lg text-center text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                                {{ __('admin.view_all_orders') }}
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Chart Configuration -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('revenueChart').getContext('2d');

                    // Generate gradient
                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(229, 57, 53, 0.2)'); // Red
                    gradient.addColorStop(1, 'rgba(229, 57, 53, 0)');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($months) !!},
                            datasets: [{
                                label: 'Revenue',
                                data: {!! json_encode($monthlyEarnings) !!},
                                borderColor: '#E53935',
                                backgroundColor: gradient,
                                borderWidth: 2,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#E53935',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#1e293b',
                                    padding: 12,
                                    titleFont: { size: 13 },
                                    bodyFont: { size: 12 },
                                    cornerRadius: 8,
                                    displayColors: false,
                                    callbacks: {
                                        label: function (context) {
                                            return '$ ' + context.parsed.y.toLocaleString();
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(148, 163, 184, 0.1)',
                                        borderDash: [4, 4]
                                    },
                                    ticks: {
                                        callback: function (value) {
                                            return '$' + value;
                                        },
                                        color: '#64748b'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#64748b'
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
</x-layouts.admin-dashboard>
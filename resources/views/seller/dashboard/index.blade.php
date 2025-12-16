<x-layouts.seller-dashboard>
    <x-slot:title>Overview</x-slot>
        <x-slot:header>{{ __('Dashboard') }}</x-slot>

            <div class="space-y-6 font-sans antialiased">

                <!-- Welcome Section -->
                <div class="relative overflow-hidden p-8 animate-fade-in-up"
                    style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.2); border-radius: 24px;">

                    <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full opacity-10"
                        style="background: white; filter: blur(60px);"></div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="max-w-2xl">
                            <h1 class="text-3xl md:text-4xl font-bold mb-2" style="color: white; line-height: 1.2;">
                                Welcome back, {{ auth()->user()->name }}! 👋
                            </h1>
                            <p class="text-base opacity-90" style="color: rgba(255, 255, 255, 0.9);">
                                Here's what's happening with your store in <span
                                    class="font-semibold">{{ date('F Y') }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-2.5 rounded-full px-5 py-2.5"
                            style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                            <div class="h-2 w-2 rounded-full relative" style="background: #10b981;">
                                <div class="absolute inset-0 rounded-full animate-ping"
                                    style="background: #10b981; opacity: 0.75;"></div>
                            </div>
                            <span class="text-sm font-semibold whitespace-nowrap" style="color: white;">All Systems
                                Operational</span>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                    <!-- Revenue Card -->
                    <div class="group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 animate-fade-in-up"
                        style="background: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.1s; animation-fill-mode: backwards;">

                        <div class="flex items-start justify-between mb-5">
                            <div class="rounded-xl p-3"
                                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <svg class="h-6 w-6" style="color: white;" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <!-- Trends can be calculated later -->
                        </div>

                        <div>
                            <p class="text-sm font-medium mb-1" style="color: #6b7280;">Total Revenue</p>
                            <p class="text-3xl font-bold tracking-tight" style="color: #111827;">
                                ${{ number_format($totalRevenue, 2) }}</p>
                        </div>
                    </div>

                    <!-- Orders Card -->
                    <div class="group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 animate-fade-in-up"
                        style="background: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.2s; animation-fill-mode: backwards;">

                        <div class="flex items-start justify-between mb-5">
                            <div class="rounded-xl p-3"
                                style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <svg class="h-6 w-6" style="color: white;" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium mb-1" style="color: #6b7280;">Total Orders</p>
                            <p class="text-3xl font-bold tracking-tight" style="color: #111827;">{{ $totalOrders }}</p>
                        </div>
                    </div>

                    <!-- Products Card -->
                    <div class="group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 animate-fade-in-up"
                        style="background: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.3s; animation-fill-mode: backwards;">

                        <div class="flex items-start justify-between mb-5">
                            <div class="rounded-xl p-3"
                                style="background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);">
                                <svg class="h-6 w-6" style="color: white;" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium mb-1" style="color: #6b7280;">Active Products</p>
                            <p class="text-3xl font-bold tracking-tight" style="color: #111827;">{{ $totalProducts }}
                            </p>
                        </div>
                    </div>

                    <!-- Pending Orders Card (Replaced Rating) -->
                    <div class="group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 animate-fade-in-up"
                        style="background: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.4s; animation-fill-mode: backwards;">

                        <div class="flex items-start justify-between mb-5">
                            <div class="rounded-xl p-3"
                                style="background: linear-gradient(135deg, #fad0c4 0%, #ffd1ff 100%);">
                                <svg class="h-6 w-6" style="color: #d946ef;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 001-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium mb-1" style="color: #6b7280;">Pending Orders</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-bold tracking-tight" style="color: #111827;">
                                    {{ $pendingOrders }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Revenue Chart -->
                    <div class="lg:col-span-2 rounded-2xl p-6 animate-fade-in-up"
                        style="background: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.5s; animation-fill-mode: backwards;">

                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold mb-1" style="color: #111827;">Revenue Analytics</h3>
                                <p class="text-sm" style="color: #6b7280;">Monthly performance (Last 6 months)</p>
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
                                    <div class="relative h-full rounded-t-lg overflow-hidden" style="background: #f3f4f6;">
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
                    <div class="rounded-2xl p-6 animate-fade-in-up"
                        style="background: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); animation-delay: 0.6s; animation-fill-mode: backwards;">

                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold" style="color: #111827;">Recent Orders</h3>
                            <a href="{{ route('seller.orders.index') }}"
                                class="text-sm font-semibold transition-colors hover:underline" style="color: #ef4444;">
                                View All →
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($recentOrders ?? [] as $order)
                                                    <div class="flex items-center gap-3 p-3.5 rounded-xl transition-all hover:scale-[1.02]"
                                                        style="background: #f9fafb; border: 1px solid transparent;"
                                                        onmouseover="this.style.borderColor='#e5e7eb'; this.style.background='white';"
                                                        onmouseout="this.style.borderColor='transparent'; this.style.background='#f9fafb';">

                                                        <div
                                                            class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-300 font-bold text-xs">
                                                            {{ substr($order->buyer?->name ?? 'G', 0, 1) }}
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-slate-900 dark:text-white truncate">
                                                                {{ $order->buyer?->name ?? 'Guest User' }}
                                                            </p>
                                                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                                                Order #{{ $order->id }} &bull; {{ $order->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>

                                                        <div class="text-right">
                                                            <p class="text-sm font-bold mb-1" style="color: #111827;">
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
                                    <div class="rounded-full p-4 mb-3" style="background: #f3f4f6;">
                                        <svg class="h-6 w-6" style="color: #9ca3af;" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium mb-1" style="color: #6b7280;">No orders yet</p>
                                    <p class="text-xs" style="color: #9ca3af;">New orders will appear here</p>
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
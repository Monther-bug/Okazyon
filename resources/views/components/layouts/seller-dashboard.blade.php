<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
          darkMode: localStorage.getItem('theme') === 'dark',
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
    x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name') }} Seller</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        .sidebar-gradient {
            background: linear-gradient(180deg, #111827 0%, #000000 100%);
        }

        .nav-item-active {
            background: rgba(229, 62, 62, 0.15);
            color: #FC8181;
            border-left: 3px solid #E53E3E;
        }

        .nav-item-inactive {
            color: #9CA3AF;
            border-left: 3px solid transparent;
        }

        .nav-item-inactive:hover {
            color: #F3F4F6;
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900 overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/80 z-40 lg:hidden backdrop-blur-sm"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-72 sidebar-gradient text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:flex lg:flex-col shadow-2xl">

            <!-- Logo -->
            <div class="flex items-center justify-center h-20 border-b border-gray-800">
                <div class="flex items-center gap-3">
                    <!-- Icon/Logo -->
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-800 rounded-xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-200">
                        <span class="text-white font-bold text-xl">O</span>
                    </div>
                    <div>
                        <span class="text-2xl font-bold tracking-tight text-white">Okazyon</span>
                        <div class="text-[10px] uppercase font-bold text-red-400 tracking-widest leading-none">Seller
                            Center</div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-2">

                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Main</p>

                <a href="{{ route('seller.dashboard') }}"
                    class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('seller.dashboard') ? 'nav-item-active shadow-lg shadow-red-900/20' : 'nav-item-inactive' }}">
                    <svg class="w-6 h-6 mr-3.5 {{ request()->routeIs('seller.dashboard') ? 'text-red-400' : 'text-gray-500 group-hover:text-gray-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>

                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Management</p>

                <!-- Placeholder Links -->
                <a href="#"
                    class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group nav-item-inactive">
                    <svg class="w-6 h-6 mr-3.5 text-gray-500 group-hover:text-gray-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Products
                </a>

                <a href="#"
                    class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group nav-item-inactive">
                    <svg class="w-6 h-6 mr-3.5 text-gray-500 group-hover:text-gray-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    Orders
                </a>
            </div>

            <!-- Bottom User Menu -->
            <div class="border-t border-gray-800 p-4 bg-black/20">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <div
                            class="h-10 w-10 rounded-full bg-gradient-to-r from-gray-700 to-gray-600 flex items-center justify-center text-white font-bold border-2 border-gray-600 shadow-md">
                            {{ substr(auth()->user()->name ?? 'S', 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Seller' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->phone_number ?? '' }}</p>
                    </div>
                    <form method="POST" action="{{ route('seller.logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-gray-400 hover:text-white transition-colors p-2 rounded-full hover:bg-white/10"
                            title="Log Out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1m6 0H9"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50/50">
            <!-- Glass Header -->
            <header class="glass-header h-20 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-20">
                <button @click="sidebarOpen = true"
                    class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                </button>

                <div class="flex-1 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $heading ?? 'Dashboard' }}</h1>
                        @if(isset($subheading))
                            <p class="text-sm text-gray-500 mt-0.5">{{ $subheading }}</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4">
                        <!-- Dark Mode Toggle -->
                        <button @click="toggleTheme()"
                            class="p-2 rounded-full text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 focus:outline-none transition-colors transform hover:scale-110 duration-200">
                            <!-- Sun Icon -->
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            <!-- Moon Icon -->
                            <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                </path>
                            </svg>
                        </button>

                        <!-- Notification Bell -->
                        <button
                            class="p-2 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:text-red-500 hover:border-red-200 focus:outline-none transition-all duration-200 relative shadow-sm group">
                            <span
                                class="absolute top-2 right-2.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-gray-800 animate-pulse"></span>
                            <svg class="h-6 w-6 group-hover:scale-110 transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-10 scroll-smooth">
                {{ $slot }}

                <!-- Footer -->
                <div
                    class="mt-8 border-t border-gray-200 dark:border-gray-800 pt-6 flex justify-between items-center text-xs text-gray-400 dark:text-gray-500">
                    <p>&copy; {{ date('Y') }} Okazyon Inc.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-gray-600">Privacy</a>
                        <a href="#" class="hover:text-gray-600">Terms</a>
                        <a href="#" class="hover:text-gray-600">Help</a>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>

</html>
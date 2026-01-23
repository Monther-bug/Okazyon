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

    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name') }} Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .dark .glass-panel {
            background: rgba(17, 24, 39, 0.7);
            border-bottom: 1px solid rgba(55, 65, 81, 0.5);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body
    class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-slate-800 dark:text-gray-100 overflow-hidden selection:bg-red-500 selection:text-white"
    x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-40 lg:hidden" x-cloak></div>

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar (Dark Theme) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-900 text-slate-900 dark:text-gray-100 border-r border-slate-200 dark:border-slate-800 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:flex lg:flex-col shadow-2xl lg:shadow-none">

            <!-- Logo Area -->
            <div class="h-20 flex items-center px-8 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-red-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Okazyon</h1>
                        <p class="text-[10px] uppercase font-bold tracking-widest text-red-500">Administration</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">

                <div class="px-4 mb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Overview</p>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.dashboard') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white hover:translate-x-1' }}">
                    <svg class="w-5 h-5 transition-colors duration-300 {{ request()->routeIs('admin.dashboard') ? 'text-red-600' : 'text-slate-500 group-hover:text-white' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>

                <div class="px-4 mt-8 mb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Management</p>
                </div>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.orders.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white hover:translate-x-1' }}">
                    <svg class="w-5 h-5 transition-colors duration-300 {{ request()->routeIs('admin.orders.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-white' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M12 16h.01" />
                    </svg>
                    Orders
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.users.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white hover:translate-x-1' }}">
                    <svg class="w-5 h-5 transition-colors duration-300 {{ request()->routeIs('admin.users.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-white' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Users
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.categories.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white hover:translate-x-1' }}">
                    <svg class="w-5 h-5 transition-colors duration-300 {{ request()->routeIs('admin.categories.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-white' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Categories
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.products.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white hover:translate-x-1' }}">
                    <svg class="w-5 h-5 transition-colors duration-300 {{ request()->routeIs('admin.products.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-white' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Products
                </a>

                <div class="px-4 mt-8 mb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Marketing</p>
                </div>

                <a href="{{ route('admin.banners.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.banners.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white hover:translate-x-1' }}">
                    <svg class="w-5 h-5 transition-colors duration-300 {{ request()->routeIs('admin.banners.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-white' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Banners
                </a>

            </nav>

            <!-- Admin Profile -->
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                <div
                    class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    <img class="h-10 w-10 rounded-full object-cover border-2 border-slate-600 shadow-sm"
                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->name ?? 'Admin') }}&background=E53935&color=fff"
                        alt="Admin">

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-900 dark:text-white truncate">
                            {{ auth()->user()?->name ?? 'Administrator' }}
                        </p>
                        <p class="text-xs text-slate-500 truncate">
                            Super Admin
                        </p>
                    </div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('admin.logout') }}" id="admin-logout-form">
                        @csrf
                        <button type="button" onclick="confirmLogout()"
                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-slate-700 rounded-lg transition-colors"
                            title="Logout">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                    </form>

                    <script>
                        function confirmLogout() {
                            Swal.fire({
                                title: 'Logging Out?',
                                text: "Are you sure you want to end your session?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#EF4444',
                                cancelButtonColor: '#64748B',
                                confirmButtonText: 'Yes, Logout',
                                cancelButtonText: 'Cancel',
                                customClass: {
                                    popup: 'dark:bg-slate-800 dark:text-white rounded-2xl',
                                    title: 'dark:text-white',
                                    htmlContainer: 'dark:text-slate-300'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('admin-logout-form').submit();
                                }
                            })
                        }
                    </script>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">

            <!-- Glass Header -->
            <header
                class="glass-panel sticky top-0 z-30 h-20 px-6 lg:px-8 flex items-center justify-between transition-all duration-200">

                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 -ml-2 text-slate-500 hover:text-slate-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    @if(isset($header))
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                                {{ $header }}
                            </h2>
                        </div>
                    @else
                        <div class="h-6 w-32 bg-gray-200 dark:bg-gray-800 rounded animate-pulse"></div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <button @click="toggleTheme()"
                        class="p-2.5 rounded-xl text-slate-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500/20">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- Notifications -->
                    <button
                        class="relative p-2.5 rounded-xl text-slate-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 dark:bg-gray-950 p-6 lg:p-8">
                <div class="max-w-7xl mx-auto space-y-6">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div class="mt-12 text-center text-sm text-slate-500 dark:text-gray-400 pb-8">
                    &copy; {{ date('Y') }} Okazyon. All rights reserved.
                </div>
            </div>
        </main>
    </div>
    <x-delete-confirm-modal />
</body>

</html>
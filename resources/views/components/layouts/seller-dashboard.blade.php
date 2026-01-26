<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
    x-data="{ 
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
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|tajawal:400,500,700" rel="stylesheet" />

    <style>
        :root {
            --font-arabic: 'Tajawal', sans-serif;
            --font-english: 'Poppins', sans-serif;
        }

        body {
            font-family:
                {{ app()->getLocale() === 'ar' ? 'var(--font-arabic)' : 'var(--font-english)' }}
            ;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Iconsax -->
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">

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

        .sidebar-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
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
    class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 overflow-hidden selection:bg-red-500 selection:text-white"
    x-data="{ sidebarOpen: false }">

    <!-- Mobile Restriction Overlay -->
    <div
        class="fixed inset-0 z-[9999] lg:hidden bg-white dark:bg-slate-900 flex items-center justify-center p-6 text-center overflow-hidden">
        <div class="max-w-xs scale-110">
            <div
                class="w-20 h-20 bg-red-500/10 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-red-500/10 border border-red-500/20">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-slate-900 dark:text-white text-2xl font-black mb-3 tracking-tight">
                {{ __('admin.desktop_only') }}
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium leading-relaxed">
                {{ __('admin.desktop_only_message') }}
            </p>
            <div class="mt-8 flex justify-center">
                <div class="h-1 w-12 bg-red-500/20 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-40 lg:hidden" x-cloak></div>

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : (isRtl ? 'translate-x-full' : '-translate-x-full')"
            class="fixed inset-y-0 z-50 w-72 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:flex lg:flex-col shadow-2xl lg:shadow-none {{ app()->getLocale() === 'ar' ? 'right-0 border-l border-r-0' : 'left-0 border-r' }}">

            <!-- Logo Area -->
            <div class="h-20 flex items-center px-8 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-600 to-red-500 flex items-center justify-center text-white shadow-lg shadow-red-500/20 text-2xl">
                        <i class="iconsax" icon-name="shop"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ config('app.name') }}
                        </h1>
                        <p class="text-[10px] uppercase font-bold tracking-widest text-red-600 dark:text-red-400">
                            {{ __('navigation.seller_panel') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">

                <div class="px-4 mb-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        {{ __('navigation.overview') }}
                    </p>
                </div>

                <a href="{{ route('seller.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('seller.dashboard') ? 'bg-red-50 dark:bg-red-900/10 text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                    <i class="iconsax {{ request()->routeIs('seller.dashboard') ? 'text-red-600 dark:text-red-400' : 'text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400' }} text-2xl"
                        icon-name="grid-apps"></i>
                    {{ __('navigation.dashboard') }}
                </a>

                <div class="px-4 mt-8 mb-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        {{ __('navigation.management') }}
                    </p>
                </div>

                <a href="{{ route('seller.products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('seller.products.*') ? 'bg-red-50 dark:bg-red-900/10 text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                    <i class="iconsax {{ request()->routeIs('seller.products.*') ? 'text-red-600 dark:text-red-400' : 'text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400' }} text-2xl"
                        icon-name="box"></i>
                    {{ __('navigation.products') }}
                </a>

                <a href="{{ route('seller.orders.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('seller.orders.*') ? 'bg-red-50 dark:bg-red-900/10 text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                    <i class="iconsax {{ request()->routeIs('seller.orders.*') ? 'text-red-600 dark:text-red-400' : 'text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400' }} text-2xl"
                        icon-name="receipt-2"></i>
                    {{ __('navigation.orders') }}
                </a>

            </nav>

            <!-- User User Profile -->
            <div class="p-4 border-t border-gray-100 dark:border-gray-800">
                <div
                    class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50">
                    <img class="h-10 w-10 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-sm"
                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=EF4444&color=fff"
                        alt="{{ auth()->user()->name }}">

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('seller.logout') }}" id="seller-logout-form">
                        @csrf
                        <button type="button" onclick="confirmSellerLogout()"
                            class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-colors"
                            title="Logout">
                            <i class="iconsax text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 text-2xl"
                                icon-name="logout"></i>
                        </button>
                    </form>

                    <script>
                        function confirmSellerLogout() {
                            Swal.fire({
                                title: '{{ __('dashboard.logout_title') }}',
                                text: "{{ __('dashboard.logout_message') }}",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#EF4444',
                                cancelButtonColor: '#F3F4F6',
                                confirmButtonText: '{{ __('dashboard.yes_logout') }}',
                                cancelButtonText: '{{ __('dashboard.cancel') }}',
                                reverseButtons: true,
                                customClass: {
                                    popup: 'dark:bg-slate-800 dark:text-white rounded-2xl',
                                    title: 'dark:text-white',
                                    htmlContainer: 'dark:text-slate-300',
                                    cancelButton: 'text-gray-700 font-bold bg-gray-100 hover:bg-gray-200'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('seller-logout-form').submit();
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
                        class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 text-2xl">
                        <i class="iconsax" icon-name="menu-1"></i>
                    </button>

                    @if(isset($header))
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                                {{ $header }}
                            </h2>
                        </div>
                    @else
                        <div class="h-6 w-32 bg-gray-200 dark:bg-gray-800 rounded animate-pulse"></div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <!-- Language Switcher -->
                    <!-- Language Switcher -->
                    <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 hover:border-red-100 dark:hover:border-red-900/30 hover:bg-red-50 dark:hover:bg-red-900/10 transition-all group shadow-sm">
                        <span
                            class="text-xs font-bold text-gray-700 dark:text-gray-300 group-hover:text-red-600 dark:group-hover:text-red-400">
                            {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
                        </span>
                    </a>

                    <!-- Dark Mode Toggle -->
                    <button @click="toggleTheme()"
                        class="p-2.5 rounded-xl text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500/20 text-2xl">
                        <i x-show="!darkMode" class="iconsax" icon-name="sun"></i>
                        <i x-show="darkMode" x-cloak class="iconsax" icon-name="moon"></i>
                    </button>

                    <!-- Notifications -->

                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-950 p-6 lg:p-8">
                <div class="max-w-7xl mx-auto space-y-6">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400 pb-8">
                    &copy; {{ date('Y') }} Okazyon. All rights reserved.
                </div>
            </div>
        </main>
    </div>
</body>

</html>
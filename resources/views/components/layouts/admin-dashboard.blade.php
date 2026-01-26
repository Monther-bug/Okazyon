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

    <title>{{ $title ?? __('admin.dashboard') }} - {{ __('admin.app_name') }} {{ __('admin.administration') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|inter:400,500,600,700" rel="stylesheet" />
    @if(app()->getLocale() === 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Tajawal', sans-serif !important;
            }
        </style>
    @endif

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-40 lg:hidden" x-cloak></div>

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : (document.dir === 'rtl' ? 'translate-x-full' : '-translate-x-full')"
            class="fixed inset-y-0 start-0 z-50 w-72 bg-white dark:bg-slate-900 text-slate-900 dark:text-gray-100 border-e border-slate-200 dark:border-slate-800 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:flex lg:flex-col shadow-2xl lg:shadow-none">

            <!-- Logo Area -->
            <div class="h-20 flex items-center px-8 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-red-500/20 text-2xl">
                        <i class="iconsax" icon-name="grid-apps"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                            {{ __('admin.app_name') }}
                        </h1>
                        <p class="text-[10px] uppercase font-bold tracking-widest text-red-500">
                            {{ __('admin.administration') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">

                <div class="px-4 mb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('admin.overview') }}
                    </p>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.dashboard') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none rtl:-translate-x-1 ltr:translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white rtl:hover:-translate-x-1 ltr:hover:translate-x-1' }}">
                    <i class="iconsax {{ request()->routeIs('admin.dashboard') ? 'text-red-600' : 'text-slate-500 group-hover:text-red-500' }} text-2xl"
                        icon-name="grid-apps"></i>
                    {{ __('admin.dashboard') }}
                </a>

                <div class="px-4 mt-8 mb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        {{ __('admin.management') }}
                    </p>
                </div>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.orders.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none rtl:-translate-x-1 ltr:translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white rtl:hover:-translate-x-1 ltr:hover:translate-x-1' }}">
                    <i class="iconsax {{ request()->routeIs('admin.orders.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-red-500' }} text-2xl"
                        icon-name="receipt-2"></i>
                    {{ __('admin.orders') }}
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.users.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none rtl:-translate-x-1 ltr:translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white rtl:hover:-translate-x-1 ltr:hover:translate-x-1' }}">
                    <i class="iconsax {{ request()->routeIs('admin.users.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-red-500' }} text-2xl"
                        icon-name="users"></i>
                    {{ __('admin.users') }}
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.categories.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none rtl:-translate-x-1 ltr:translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white rtl:hover:-translate-x-1 ltr:hover:translate-x-1' }}">
                    <i class="iconsax {{ request()->routeIs('admin.categories.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-red-500' }} text-2xl"
                        icon-name="grid-apps-2"></i>
                    {{ __('admin.categories') }}
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.products.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none rtl:-translate-x-1 ltr:translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white rtl:hover:-translate-x-1 ltr:hover:translate-x-1' }}">
                    <i class="iconsax {{ request()->routeIs('admin.products.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-red-500' }} text-2xl"
                        icon-name="box"></i>
                    {{ __('admin.products') }}
                </a>

                <div class="px-4 mt-8 mb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('admin.marketing') }}
                    </p>
                </div>

                <a href="{{ route('admin.banners.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-300 ease-out group {{ request()->routeIs('admin.banners.*') ? 'bg-white dark:bg-slate-800 text-red-600 shadow-lg shadow-white/10 dark:shadow-none rtl:-translate-x-1 ltr:translate-x-1' : 'text-slate-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white rtl:hover:-translate-x-1 ltr:hover:translate-x-1' }}">
                    <i class="iconsax {{ request()->routeIs('admin.banners.*') ? 'text-red-600' : 'text-slate-500 group-hover:text-red-500' }} text-2xl"
                        icon-name="picture"></i>
                    {{ __('admin.banners') }}
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
                            {{ __('admin.super_admin') }}
                        </p>
                    </div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('admin.logout') }}" id="admin-logout-form">
                        @csrf
                        <button type="button" onclick="confirmLogout()"
                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-slate-700 rounded-lg transition-colors"
                            title="{{ __('admin.logout') }}">
                            <i class="iconsax text-slate-400 group-hover:text-red-500 text-2xl" icon-name="logout"></i>
                        </button>
                    </form>

                    <script>
                        function confirmLogout() {
                            Swal.fire({
                                title: "{{ __('admin.logout_confirm_title') }}",
                                text: "{{ __('admin.logout_confirm_message') }}",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#EF4444',
                                cancelButtonColor: '#64748B',
                                confirmButtonText: "{{ __('admin.yes_logout') }}",
                                cancelButtonText: "{{ __('admin.cancel') }}",
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
                        class="lg:hidden p-2 -ml-2 text-slate-500 hover:text-slate-700 dark:text-gray-400 dark:hover:text-gray-200 text-2xl">
                        <i class="iconsax" icon-name="menu-1"></i>
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
                    <!-- Language Switcher -->
                    @if(app()->getLocale() == 'ar')
                        <a href="{{ url('lang/en') }}"
                            class="p-2.5 rounded-xl text-slate-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors focus:outline-none font-bold text-sm">
                            English
                        </a>
                    @else
                        <a href="{{ url('lang/ar') }}"
                            class="p-2.5 rounded-xl text-slate-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors focus:outline-none font-family-tajawal font-bold text-sm">
                            العربية
                        </a>
                    @endif

                    <button @click="toggleTheme()"
                        class="p-2.5 rounded-xl text-slate-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500/20 text-2xl">
                        <i x-show="!darkMode" class="iconsax" icon-name="sun"></i>
                        <i x-show="darkMode" x-cloak class="iconsax" icon-name="moon"></i>
                    </button>
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
                    &copy; {{ date('Y') }} {{ __('admin.app_name') }}. {{ __('admin.all_rights_reserved') }}
                </div>
            </div>
        </main>
    </div>
    <x-delete-confirm-modal />
</body>

</html>
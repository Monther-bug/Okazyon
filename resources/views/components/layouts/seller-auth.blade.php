<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }} - Seller</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased text-gray-900 bg-slate-50 dark:bg-gray-950 h-screen overflow-hidden flex items-center justify-center selection:bg-red-500 selection:text-white relative">

    <!-- Animated Background -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <!-- Subtle Animated Gradients -->
        <div
            class="absolute top-0 -left-4 w-96 h-96 bg-red-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
        </div>
        <div
            class="absolute top-0 -right-4 w-96 h-96 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000">
        </div>
        <div
            class="absolute bottom-0 right-20 w-96 h-96 bg-red-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>

        <!-- Floating Particles -->
        <div
            class="absolute top-1/4 left-1/4 w-2 h-2 bg-red-400 rounded-full opacity-40 animate-float animation-delay-2000">
        </div>
        <div class="absolute top-3/4 right-1/3 w-3 h-3 bg-orange-400 rounded-full opacity-30 animate-float"></div>
        <div
            class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-pink-400 rounded-full opacity-40 animate-float animation-delay-4000">
        </div>
        <div
            class="absolute top-1/3 right-1/4 w-1.5 h-1.5 bg-purple-400 rounded-full opacity-30 animate-float animation-delay-2000">
        </div>
    </div>

    <!-- Centered Form Container -->
    <div
        class="w-full max-w-md p-8 bg-white/80 backdrop-blur-xl rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative z-10 animate-fade-in-up border border-white/50 hover:shadow-[0_20px_50px_rgb(0,0,0,0.1)] transition-all duration-500 ease-in-out hover:-translate-y-1">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                {{ $heading ?? 'Welcome Back' }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ $subheading ?? 'Please sign in to your account' }}
            </p>
        </div>

        <!-- Notifications -->
        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 p-4 border border-green-200 animate-pulse-slow">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{ $slot }}

        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Okazyon. All rights reserved.
        </div>
    </div>

</body>

</html>
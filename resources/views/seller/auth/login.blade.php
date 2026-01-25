<x-layouts.seller-auth>
    <x-slot:title>{{ __('seller_auth.login_title') }}</x-slot:title>
    <x-slot:heading>{{ __('seller_auth.login_subtitle') }}</x-slot:heading>
    <x-slot:subheading>
        {{ __('seller_auth.or') }} <a href="{{ route('seller.register') }}"
            class="font-medium text-red-600 hover:text-red-500 hover:underline transition-colors duration-200">{{ __('seller_auth.register_now') }}</a>
    </x-slot:subheading>

    <form class="mt-8 space-y-6" action="{{ route('seller.login') }}" method="POST">
        @csrf

        <div class="space-y-4 rounded-md shadow-sm">
            <div>
                <label for="phone_number"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('seller_auth.phone_number') }}</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="phone_number" name="phone_number" type="tel" autocomplete="tel" required maxlength="10"
                        minlength="10" pattern="[0-9]{10}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out bg-[#eeecec] dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 @error('phone_number') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror {{ app()->getLocale() === 'ar' ? 'pl-10 text-right' : 'pr-10 text-left' }}"
                        value="{{ old('phone_number') }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                    @error('phone_number')
                        <div
                            class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    @enderror
                </div>
                @error('phone_number')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4" x-data="{ show: false }">
                <label for="password"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('seller_auth.password') }}</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="password" name="password" :type="show ? 'text' : 'password'"
                        autocomplete="current-password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out bg-[#eeecec] dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror {{ app()->getLocale() === 'ar' ? 'pl-10' : 'pr-10' }}">
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                        <!-- Eye Icon (Show) -->
                        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Eye Off Icon (Hide) -->
                        <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox"
                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded transition duration-150 ease-in-out">
                <label for="remember"
                    class="{{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }} block text-sm text-gray-900">
                    {{ __('seller_auth.remember_me') }}
                </label>
            </div>

            <div class="text-sm hover:underline">
                <a href="{{ route('seller.password.request') }}" class="font-medium text-red-600 hover:text-red-500">
                    {{ __('seller_auth.forgot_password') }}
                </a>
            </div>
        </div>

        <div>
            <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                <span
                    class="absolute inset-y-0 flex items-center {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }}">
                    <svg class="h-5 w-5 text-red-500 group-hover:text-red-400 transition ease-in-out duration-150"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                {{ __('seller_auth.sign_in') }}
            </button>
        </div>
    </form>
</x-layouts.seller-auth>
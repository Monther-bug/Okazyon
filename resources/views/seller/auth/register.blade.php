<x-layouts.seller-auth>
    <x-slot:title>{{ __('seller_auth.register_title') }}</x-slot:title>
    <x-slot:heading>{{ __('seller_auth.register_subtitle') }}</x-slot:heading>
    <x-slot:subheading>
        {{ __('seller_auth.already_have_account') }} <a href="{{ route('seller.login') }}"
            class="font-medium text-red-600 hover:text-red-500 hover:underline transition-colors duration-200">{{ __('seller_auth.sign_in') }}</a>
    </x-slot:subheading>

    <form class="mt-8 space-y-6" action="{{ route('seller.register') }}" method="POST">
        @csrf

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="first_name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('seller_auth.first_name') }}</label>
                    <div class="mt-1">
                        <input id="first_name" name="first_name" type="text" autocomplete="given-name" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out bg-[#eeecec] dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                            value="{{ old('first_name') }}">
                    </div>
                </div>
                <div>
                    <label for="last_name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('seller_auth.last_name') }}</label>
                    <div class="mt-1">
                        <input id="last_name" name="last_name" type="text" autocomplete="family-name" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out bg-[#eeecec] dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                            value="{{ old('last_name') }}">
                    </div>
                </div>
            </div>

            @error('first_name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            @error('last_name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

            <div>
                <label for="phone_number"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('seller_auth.phone_number') }}</label>
                <div class="mt-1">
                    <input id="phone_number" name="phone_number" type="tel" autocomplete="tel" required maxlength="10"
                        minlength="10" pattern="[0-9]{10}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" placeholder="09XXXXXXXXX"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out bg-[#eeecec] dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}"
                        value="{{ old('phone_number') }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                </div>
                @error('phone_number') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div x-data="{ show: false, showConfirm: false }">
                <div>
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('seller_auth.password') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="password" name="password" :type="show ? 'text' : 'password'"
                            autocomplete="new-password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out bg-[#eeecec] dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                            <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mt-4">
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('seller_auth.confirm_password') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="password_confirmation" name="password_confirmation"
                            :type="showConfirm ? 'text' : 'password'" autocomplete="new-password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out bg-[#eeecec] dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                            <svg x-show="!showConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showConfirm" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                    {{ __('seller_auth.create_account') }}
                </button>
            </div>

            <div class="text-xs text-center text-gray-500">
                {{ __('seller_auth.agree_terms') }} <a href="https://okazyon.lovable.app/" target="_blank"
                    class="underline hover:text-gray-900">{{ __('seller_auth.terms_service') }}</a>
                {{ __('seller_auth.and') }}
                <a href="https://okazyon.lovable.app/" target="_blank"
                    class="underline hover:text-gray-900">{{ __('seller_auth.privacy_policy') }}</a>.
            </div>
    </form>
</x-layouts.seller-auth>
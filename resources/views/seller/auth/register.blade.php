<x-layouts.seller-auth>
    <x-slot:title>Register</x-slot:title>
    <x-slot:heading>Create your account</x-slot:heading>
    <x-slot:subheading>
        Already have an account? <a href="{{ route('seller.login') }}"
            class="font-medium text-red-600 hover:text-red-500 hover:underline transition-colors duration-200">Sign
            in</a>
    </x-slot:subheading>

    <form class="mt-8 space-y-6" action="{{ route('seller.register') }}" method="POST">
        @csrf

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <div class="mt-1">
                        <input id="first_name" name="first_name" type="text" autocomplete="given-name" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out"
                            value="{{ old('first_name') }}">
                    </div>
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <div class="mt-1">
                        <input id="last_name" name="last_name" type="text" autocomplete="family-name" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out"
                            value="{{ old('last_name') }}">
                    </div>
                </div>
            </div>

            @error('first_name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            @error('last_name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <div class="mt-1">
                    <input id="phone_number" name="phone_number" type="tel" autocomplete="tel" required
                        placeholder="09XXXXXXXXX"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out"
                        value="{{ old('phone_number') }}">
                </div>
                @error('phone_number') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out">
                </div>
                @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                    Password</label>
                <div class="mt-1">
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        autocomplete="new-password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out">
                </div>
            </div>
        </div>

        <div>
            <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                Create Account
            </button>
        </div>

        <div class="text-xs text-center text-gray-500">
            By registering you agree to our <a href="#" class="underline hover:text-gray-900">Terms of Service</a> and
            <a href="#" class="underline hover:text-gray-900">Privacy Policy</a>.
        </div>
    </form>
</x-layouts.seller-auth>
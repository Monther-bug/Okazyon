<x-layouts.seller-auth>
    <x-slot:title>Forgot Password</x-slot:title>
    <x-slot:heading>Forgot Password?</x-slot:heading>
    <x-slot:subheading>
        Enter your phone number and we'll send you a code to reset your password.
    </x-slot:subheading>

    <form class="mt-8 space-y-6" action="{{ route('seller.password.email') }}" method="POST">
        @csrf

        <div class="space-y-4">
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
        </div>

        <div>
            <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                Send Reset Code
            </button>
        </div>

        <div class="flex items-center justify-center">
            <div class="text-sm">
                <a href="{{ route('seller.login') }}"
                    class="font-medium text-red-600 hover:text-red-500 hover:underline transition-colors duration-200">
                    Back to Login
                </a>
            </div>
        </div>
    </form>
</x-layouts.seller-auth>
<x-layouts.seller-auth>
    <x-slot:title>Reset Password</x-slot:title>
    <x-slot:heading>Reset Password</x-slot:heading>
    <x-slot:subheading>
        Enter the code sent to <span class="font-bold text-gray-900">{{ $phone_number }}</span> and your new password.
    </x-slot:subheading>

    <form class="mt-8 space-y-6" action="{{ route('seller.password.update') }}" method="POST">
        @csrf

        <div class="space-y-4">
            <!-- OTP Input -->
            <div>
                <label for="otp_code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                <div class="mt-1">
                    <input id="otp_code" name="otp_code" type="text" inputmode="numeric" autocomplete="one-time-code"
                        required maxlength="6"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm text-center tracking-widest font-mono transition duration-150 ease-in-out"
                        value="{{ old('otp_code') }}">
                </div>
                @error('otp_code') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
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
                Reset Password
            </button>
        </div>
    </form>
</x-layouts.seller-auth>
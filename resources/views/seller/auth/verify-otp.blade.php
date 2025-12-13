<x-layouts.seller-auth>
    <x-slot:title>Verify OTP</x-slot:title>
    <x-slot:heading>Verify Your Phone</x-slot:heading>
    <x-slot:subheading>
        We sent a 6-digit code to <span class="font-bold text-gray-900">{{ $phone_number }}</span>
    </x-slot:subheading>

    <div x-data="{
        otp: Array(6).fill(''),
        updateOtp() {
            this.$refs.hiddenInput.value = this.otp.join('');
        },
        focusNext(index) {
            if (this.otp[index].length === 1 && index < 5) {
                this.$refs['input_' + (index + 1)].focus();
            }
        },
        focusPrev(index) {
            if (this.otp[index].length === 0 && index > 0) {
                this.$refs['input_' + (index - 1)].focus();
            }
        },
        handlePaste(e) {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').slice(0, 6);
            if (!/^\d+$/.test(text)) return;
            
            this.otp = text.split('').concat(Array(6 - text.length).fill(''));
            this.updateOtp();
            
            // Focus layout
            this.$nextTick(() => {
                const filledCount = text.length;
                if (filledCount < 6) {
                    this.$refs['input_' + filledCount].focus();
                } else {
                    this.$refs['input_5'].focus();
                }
            });
        }
    }" class="mt-8 space-y-6">

        <form action="{{ route('seller.verify-otp.verify') }}" method="POST">
            @csrf
            <input type="hidden" name="otp_code" x-ref="hiddenInput">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 sr-only">OTP Code</label>
                    <div class="flex justify-center gap-2">
                        @for ($i = 0; $i < 6; $i++)
                            <input type="text" 
                                x-ref="input_{{ $i }}"
                                x-model="otp[{{ $i }}]"
                                @input="focusNext({{ $i }}); updateOtp()"
                                @keydown.backspace="focusPrev({{ $i }})"
                                @paste="handlePaste"
                                maxlength="1"
                                inputmode="numeric"
                                class="w-10 h-12 sm:w-14 sm:h-16 text-center text-xl sm:text-2xl font-bold text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all duration-200 ease-in-out caret-red-500 shadow-sm"
                            >
                        @endfor
                    </div>
                    @error('otp_code') <p class="mt-2 text-center text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8">
                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                    Verify Account
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 text-center" x-data="{ 
        timeLeft: {{ session('status') === 'OTP code sent!' ? 60 : 0 }}, 
        showTimer: {{ session('status') === 'OTP code sent!' ? 'true' : 'false' }},
        init() {
            if (this.timeLeft > 0) {
                this.startTimer();
            }
        },
        startTimer() {
            this.showTimer = true;
            this.timeLeft = 60;
            let interval = setInterval(() => {
                this.timeLeft--;
                if (this.timeLeft <= 0) {
                    clearInterval(interval);
                    this.showTimer = false;
                }
            }, 1000);
        }
    }">
        <form action="{{ route('seller.verify-otp.resend') }}" method="POST" @submit="startTimer">
            @csrf
            <p class="text-sm text-gray-600">
                Didn't receive the code?
                <template x-if="!showTimer">
                    <button type="submit"
                        class="font-medium text-red-600 hover:text-red-500 hover:underline transition-colors duration-200">
                        Resend
                    </button>
                </template>
                <template x-if="showTimer">
                    <span class="font-medium text-gray-400 cursor-not-allowed">
                        Resend in <span x-text="timeLeft"></span>s
                    </span>
                </template>
            </p>
        </form>
    </div>
</x-layouts.seller-auth>
<x-filament-panels::page.simple>
    @push('styles')
    <style>
        .otp-container {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin: 2rem 0;
        }
        
        .otp-input {
            width: 3.5rem;
            height: 3.5rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            transition: all 0.2s;
            background: white;
            color: #1f2937;
        }
        
        .dark .otp-input {
            background: #1f2937;
            color: #f9fafb;
            border-color: #374151;
        }
        
        .otp-input:focus {
            outline: none;
            border-color: #E53935;
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.1);
            transform: scale(1.05);
        }
        
        .otp-input:disabled {
            background: #f3f4f6;
            cursor: not-allowed;
        }
        
        .dark .otp-input:disabled {
            background: #111827;
        }
        
        .success-message {
            background: #E53935;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-family: 'Poppins', sans-serif;
            text-align: center;
        }
        
        .success-message h3 {
            font-weight: 600;
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }
        
        .success-message p {
            font-size: 0.875rem;
            opacity: 0.95;
        }
        
        .phone-display {
            text-align: center;
            margin: 1.5rem 0;
        }
        
        .phone-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 0.5rem;
        }
        
        .dark .phone-label {
            color: #9ca3af;
        }
        
        .phone-number {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            font-family: 'Poppins', sans-serif;
        }
        
        .dark .phone-number {
            color: #f9fafb;
        }
        
        .instructions {
            text-align: center;
            margin-top: 2rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 0.5rem;
            border-left: 4px solid #E53935;
        }
        
        .dark .instructions {
            background: #1f2937;
        }
        
        .instructions p {
            font-size: 0.875rem;
            color: #6b7280;
            font-family: 'Poppins', sans-serif;
            margin: 0.25rem 0;
        }
        
        .dark .instructions p {
            color: #9ca3af;
        }
    </style>
    @endpush

    <div class="success-message">
        <h3>Request sent successfully!</h3>
        <p>We've sent a 6-digit confirmation OTP to your phone number. Please enter the code in below box to verify your phone number.</p>
    </div>

    <div class="phone-display">
        <div class="phone-label">Phone number</div>
        <div class="phone-number">{{ $phoneNumber }}</div>
    </div>

    <form wire:submit="verify">
        <input type="hidden" wire:model="data.phone_number" />
        
        <div class="otp-container">
            <input 
                type="text" 
                maxlength="1" 
                class="otp-input" 
                id="otp-1"
                inputmode="numeric"
                pattern="[0-9]"
                autocomplete="off"
            />
            <input 
                type="text" 
                maxlength="1" 
                class="otp-input" 
                id="otp-2"
                inputmode="numeric"
                pattern="[0-9]"
                autocomplete="off"
            />
            <input 
                type="text" 
                maxlength="1" 
                class="otp-input" 
                id="otp-3"
                inputmode="numeric"
                pattern="[0-9]"
                autocomplete="off"
            />
            <input 
                type="text" 
                maxlength="1" 
                class="otp-input" 
                id="otp-4"
                inputmode="numeric"
                pattern="[0-9]"
                autocomplete="off"
            />
            <input 
                type="text" 
                maxlength="1" 
                class="otp-input" 
                id="otp-5"
                inputmode="numeric"
                pattern="[0-9]"
                autocomplete="off"
            />
            <input 
                type="text" 
                maxlength="1" 
                class="otp-input" 
                id="otp-6"
                inputmode="numeric"
                pattern="[0-9]"
                autocomplete="off"
            />
        </div>

        <input type="hidden" wire:model="data.otp_code" id="otp-code-hidden" />

        <x-filament::button
            type="submit"
            class="w-full"
            style="background-color: #E53935; font-family: 'Poppins', sans-serif;"
        >
            Verify OTP
        </x-filament::button>
    </form>

    <div class="mt-6 text-center">
        <x-filament::button
            wire:click="resendOtp"
            color="gray"
            outlined
            style="font-family: 'Poppins', sans-serif;"
            id="resend-btn"
        >
            <span id="resend-text">Resend OTP</span>
            <span id="timer-text" style="display: none;">Resend OTP in <span id="countdown">60</span>s</span>
        </x-filament::button>
    </div>

    <div class="instructions">
        <p>Didn't receive the code? Check your phone or click Resend OTP.</p>
        <p>The OTP code is valid for 5 minutes.</p>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            const hiddenInput = document.getElementById('otp-code-hidden');
            const resendBtn = document.getElementById('resend-btn');
            const resendText = document.getElementById('resend-text');
            const timerText = document.getElementById('timer-text');
            const countdownSpan = document.getElementById('countdown');
            
            let timeLeft = 60;
            let countdownInterval;
            
            // Start countdown timer
            function startCountdown() {
                timeLeft = 60;
                resendBtn.disabled = true;
                resendBtn.style.opacity = '0.5';
                resendBtn.style.cursor = 'not-allowed';
                resendText.style.display = 'none';
                timerText.style.display = 'inline';
                
                countdownInterval = setInterval(() => {
                    timeLeft--;
                    countdownSpan.textContent = timeLeft;
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        resendBtn.disabled = false;
                        resendBtn.style.opacity = '1';
                        resendBtn.style.cursor = 'pointer';
                        resendText.style.display = 'inline';
                        timerText.style.display = 'none';
                    }
                }, 1000);
            }
            
            // Start countdown on page load
            startCountdown();
            
            // Restart countdown when resend button is clicked
            resendBtn.addEventListener('click', function(e) {
                if (!resendBtn.disabled) {
                    startCountdown();
                }
            });
            
            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        e.target.value = '';
                        return;
                    }
                    
                    // Move to next input
                    if (value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    
                    // Update hidden input with complete OTP
                    updateOtpCode();
                });
                
                input.addEventListener('keydown', function(e) {
                    // Move to previous input on backspace
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                    
                    // Move to previous input on left arrow
                    if (e.key === 'ArrowLeft' && index > 0) {
                        inputs[index - 1].focus();
                    }
                    
                    // Move to next input on right arrow
                    if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
                
                // Handle paste
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text');
                    const digits = pastedData.replace(/\D/g, '').slice(0, 6);
                    
                    digits.split('').forEach((digit, i) => {
                        if (inputs[i]) {
                            inputs[i].value = digit;
                        }
                    });
                    
                    // Focus last filled input or next empty
                    const lastIndex = Math.min(digits.length, inputs.length - 1);
                    inputs[lastIndex].focus();
                    
                    updateOtpCode();
                });
            });
            
            function updateOtpCode() {
                const code = Array.from(inputs).map(input => input.value).join('');
                hiddenInput.value = code;
                
                // Trigger Livewire update
                if (window.Livewire) {
                    window.Livewire.find(hiddenInput.closest('[wire\\:id]').getAttribute('wire:id'))
                        .set('data.otp_code', code);
                }
            }
            
            // Auto-focus first input
            inputs[0].focus();
            
            // Clean up interval on page unload
            window.addEventListener('beforeunload', function() {
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                }
            });
        });
    </script>
    @endpush
</x-filament-panels::page.simple>


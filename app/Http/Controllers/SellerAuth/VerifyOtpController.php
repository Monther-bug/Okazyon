<?php

namespace App\Http\Controllers\SellerAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTP\OtpService;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VerifyOtpController extends Controller
{
    public function show()
    {
        $phoneNumber = Session::get('otp_phone_number');

        if (!$phoneNumber) {
            Notification::make()
                ->title('Session Expired')
                ->body('Please start the registration process again.')
                ->warning()
                ->send();

            return redirect()->route('seller.register');
        }

        return view('seller.auth.verify-otp', ['phone_number' => $phoneNumber]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $phoneNumber = Session::get('otp_phone_number');

        if (!$phoneNumber) {
            return redirect()->route('seller.register')->with('status', 'Session expired.');
        }

        $otpService = app(OtpService::class);

        if ($otpService->verifyOtp($phoneNumber, $request->otp_code)) {
            return $this->completeRegistration($phoneNumber);
        }

        return back()->withErrors(['otp_code' => 'The OTP code is incorrect or has expired.']);
    }

    public function resend()
    {
        $phoneNumber = Session::get('otp_phone_number');

        if (!$phoneNumber) {
            return redirect()->route('seller.register');
        }

        $otpService = app(OtpService::class);
        $otpService->generateOtp($phoneNumber, 'registration');

        Notification::make()
            ->title('OTP Resent')
            ->body('A new OTP code has been sent to your phone number.')
            ->success()
            ->send();

        return back()->with('status', 'OTP code sent!');
    }

    protected function completeRegistration($phoneNumber)
    {
        $registrationData = Session::get('registration_data');

        if (!$registrationData) {
            Notification::make()->title('Error')->body('Registration data missing.')->danger()->send();
            return redirect()->route('seller.register');
        }

        // Create the user
        $user = User::create([
            'name' => $registrationData['name'],
            'phone_number' => $phoneNumber,
            'email' => $registrationData['email'] ?? null,
            'password' => $registrationData['password'], // Already hashed in RegisterController
            'type' => 'seller',
        ]);

        // Assign seller role
        $user->assignRole('seller'); // Assuming Spatie Permission or similar method exists

        // Clear session data
        Session::forget(['otp_phone_number', 'registration_data']);

        // Log the user in
        Auth::login($user);

        Notification::make()
            ->title('Registration Successful!')
            ->body('Welcome to Okazyon!')
            ->success()
            ->send();

        return redirect()->intended(route('seller.dashboard'));
    }
}

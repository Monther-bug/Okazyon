<?php

namespace App\Http\Controllers\SellerAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTP\OtpService;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function show()
    {
        return view('seller.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Store registration data in session
        session([
            'registration_data' => [
                'name' => $request->first_name . ' ' . $request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'type' => 'seller',
            ]
        ]);

        // Send OTP
        $otpService = app(OtpService::class);
        $otpService->generateOtp($request->phone_number, 'registration');

        // Store phone number for verification page
        session(['otp_phone_number' => $request->phone_number]);

        // Redirect to OTP verification page
        return redirect()->route('seller.auth.verify-otp')->with('success', 'OTP sent successfully. Please check your phone.');
    }
}

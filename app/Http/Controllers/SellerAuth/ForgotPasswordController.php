<?php

namespace App\Http\Controllers\SellerAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTP\OtpService;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    public function show()
    {
        return view('seller.auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'exists:users,phone_number'],
        ]);

        // Send OTP
        $otpService = app(OtpService::class);
        $otpService->generateOtp($request->phone_number, 'password_reset');

        // Store phone in session for the next step (ResetPasswordController)
        Session::put('password_reset_phone', $request->phone_number);

        Notification::make()
            ->title('OTP Sent')
            ->body('We have sent a verification code to your phone number.')
            ->success()
            ->send();

        return redirect()->route('seller.password.reset');
    }
}

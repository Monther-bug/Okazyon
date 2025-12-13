<?php

namespace App\Http\Controllers\SellerAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTP\OtpService;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    public function show()
    {
        if (!Session::has('password_reset_phone')) {
            return redirect()->route('seller.password.request');
        }

        return view('seller.auth.reset-password', [
            'phone_number' => Session::get('password_reset_phone')
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $phoneNumber = Session::get('password_reset_phone');

        if (!$phoneNumber) {
            return redirect()->route('seller.password.request')->with('status', 'Session expired.');
        }

        // Verify OTP
        $otpService = app(OtpService::class);
        if (!$otpService->verifyOtp($phoneNumber, $request->otp_code)) {
            return back()->withErrors(['otp_code' => 'The OTP code is incorrect or has expired.']);
        }

        // Update Password
        $user = User::where('phone_number', $phoneNumber)->firstOrFail();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        // Cleanup
        Session::forget('password_reset_phone');

        Notification::make()
            ->title('Password Reset Successfully')
            ->body('You can now login with your new password.')
            ->success()
            ->send();

        return redirect()->route('seller.login');
    }
}

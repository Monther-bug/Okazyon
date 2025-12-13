<?php

namespace App\Http\Controllers\SellerAuth;

use App\Http\Controllers\Controller;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function show()
    {
        return view('seller.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone_number' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Check if user is seller? (If needed, add logic here)
            // For now, assuming all users logging in here are sellers or will be redirected 
            // properly by Filament middleware if not authorized.

            Notification::make()
                ->title('Welcome Back!')
                ->body('You have successfully logged in.')
                ->success()
                ->send();

            return redirect()->intended(route('filament.seller.pages.dashboard'));
        }

        throw ValidationException::withMessages([
            'phone_number' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login');
    }
}

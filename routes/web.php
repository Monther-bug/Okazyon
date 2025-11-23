<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\Auth\VerifyOtp;

Route::get('/', function () {
    return view('welcome');
});

// OTP Verification Route for Seller Registration
Route::get('/seller/verify-otp', VerifyOtp::class)
    ->middleware('web')
    ->name('filament.seller.auth.verify-otp');

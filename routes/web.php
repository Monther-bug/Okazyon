<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\Auth\VerifyOtp;

Route::get('/', function () {
    return view('welcome');
});

// OTP Verification Routes for Seller Registration
Route::middleware('web')->group(function () {
    Route::get('/seller/verify-otp', [App\Http\Controllers\SellerAuth\VerifyOtpController::class, 'show'])
        ->name('filament.seller.auth.verify-otp'); // Keeping this name for compatibility with redirects

    Route::post('/seller/verify-otp', [App\Http\Controllers\SellerAuth\VerifyOtpController::class, 'verify'])
        ->name('seller.verify-otp.verify');

    Route::post('/seller/verify-otp/resend', [App\Http\Controllers\SellerAuth\VerifyOtpController::class, 'resend'])
        ->name('seller.verify-otp.resend');
});

// Seller Custom Auth Routes
Route::prefix('seller')->group(function () {
    // GET Login - Named for Filament's Auth Redirection
    Route::get('/login', [App\Http\Controllers\SellerAuth\LoginController::class, 'show'])
        ->name('filament.seller.auth.login');

    // POST Login - Named for Form Action
    Route::post('/login', [App\Http\Controllers\SellerAuth\LoginController::class, 'login'])
        ->name('seller.login');

    Route::post('/logout', [App\Http\Controllers\SellerAuth\LoginController::class, 'logout'])
        ->name('seller.logout');

    // Seller Registration Routes
    Route::name('seller.')->group(function () {
        Route::get('/register', [App\Http\Controllers\SellerAuth\RegisterController::class, 'show'])->name('register');
        Route::post('/register', [App\Http\Controllers\SellerAuth\RegisterController::class, 'register']);

        // Password Reset Routes
        Route::get('/forgot-password', [App\Http\Controllers\SellerAuth\ForgotPasswordController::class, 'show'])->name('password.request');
        Route::post('/forgot-password', [App\Http\Controllers\SellerAuth\ForgotPasswordController::class, 'sendOtp'])->name('password.email');

        Route::get('/reset-password', [App\Http\Controllers\SellerAuth\ResetPasswordController::class, 'show'])->name('password.reset');
        Route::post('/reset-password', [App\Http\Controllers\SellerAuth\ResetPasswordController::class, 'update'])->name('password.update');
    });
});

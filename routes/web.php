<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('web')->group(function () {
    Route::get('/seller/verify-otp', [App\Http\Controllers\SellerAuth\VerifyOtpController::class, 'show'])
        ->name('seller.auth.verify-otp');

    Route::post('/seller/verify-otp', [App\Http\Controllers\SellerAuth\VerifyOtpController::class, 'verify'])
        ->name('seller.verify-otp.verify');

    Route::post('/seller/verify-otp/resend', [App\Http\Controllers\SellerAuth\VerifyOtpController::class, 'resend'])
        ->name('seller.verify-otp.resend');
});

Route::prefix('seller')->group(function () {
    Route::get('/login', [App\Http\Controllers\SellerAuth\LoginController::class, 'show'])
        ->name('seller.auth.login');

    Route::post('/login', [App\Http\Controllers\SellerAuth\LoginController::class, 'login'])
        ->name('seller.login');

    Route::post('/logout', [App\Http\Controllers\SellerAuth\LoginController::class, 'logout'])
        ->name('seller.logout');

    Route::name('seller.')->group(function () {
        Route::get('/register', [App\Http\Controllers\SellerAuth\RegisterController::class, 'show'])->name('register');
        Route::post('/register', [App\Http\Controllers\SellerAuth\RegisterController::class, 'register']);

        Route::get('/forgot-password', [App\Http\Controllers\SellerAuth\ForgotPasswordController::class, 'show'])->name('password.request');
        Route::post('/forgot-password', [App\Http\Controllers\SellerAuth\ForgotPasswordController::class, 'sendOtp'])->name('password.email');

        Route::get('/reset-password', [App\Http\Controllers\SellerAuth\ResetPasswordController::class, 'show'])->name('password.reset');
        Route::post('/reset-password', [App\Http\Controllers\SellerAuth\ResetPasswordController::class, 'update'])->name('password.update');
    });

    Route::middleware(['auth', 'role:seller'])->name('seller.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Seller\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', App\Http\Controllers\Seller\ProductController::class);
        Route::resource('orders', App\Http\Controllers\Seller\OrderController::class)->only(['index', 'show', 'update']);
    });
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\AdminAuth\LoginController::class, 'show'])->name('login');
    Route::post('/login', [App\Http\Controllers\AdminAuth\LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [App\Http\Controllers\AdminAuth\LoginController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('users/export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['create', 'store']);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class)->except(['show']);
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerAuth\VerifyOtpController;
use App\Http\Controllers\SellerAuth\LoginController;
use App\Http\Controllers\SellerAuth\RegisterController;
use App\Http\Controllers\SellerAuth\ForgotPasswordController;
use App\Http\Controllers\SellerAuth\ResetPasswordController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\AdminAuth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('web')->group(function () {
    Route::get('/seller/verify-otp', [VerifyOtpController::class, 'show'])
        ->name('seller.auth.verify-otp');

    Route::post('/seller/verify-otp', [VerifyOtpController::class, 'verify'])
        ->name('seller.verify-otp.verify');

    Route::post('/seller/verify-otp/resend', [VerifyOtpController::class, 'resend'])
        ->name('seller.verify-otp.resend');
});

Route::prefix('seller')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])
        ->name('seller.auth.login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('seller.login');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('seller.logout');

    Route::name('seller.')->group(function () {
        Route::get('/register', [RegisterController::class, 'show'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);

        Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');

        Route::get('/reset-password', [ResetPasswordController::class, 'show'])->name('password.reset');
        Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('password.update');
    });

    Route::middleware(['auth', 'role:seller'])->name('seller.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('products/export', [SellerProductController::class, 'export'])->name('products.export');
        Route::resource('products', SellerProductController::class);
        Route::get('orders/export', [SellerOrderController::class, 'export'])->name('orders.export');
        Route::resource('orders', SellerOrderController::class)->only(['index', 'show', 'update']);
    });
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'show'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class)->except(['create', 'store']);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', AdminProductController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::resource('banners', BannerController::class)->except(['show']);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
});

<?php
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\OTPController;
use App\Http\Controllers\User\FCMController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\SellerDashboardController;
use App\Http\Controllers\User\SellerOrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SearchController;
use Illuminate\Support\Facades\Route;

// Public home routes (no authentication required)
Route::get('/home/banner', [BannerController::class, 'index']);
Route::get('/home/products', [HomeController::class, 'index']);
Route::get('/home/featured-deals', [HomeController::class, 'featuredDeals']);
Route::get('/home/new-deals', [HomeController::class, 'newDeals']);

// Public category and product routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/search', [SearchController::class, 'search']);

Route::middleware('throttle:otp')->group(function () {
    Route::post('/sendotp', [OTPController::class, 'generateOTP']);
    Route::post('/verifyotp', [OTPController::class, 'verifyOTP']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset-password', [AuthController::class, 'reSetPassword']);
Route::post('/google-login', [AuthController::class, 'loginWithGoogle']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);

    // FCM routes
    Route::post('/fcm-token', [FCMController::class, 'registerToken']);

    // User profile routes
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::post('/change-password', [UserController::class, 'changePassword']);

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/status', [NotificationController::class, 'unreadCount']);
    Route::put('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::get('/notifications/{notification}', [NotificationController::class, 'show']);

    // Product management routes (seller only)
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    // Product review routes (authenticated users only)
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);

    // Favorites routes (authenticated users only)
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/products/{product}/favorite', [FavoriteController::class, 'store']);
    Route::delete('/products/{product}/favorite', [FavoriteController::class, 'destroy']);

    // Address management routes
    Route::get('/addresses', [App\Http\Controllers\API\AddressController::class, 'index']);
    Route::post('/addresses', [App\Http\Controllers\API\AddressController::class, 'store']);
    Route::get('/addresses/{address}', [App\Http\Controllers\API\AddressController::class, 'show']);
    Route::put('/addresses/{address}', [App\Http\Controllers\API\AddressController::class, 'update']);
    Route::delete('/addresses/{address}', [App\Http\Controllers\API\AddressController::class, 'destroy']);
    Route::post('/addresses/{address}/set-default', [App\Http\Controllers\API\AddressController::class, 'setDefault']);

    // Cart routes
    Route::get('/cart', [App\Http\Controllers\API\CartController::class, 'index']);
    Route::post('/cart', [App\Http\Controllers\API\CartController::class, 'store']);
    Route::put('/cart/items/{cartItem}', [App\Http\Controllers\API\CartController::class, 'update']);
    Route::delete('/cart/items/{cartItem}', [App\Http\Controllers\API\CartController::class, 'destroy']);
    Route::delete('/cart', [App\Http\Controllers\API\CartController::class, 'clear']);

    // Order management routes (buyer)
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']); // Cancel order

    // Seller dashboard and order management routes
    Route::prefix('seller')->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index']);
        Route::get('/orders', [SellerOrderController::class, 'index']);
        Route::get('/orders/{order}', [SellerOrderController::class, 'show']);
        Route::put('/orders/{order}', [SellerOrderController::class, 'update']);
    });
});

<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('/users', UserController::class)->names('api.admin.users');
    Route::post('/users/{user}/alter-ban', [UserController::class, 'alterBan']);

    Route::apiResource('/notifications', NotificationController::class);
    Route::post('/notifications/{notification}/send', [NotificationController::class, 'send']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\General\TempUploadController;
use App\Http\Controllers\General\LocalizationController;

// All public product/category/home routes have been moved to userApi.php
// This file now only contains truly general routes (locale, uploads)

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/upload-image', [TempUploadController::class, 'uploadImage']);
});

Route::get('/locale', [LocalizationController::class, 'getLocale']);
Route::post('/locale', [LocalizationController::class, 'setLocale']);

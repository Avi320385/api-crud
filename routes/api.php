<?php

use App\Http\Controllers\Api\DateOfBirthController;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('products',ProductController::class);
Route::apiResource('dates',DateOfBirthController::class);
Route::apiResource('otp',OtpController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

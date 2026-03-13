<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// পাবলিক রাউটস (যেখানে টোকেন লাগবে না)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// প্রোটেক্টেড রাউটস (যেখানে লগইন করা থাকা বাধ্যতামূলক)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// পাবলিক রাউটস (যেখানে টোকেন লাগবে না)
Route::post('/register', [AuthController::class , 'register']);
Route::get('/register', function () {
    return response()->json([
    'message' => 'Register API only supports post method',
    ]);
});
Route::post('/login', [AuthController::class , 'login']);
Route::get('/login', function () {
    return response()->json([
    'message' => 'Login API only supports post method or you tried to access without token or you tried with wrong token',
    ]);
})->name('login');

Route::get('/testapi', [AuthController::class , 'testapi']);

// প্রোটেক্টেড রাউটস (যেখানে লগইন করা থাকা বাধ্যতামূলক)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class , 'me']);
    Route::post('/logout', [AuthController::class , 'logout']);
});

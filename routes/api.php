<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Public API login
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Protected routes with Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/dashboard', function (Request $request) {
        return response()->json([
            'message' => 'Welcome to dashboard',
            'user' => $request->user()
        ]);
    })->name('api.dashboard');
});

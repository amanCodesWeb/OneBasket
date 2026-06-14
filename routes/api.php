<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — v1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // ── Public ──────────────────────────────────────────────
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    // Public vendor listing
    Route::get('/vendors',      [VendorController::class, 'index']);
    Route::get('/vendors/{vendor}', [VendorController::class, 'show']);

    // ── Authenticated ───────────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user',    [AuthController::class, 'user']);

        // Vendor profile (own)
        Route::put('/vendor/profile', [VendorController::class, 'update']);
    });
});

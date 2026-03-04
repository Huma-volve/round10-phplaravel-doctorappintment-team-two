<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('chats', ChatController::class);
});

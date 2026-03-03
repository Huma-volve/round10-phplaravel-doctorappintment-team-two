<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DoctorController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public doctor endpoints
Route::get('/doctors/nearby', [DoctorController::class, 'nearby']);
Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);

// Authenticated favorites endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/doctors/{doctor}/favorite', [DoctorController::class, 'favorite']);
    Route::delete('/doctors/{doctor}/favorite', [DoctorController::class, 'unfavorite']);
});

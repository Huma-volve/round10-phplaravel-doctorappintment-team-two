<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('review')->group(function () {

    Route::get('/', [ReviewController::class, 'index']);
    Route::get('/{id}', [ReviewController::class, 'show']);
    Route::post('/', [ReviewController::class, 'store']);

    Route::put('/{id}', [ReviewController::class, 'update']);
    Route::delete('/{id}', [ReviewController::class, 'destroy']);
});

Route::prefix('users')->group(function () {

    Route::get('/', [ProfileController::class, 'index']);

    Route::get('/{id}', [ProfileController::class, 'show']);


    Route::post('/', [ProfileController::class, 'store']);


    Route::put('/{id}', [ProfileController::class, 'update']);

    Route::delete('/{id}', [ProfileController::class, 'destroy']);
});

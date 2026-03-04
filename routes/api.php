<?php

<<<<<<< Updated upstream
=======
use App\Http\Controllers\ReviewController;
>>>>>>> Stashed changes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
<<<<<<< Updated upstream
=======

Route::prefix('review')->group(function () {

    Route::get('/', [ReviewController::class, 'index']);
    Route::get('/{id}', [ReviewController::class, 'show']);
    Route::post('/', [ReviewController::class, 'store']);

    Route::put('/{id}', [ReviewController::class, 'update']);
    Route::delete('/{id}', [ReviewController::class, 'destroy']);
});
>>>>>>> Stashed changes

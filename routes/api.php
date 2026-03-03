<?php

use App\Models\Notifications;
use App\Models\User;
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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function () {
    $user = User::find(1);
    $notification = Notifications::first();
    $user->notify(new \App\Notifications\BroadcastNotification('Test Notification', 'This is a test notification'));
    event(new \App\Events\NotificationBroadcastEvent($user->id, $notification));
    return response()->json(['message' => 'API is working']);
});


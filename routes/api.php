<?php

<<<<<<< HEAD
<<<<<<< HEAD
=======



=======
>>>>>>> 09621b2ad9c9f16f2bd78156f87a0655c864e7b3
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Models\Notifications;
use App\Models\User;
>>>>>>> 32c2a88b5aca975f07622258ac45cda84ddc6fcd
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DoctorController;
use App\Http\Controllers\API\Favoritecontroller;
use App\Http\Controllers\API\SearchController;

<<<<<<< HEAD
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
require __DIR__.'/auth.php';
=======
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public doctor endpoints
Route::get('/doctors/nearby', [DoctorController::class, 'nearby']);
Route::get('/doctors/search', [SearchController::class, 'search']);

Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);

// Authenticated favorites endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/doctors/{doctor}/favorite', [DoctorController::class, 'favorite']);
    Route::delete('/doctors/{doctor}/favorite', [DoctorController::class, 'unfavorite']);
});

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // Specific chat routes must come BEFORE apiResource
    Route::get('/chats/favorites', [ChatController::class, 'allFavoriteChats']);
    Route::post('/chats/{chat}/favorite', [ChatController::class, 'toggleFavorite']);
    Route::post('/chats/{chat}/markAsRead', [ChatController::class, 'markAsRead']);
    Route::get('/chats/{chat}/unread-count-message', [ChatController::class, 'unreadMessagesCount']);

    Route::apiResource('chats', ChatController::class);
});




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
Route::get('test', function () {
    $user = User::find(1);
    $notification = Notifications::first();
    $user->notify(new \App\Notifications\BroadcastNotification('Test Notification', 'This is a test notification'));
    event(new \App\Events\NotificationBroadcastEvent($user->id, $notification));
    return response()->json(['message' => 'API is working']);
});
<<<<<<< HEAD
>>>>>>> 32c2a88b5aca975f07622258ac45cda84ddc6fcd
=======


   Route::get('/favorites', [Favoritecontroller::class, 'index']);
    Route::post('/favorites_store', [Favoritecontroller::class, 'store']);
>>>>>>> 09621b2ad9c9f16f2bd78156f87a0655c864e7b3

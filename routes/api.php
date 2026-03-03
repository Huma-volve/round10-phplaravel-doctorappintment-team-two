<?php

use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
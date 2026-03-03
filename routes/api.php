<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function (): void {
    $user = \App\Models\User::first();
    $NOTIFICATION = new \App\Notifications\AppointmentCreatedNotification(\App\Models\Appointment::first());
    event(new \App\Events\NotificationBroadcastEvent($user->id, $NOTIFICATION));
});

<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\VerifyPhoneController;
use App\Http\Controllers\Auth\DeleteAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/verify-phone', [VerifyPhoneController::class, 'store'])
    ->middleware('guest')
    ->name('verify-phone');

Route::post('/resend-otp', [VerifyPhoneController::class, 'resend'])
    ->middleware('guest')
    ->name('resend-otp');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('logout');
Route::delete('/delete-account', [DeleteAccountController::class, 'delete'])
    ->middleware('auth:sanctum');
Route::get('/login/google', [SocialController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [SocialController::class, 'handleCallback']);
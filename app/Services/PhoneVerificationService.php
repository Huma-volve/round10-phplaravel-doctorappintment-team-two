<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PhoneVerificationService
{
    private const OTP_CACHE_PREFIX = 'phone_otp:';

    private const ATTEMPTS_CACHE_PREFIX = 'phone_otp_attempts:';

    private const OTP_TTL_MINUTES = 10;

    private const MAX_ATTEMPTS = 5;

    private const LOCKOUT_MINUTES = 15;

    /**
     * Get the OTP code (from env in production, default 1234 for development).
     */
    public function getOtpCode(): string
    {
        return (string) (config('services.phone_otp.code') ?? '1234');
    }

    /**
     * Generate and store OTP for the user (in dev we use fixed code from env).
     */
    public function sendOtp(User $user): void
    {
        $this->ensureNotLockedOut($user);

        $code = $this->getOtpCode();
        $key = self::OTP_CACHE_PREFIX . $user->id;
        Cache::put($key, $code, now()->addMinutes(self::OTP_TTL_MINUTES));

        // In a real app you would send SMS here, e.g. Twilio.
        // For now we only store the code for verification.
    }

    /**
     * Verify the OTP for the user.
     *
     * @return array{success: bool, message: string, locked_until?: \Carbon\Carbon}
     */
    public function verifyOtp(User $user, string $code): array
    {
        $attemptsKey = self::ATTEMPTS_CACHE_PREFIX . $user->id;
        $otpKey = self::OTP_CACHE_PREFIX . $user->id;

        if ($this->isLockedOut($user)) {
            $lockedUntil = Cache::get($attemptsKey . '_until');

            return [
                'success' => false,
                'message' => 'Too many failed attempts. Try again later.',
                'locked_until' => $lockedUntil,
            ];
        }

        $storedCode = Cache::get($otpKey);
        if ($storedCode === null) {
            return [
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.',
            ];
        }

        $code = preg_replace('/\s+/', '', $code);
        if (! hash_equals($storedCode, $code)) {
            $attempts = (int) Cache::get($attemptsKey, 0) + 1;
            Cache::put($attemptsKey, $attempts, now()->addMinutes(self::LOCKOUT_MINUTES));

            if ($attempts >= self::MAX_ATTEMPTS) {
                Cache::put($attemptsKey . '_until', now()->addMinutes(self::LOCKOUT_MINUTES), now()->addMinutes(self::LOCKOUT_MINUTES));

                return [
                    'success' => false,
                    'message' => 'Too many failed attempts. Try again in ' . self::LOCKOUT_MINUTES . ' minutes.',
                    'locked_until' => now()->addMinutes(self::LOCKOUT_MINUTES),
                ];
            }

            $remaining = self::MAX_ATTEMPTS - $attempts;

            return [
                'success' => false,
                'message' => 'Invalid OTP. ' . $remaining . ' attempt(s) remaining.',
            ];
        }

        Cache::forget($otpKey);
        Cache::forget($attemptsKey);
        Cache::forget($attemptsKey . '_until');

        return ['success' => true, 'message' => 'Phone verified successfully.'];
    }

    public function isLockedOut(User $user): bool
    {
        $until = Cache::get(self::ATTEMPTS_CACHE_PREFIX . $user->id . '_until');
        if ($until === null) {
            return false;
        }

        return now()->lt($until);
    }

    private function ensureNotLockedOut(User $user): void
    {
        if ($this->isLockedOut($user)) {
            abort(429, 'Too many attempts. Please try again later.');
        }
    }
}

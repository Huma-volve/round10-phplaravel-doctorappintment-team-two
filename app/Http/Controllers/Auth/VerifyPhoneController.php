<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PhoneVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifyPhoneController extends Controller
{
    public function __construct(
        private PhoneVerificationService $phoneVerification
    ) {}

    /**
     * Verify phone OTP (sent to the phone). On success: set phone_verified_at, return token.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'phone_code' => ['required', 'string', 'max:10'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'otp' => ['required', 'string', 'max:10'],
        ]);

        $user = User::where('phone_code', $request->phone_code)
            ->where('mobile_number', $request->mobile_number)
            ->first();
        if (! $user) {
            return response()->json(['message' => 'User not found for this phone number.'], 404);
        }

        $result = $this->phoneVerification->verifyOtp($user, $request->otp);

        if (! $result['success']) {
            $status = 422;
            if (isset($result['locked_until'])) {
                $status = 429;
            }

            return response()->json([
                'message' => $result['message'],
                'locked_until' => $result['locked_until'] ?? null,
            ], $status);
        }

        $user->phone_verified_at = now();
        $user->save();

        $token = $user->createToken('main')->plainTextToken;

        return response()->json([
            'message' => 'Phone verified successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_code' => $user->phone_code,
                'mobile_number' => $user->mobile_number,
                'phone_verified_at' => $user->phone_verified_at?->toIso8601String(),
            ],
            'token' => $token,
        ]);
    }

    /**
     * Resend OTP to the phone (identify user by phone_code + mobile_number).
     */
    public function resend(Request $request): JsonResponse
    {
        $request->validate([
            'phone_code' => ['required', 'string', 'max:10'],
            'mobile_number' => ['required', 'string', 'max:20'],
        ]);

        $user = User::where('phone_code', $request->phone_code)
            ->where('mobile_number', $request->mobile_number)
            ->first();
        if (! $user) {
            return response()->json(['message' => 'User not found for this phone number.'], 404);
        }

        try {
            $this->phoneVerification->sendOtp($user);
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            if ($e->getStatusCode() === 429) {
                return response()->json(['message' => $e->getMessage()], 429);
            }
            throw $e;
        }

        return response()->json([
            'message' => 'OTP sent to your phone again. Enter it to verify.',
        ]);
    }
}

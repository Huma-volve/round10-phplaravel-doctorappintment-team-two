<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PhoneVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function __construct(
        private PhoneVerificationService $phoneVerification
    ) {}

    /**
     * Handle an incoming registration request.
     * Creates user with role=patient, sends OTP for phone verification.
     * Token is only returned after successful verify-phone.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_code' => ['required', 'string', 'max:10'],
            'mobile_number' => ['required', 'string', 'max:20', 'unique:users,mobile_number'],
            'birthdate' => ['nullable', 'date'],
            'profile_photo' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_code' => $request->phone_code,
            'mobile_number' => $request->mobile_number,
            'role' => 'patient',
            'birthdate' => $request->birthdate,
            'profile_photo' => $request->profile_photo,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        $this->phoneVerification->sendOtp($user);

        return response()->json([
            'message' => 'OTP sent to your phone. Enter it in the verify step to get your access token.',
            'next_step' => 'POST /verify-phone with phone_code, mobile_number, and otp (no token until verified).',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_code' => $user->phone_code,
                'mobile_number' => $user->mobile_number,
            ],
        ], 201);
    }
}

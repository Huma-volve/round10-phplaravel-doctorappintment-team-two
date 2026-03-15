<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Services\PhoneVerificationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function __construct(
        private PhoneVerificationService $phoneVerification
    ) {}

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'in:patient,doctor,admin'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'min:8'],
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
            'role' => $request->role,
            'mobile_number' => $request->mobile_number,
            'password' => Hash::make($request->password),
            'phone_code' => $request->phone_code,
            'birthdate' => $request->birthdate,
            'profile_photo' => $request->profile_photo,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        if ($user->role === 'patient') {
            Patient::create([
                'user_id' => $user->id
            ]);
        } elseif ($user->role === 'doctor') {
            Doctor::create([
                'user_id' => $user->id
            ]);
        }

        event(new Registered($user));

        $this->phoneVerification->sendOtp($user);

        Auth::login($user);

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


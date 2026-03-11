<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

use App\Models\User;

class SocialController extends Controller
{
    /**
     * Redirect the user to the Google OAuth consent screen.
     */
    public function redirectToGoogle(){
        $url = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return response()->json([
            'url' => $url
        ], 200);
    }
    public function handleCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('social_id', $googleUser->id)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'latitude' => 0.0, // Placeholder, you might want to handle this differently    
                    'mobile_number' => '', // Placeholder, you might want to handle this differently  
                    'social_id' => $googleUser->id,
                    'social_type' => 'google',
                    'longitude' => 0.0, // Placeholder, you might want to handle this differently 
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'patient',
                   
                ]);
            }

            $token = $user->createToken($user->name.'google-login')->plainTextToken;

            return response()->json([
                'message' => 'Successfully logged in',
                'user' => $user,
                'token' => $token,
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
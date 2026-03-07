<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function  store(LoginRequest $request)
    {
        $request->authenticate();
        $user = $request->user();
        $token = $user->createToken('main')->plainTextToken;

        return [
            "user" =>  [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
            ],
            "token" => $token
        ];
    }

    /**
     * Destroy an authenticated session.
     */
     public function destroy(Request $request): Response
    {
        $user = $request->user();

        if ($user) {
            $token = $user->currentAccessToken();
            if ($token) {
                $token->delete();
            }
        }

        return response()->noContent();
    }
    }


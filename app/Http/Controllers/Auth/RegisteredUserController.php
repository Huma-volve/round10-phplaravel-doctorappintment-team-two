<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
        'name' => ['required','string','max:255'],
        'email' => ['required','string','email','max:255','unique:users'],
        'role' => ['required','string','in:patient,doctor,admin'],
        'mobile_number' => ['required','string','max:20','unique:users,mobile_number'],
        'birthdate' => ['nullable','date'],
        'profile_photo' => ['nullable','string'],
        'latitude' => ['nullable','numeric'],
        'longitude' => ['nullable','numeric'],
        'password' => ['required','confirmed','min:8'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'mobile_number' => $request->mobile_number,
        'birthdate' => $request->birthdate,
        'profile_photo' => $request->profile_photo,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'password' => Hash::make($request->password),
    ]);
        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}

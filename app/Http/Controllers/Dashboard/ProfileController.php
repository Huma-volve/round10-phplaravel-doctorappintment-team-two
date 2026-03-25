<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialization;
use App\Models\Clinic;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $specializations = [];
        $clinics = [];

        if ($user->role === 'doctor') {
            $user->load('doctor');
            $specializations = Specialization::all();
            $clinics = Clinic::all();
        }

        return view('dashboard.profile', compact('user', 'specializations', 'clinics'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile_number' => 'required|string|max:20|unique:users,mobile_number,' . $user->id,
            'phone_code' => 'required|string|max:3',
            'birthdate' => 'nullable|date',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'profile_photo' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ];

        if ($user->role === 'doctor') {
            $rules = array_merge($rules, [
                'specialization' => 'required|exists:specializations,id',
                'clinic' => 'required|exists:clinics,id',
                'bio' => 'required|string',
                'session_price' => 'required|numeric|min:0',
                'clinic_address' => 'nullable|string',
                'license_number' => 'required|string',
            ]);
        }

        $data = $request->validate($rules);

        // Update User Model
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->mobile_number = $data['mobile_number'];
        $user->phone_code = $data['phone_code'];
        $user->birthdate = $data['birthdate'] ?? $user->birthdate;
        $user->latitude = $data['latitude'] ?? $user->latitude;
        $user->longitude = $data['longitude'] ?? $user->longitude;

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $user->profile_photo = $request->file('profile_photo')->store('profiles', 'public');
        }

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        // Update Doctor Model if applicable
        if ($user->role === 'doctor') {
            $user->doctor->update([
                'specialization_id' => $data['specialization'],
                'clinic_id' => $data['clinic'],
                'bio' => $data['bio'],
                'session_price' => $data['session_price'],
                'clinic_address' => $data['clinic_address'] ?? $user->doctor->clinic_address,
                'license_number' => $data['license_number'],
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}

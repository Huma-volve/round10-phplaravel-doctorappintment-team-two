<?php

namespace App\Http\Controllers\AdminDoctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\Clinic;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user', 'specialization','clinic')->get();
        return view('dashboard.doctor', compact('doctors'));
    }

    public function create()
    {
        $specializations = Specialization::all();
        $clinics = Clinic::all();
        return view('dashboard.add-doctor', compact('specializations', 'clinics'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile_number' => 'required|string|max:20|unique:users,mobile_number',
            'phone_code' => 'required|string|max:3',
            'specialization' => 'required|exists:specializations,id',
            'birthdate' => 'nullable|date',
            'role' => 'required|in:doctor',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'clinic' => 'required|exists:clinics,id',
            'bio' => 'required|string',
            'profile_photo' => 'nullable|image',
            'session_price' => 'required|numeric|min:0',
            'clinic_address' => 'nullable|string',
            'license_number' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // رفع الصورة لو موجودة
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('doctors','public');
        }

        // إنشاء User أولاً
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_number' => $data['mobile_number'],
            'phone_code' => $data['phone_code'],
            'birthdate' => $data['birthdate'] ?? null,
            'role' => 'doctor',
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'profile_photo' => $data['profile_photo'] ?? null,
            'password' => bcrypt($data['password']),
        ]);

        // إنشاء Doctor مربوط بالـ user_id
        Doctor::create([
            'user_id' => $user->id,
            'specialization_id' => $data['specialization'],
            'clinic_id' => $data['clinic'],
            'bio' => $data['bio'] ?? null,
            'session_price' => $data['session_price'],
            'clinic_address' => $data['clinic_address'] ?? null,
            'license_number' => $data['license_number'] ?? null,
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success','Doctor created successfully');
    }

    public function destroy($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->delete();

        return redirect()->route('admin.doctors.index')
            ->with('success','Doctor deleted successfully');
    }
}
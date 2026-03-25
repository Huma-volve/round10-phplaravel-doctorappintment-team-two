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

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('doctors','public');
        }

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
    // edit doctor
    public function edit($id)
    {
        // get user_id from doctor table
        $user_id = Doctor::where('id', $id)->first()->user_id;
        $doctor = User::where('id', $user_id)->first();
        $specializations = Specialization::all();
        $clinics = Clinic::all();
        return view('dashboard.edit_doctor', compact('doctor', 'specializations', 'clinics'));
    }

    // update doctor
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $doctor = $user->doctor;

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile_number' => 'required|string|max:20|unique:users,mobile_number,' . $user->id,
            'phone_code' => 'required|string|max:3',
            'specialization' => 'required|exists:specializations,id',
            'birthdate' => 'nullable|date',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'clinic' => 'required|exists:clinics,id',
            'bio' => 'required|string',
            'profile_photo' => 'nullable|image',
            'session_price' => 'required|numeric|min:0',
            'clinic_address' => 'nullable|string',
            'license_number' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Handle profile photo
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('doctors', 'public');
            $user->profile_photo = $data['profile_photo'];
        }

        // Update User info
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_number' => $data['mobile_number'],
            'phone_code' => $data['phone_code'],
            'birthdate' => $data['birthdate'] ?? $user->birthdate,
            'latitude' => $data['latitude'] ?? $user->latitude,
            'longitude' => $data['longitude'] ?? $user->longitude,
        ]);

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
            $user->save();
        }

        // Update Doctor info
        $doctor->update([
            'specialization_id' => $data['specialization'],
            'clinic_id' => $data['clinic'],
            'bio' => $data['bio'],
            'session_price' => $data['session_price'],
            'clinic_address' => $data['clinic_address'] ?? $doctor->clinic_address,
            'license_number' => $data['license_number'],
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor updated successfully');
    }
    // index clinics
    public function indexClinic()
    {
        $clinics = Clinic::all();
        return view('clinics.index', compact('clinics'));
    }

    // create clinic
    public function createClinic()
    {
        return view('clinics.clinic');
    }
    // store clinic
    public function storeClinic(Request $request)
    {
        $data = $request->validate([
            'name_clinic' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Clinic::create($data);
        return redirect()->route('admin.doctors.index-clinic')
            ->with('success', 'Clinic created successfully');
    }
    // edit clinic
    public function editClinic($id)
    {
        $clinic = Clinic::findOrFail($id);
        return view('clinics.edit', compact('clinic'));
    }
    // update clinic
    public function updateClinic(Request $request, $id)
    {
        $clinic = Clinic::findOrFail($id);
        $data = $request->validate([
            'name_clinic' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        $clinic->update($data);
        return redirect()->route('admin.doctors.index-clinic')
            ->with('success', 'Clinic updated successfully');
    }
    // delete clinic
    public function destroyClinic($id)
    {
        $clinic = Clinic::findOrFail($id);
        $clinic->delete();
        return redirect()->route('admin.doctors.index-clinic')
            ->with('success', 'Clinic deleted successfully');
    }
    // index specializations
    public function indexSpecialization()
    {
        $specializations = Specialization::all();
        return view('specialization.index', compact('specializations'));
    }

    // create specialization
    public function createSpecialization()
    {
        return view('specialization.specialization');
    }
    // store specialization
    public function storeSpecialization(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Specialization::create($data);
        return redirect()->route('admin.doctors.index-specialization')->with('success', 'Specialization created successfully');
    }
    // edit specialization
    public function editSpecialization($id)
    {
        $specialization = Specialization::findOrFail($id);
        return view('specialization.edit', compact('specialization'));
    }
    // update specialization
    public function updateSpecialization(Request $request, $id)
    {
        $specialization = Specialization::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $specialization->update($data);
        return redirect()->route('admin.doctors.index-specialization')->with('success', 'Specialization updated successfully');
    }
    // delete specialization
    public function destroySpecialization($id)
    {
        $specialization = Specialization::findOrFail($id);
        $specialization->delete();
        return redirect()->route('admin.doctors.index-specialization')->with('success', 'Specialization deleted successfully');
    }
}
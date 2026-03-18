@extends('layouts.dashboard')
@section('title', 'Edit Doctor')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
                <div class="flex-grow-1">
                    <h3 class="mb-2 text-size-26 text-color-2">Edit Doctor</h3>
                </div>
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-primary">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div><!-- end card header -->
        </div>
        <!--end col-->
    </div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
 <!-- display form containe the data fo doctor to edit it 
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
 -->
<div class="mt-4 d-flex align-items-center justify-content-center">
    <div class="col-md-8 col-12">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body bg-white p-4">
                <h4 class="text-color-2 fw-bold mb-4">Edit Doctor Details</h4>

                <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="col-md-6">
                        <label for="doctorName" class="form-label fw-semibold">Doctor Name</label>
                        <input type="text" name="name" class="form-control" id="doctorName" placeholder="e.g. Dr. John Doe" value="{{ old('name', $doctor->name) }}">
                        @error('name')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="doctorEmail" class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" id="doctorEmail" placeholder="doctor@example.com" value="{{ old('email', $doctor->email) }}">
                        @error('email')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Mobile Number -->
                    <div class="col-md-6">
                        <label for="doctorPhone" class="form-label fw-semibold">Phone Number</label>
                        <input type="text" name="mobile_number" class="form-control" id="doctorPhone" placeholder="0101234567" value="{{ old('mobile_number', $doctor->mobile_number) }}">
                        @error('mobile_number')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Phone Code -->
                    <div class="col-md-6">
                        <label for="doctorPhoneCode" class="form-label fw-semibold">Phone Code</label>
                        <input type="text" name="phone_code" class="form-control" id="doctorPhoneCode" placeholder="+20" value="{{ old('phone_code', $doctor->phone_code) }}">
                        @error('phone_code')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Birthdate -->
                    <div class="col-md-6">
                        <label for="doctorBirthdate" class="form-label fw-semibold">Birthdate</label>
                        <input type="date" name="birthdate" class="form-control" id="doctorBirthdate" value="{{ old('birthdate', $doctor->birthdate) }}">
                        @error('birthdate')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Specialization -->
                    <div class="col-md-6">
                        <label for="doctorSpecialization" class="form-label fw-semibold">Specialization</label>
                        <select name="specialization" id="doctorSpecialization" class="form-select">
                            <option value="">Choose specialization</option>
                            @foreach ($specializations as $specialization)
                                <option value="{{ $specialization->id }}" {{ (old('specialization', $doctor->doctor->specialization_id) == $specialization->id) ? 'selected' : '' }}>
                                    {{ $specialization->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('specialization')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Clinic -->
                    <div class="col-md-6">
                        <label for="doctorClinic" class="form-label fw-semibold">Clinic</label>
                        <select name="clinic" id="doctorClinic" class="form-select">
                            <option value="">Choose clinic</option>
                            @foreach ($clinics as $clinic)
                                <option value="{{ $clinic->id }}" {{ (old('clinic', $doctor->doctor->clinic_id) == $clinic->id) ? 'selected' : '' }}>
                                    {{ $clinic->name_clinic }}
                                </option>
                            @endforeach
                        </select>
                        @error('clinic')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Clinic Address -->
                    <div class="col-md-6">
                        <label for="doctorClinicAddress" class="form-label fw-semibold">Clinic Address</label>
                        <input type="text" name="clinic_address" class="form-control" id="doctorClinicAddress" placeholder="Clinic address" value="{{ old('clinic_address', $doctor->doctor->clinic_address) }}">
                        @error('clinic_address')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Session Price -->
                    <div class="col-md-6">
                        <label for="doctorSessionPrice" class="form-label fw-semibold">Session Price</label>
                        <input type="number" name="session_price" class="form-control" id="doctorSessionPrice" placeholder="Session price" value="{{ old('session_price', $doctor->doctor->session_price) }}">
                        @error('session_price')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Latitude -->
                    <div class="col-md-6">
                        <label for="doctorLatitude" class="form-label fw-semibold">Latitude</label>
                        <input type="number" step="0.0001" name="latitude" class="form-control" id="doctorLatitude" placeholder="Latitude" value="{{ old('latitude', $doctor->latitude) }}">
                        @error('latitude')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Longitude -->
                    <div class="col-md-6">
                        <label for="doctorLongitude" class="form-label fw-semibold">Longitude</label>
                        <input type="number" step="0.0001" name="longitude" class="form-control" id="doctorLongitude" placeholder="Longitude" value="{{ old('longitude', $doctor->longitude) }}">
                        @error('longitude')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- License Number -->
                    <div class="col-md-6">
                        <label for="doctorLicenseNumber" class="form-label fw-semibold">License Number</label>
                        <input type="text" name="license_number" class="form-control" id="doctorLicenseNumber" placeholder="License number" value="{{ old('license_number', $doctor->doctor->license_number) }}">
                        @error('license_number')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Profile Image -->
                    <div class="col-md-12">
                        <label for="doctorImage" class="form-label fw-semibold">Profile Image</label>
                        @if($doctor->profile_photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $doctor->profile_photo) }}" alt="Current Photo" class="rounded shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" name="profile_photo" id="doctorImage" class="form-control">
                        <small class="text-muted">Leave blank to keep existing image</small>
                        @error('profile_photo')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Biography -->
                    <div class="col-12">
                        <label for="doctorBio" class="form-label fw-semibold">Biography</label>
                        <textarea name="bio" class="form-control" id="doctorBio" rows="4">{{ old('bio', $doctor->doctor->bio) }}</textarea>
                        @error('bio')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password Update Section -->
                    <div class="col-12 mt-4">
                        <div class="p-3 bg-light rounded shadow-sm border">
                            <h6 class="fw-bold mb-3 text-color-2">Change Password <small class="text-muted fw-normal">(Optional)</small></h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="doctorPassword" class="form-label small fw-semibold">New Password</label>
                                    <input type="password" name="password" class="form-control" id="doctorPassword" placeholder="Enter new password">
                                    @error('password')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="doctorPasswordConfirmation" class="form-label small fw-semibold">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="doctorPasswordConfirmation" placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 mt-4 text-center">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm" style="border-radius: 8px;">Update Doctor Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
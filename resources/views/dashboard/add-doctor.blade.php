@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-color-2">Add Doctor</h3>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 d-flex align-items-center justify-content-center">
    <div class="col-md-8 col-12">
        <div class="card-body bg-white p-3">
            <h2 class="h5 text-color-2 py-2">Create Doctor</h2>

            <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf

                <!-- Name -->
                <div class="col-md-6">
                    <label for="doctorName" class="form-label">Doctor Name</label>
                    <input type="text" name="name" class="form-control" id="doctorName" placeholder="e.g. Dr. John Doe" value="{{ old('name') }}">
                    @error('name')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label for="doctorEmail" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="doctorEmail" placeholder="doctor@example.com" value="{{ old('email') }}">
                    @error('email')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Mobile Number -->
                <div class="col-md-6">
                    <label for="doctorPhone" class="form-label">Phone Number</label>
                    <input type="text" name="mobile_number" class="form-control" id="doctorPhone" placeholder="0101234567" value="{{ old('mobile_number') }}">
                    @error('mobile_number')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Phone Code -->
                <div class="col-md-6">
                    <label for="doctorPhoneCode" class="form-label">Phone Code</label>
                    <input type="text" name="phone_code" class="form-control" id="doctorPhoneCode" placeholder="+20" value="{{ old('phone_code') }}">
                    @error('phone_code')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Birthdate -->
                <div class="col-md-6">
                    <label for="doctorBirthdate" class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control" id="doctorBirthdate" value="{{ old('birthdate') }}">
                    @error('birthdate')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Specialization -->
                <div class="col-md-6">
                    <label for="doctorSpecialization" class="form-label">Specialization</label>
                    <select name="specialization" id="doctorSpecialization" class="form-select">
                        <option value="">Choose specialization</option>
                        @foreach ($specializations as $specialization)
                            <option value="{{ $specialization->id }}" {{ old('specialization') == $specialization->id ? 'selected' : '' }}>
                                {{ $specialization->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('specialization')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Clinic -->
                <div class="col-md-6">
                    <label for="doctorClinic" class="form-label">Clinic</label>
                    <select name="clinic" id="doctorClinic" class="form-select">
                        <option value="">Choose clinic</option>
                        @foreach ($clinics as $clinic)
                            <option value="{{ $clinic->id }}" {{ old('clinic') == $clinic->id ? 'selected' : '' }}>
                                {{ $clinic->name_clinic }}
                            </option>
                        @endforeach
                    </select>
                    @error('clinic')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Clinic Address -->
                <div class="col-md-6">
                    <label for="doctorClinicAddress" class="form-label">Clinic Address</label>
                    <input type="text" name="clinic_address" class="form-control" id="doctorClinicAddress" placeholder="Clinic address" value="{{ old('clinic_address') }}">
                    @error('clinic_address')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Session Price -->
                <div class="col-md-6">
                    <label for="doctorSessionPrice" class="form-label">Session Price</label>
                    <input type="number" name="session_price" class="form-control" id="doctorSessionPrice" placeholder="Session price" value="{{ old('session_price') }}">
                    @error('session_price')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Latitude -->
                <div class="col-md-6">
                    <label for="doctorLatitude" class="form-label">Latitude</label>
                    <input type="number" step="0.0001" name="latitude" class="form-control" id="doctorLatitude" placeholder="Latitude" value="{{ old('latitude') }}">
                    @error('latitude')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Longitude -->
                <div class="col-md-6">
                    <label for="doctorLongitude" class="form-label">Longitude</label>
                    <input type="number" step="0.0001" name="longitude" class="form-control" id="doctorLongitude" placeholder="Longitude" value="{{ old('longitude') }}">
                    @error('longitude')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- License Number -->
                <div class="col-md-6">
                    <label for="doctorLicenseNumber" class="form-label">License Number</label>
                    <input type="text" name="license_number" class="form-control" id="doctorLicenseNumber" placeholder="License number" value="{{ old('license_number') }}">
                    @error('license_number')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Profile Image -->
                <div class="col-md-6">
                    <label for="doctorImage" class="form-label">Profile Image</label>
                    <input type="file" name="profile_photo" id="doctorImage" class="form-control">
                    @error('profile_photo')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Biography -->
                <div class="col-12">
                    <label for="doctorBio" class="form-label">Biography</label>
                    <textarea name="bio" class="form-control" id="doctorBio" rows="4">{{ old('bio') }}</textarea>
                    @error('bio')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <label for="doctorPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="doctorPassword" placeholder="Enter password">
                    @error('password')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Password Confirmation -->
                <div class="col-md-6">
                    <label for="doctorPasswordConfirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="doctorPasswordConfirmation" placeholder="Confirm password">
                </div>

                <!-- Hidden Role -->
                <input type="hidden" name="role" value="doctor">

                <!-- Submit Button -->
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100">Save Doctor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
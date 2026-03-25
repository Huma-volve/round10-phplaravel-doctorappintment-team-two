@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="flex-grow-1 mt-3">
            <h3 class="mb-4 text-size-26 text-color-2">My Profile</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Column: Avatar and Basic Section -->
                        <div class="col-xl-3 col-lg-4 text-center border-end-xl">
                            <div class="mb-3 position-relative d-inline-block">
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Avatar" class="rounded-pill shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                                @else
                                    <div class="rounded-pill bg-light d-flex align-items-center justify-content-center shadow-sm mx-auto" style="width: 150px; height: 150px; border: 4px solid #fff;">
                                        <span class="display-4 text-primary fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h5 class="fw-bold text-dark mt-2 mb-0">{{ $user->name }}</h5>
                            <p class="text-muted text-uppercase small fw-semibold">{{ $user->role }}</p>
                            
                            <div class="mt-4 text-start">
                                <label for="profile_photo" class="form-label small fw-bold text-secondary">Change Profile Photo</label>
                                <input type="file" name="profile_photo" id="profile_photo" class="form-control form-control-sm">
                                @error('profile_photo') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Right Column: Form Fields -->
                        <div class="col-xl-9 col-lg-8 ps-xl-5 mt-4 mt-lg-0">
                            <h6 class="fw-bold text-color-2 mb-4"><i class="fa-solid fa-user-gear me-2"></i>Basic Information</h6>
                            
                            <div class="row g-3 mb-5">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                    @error('name') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    @error('email') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Phone Number</label>
                                    <div class="input-group">
                                        <input type="text" name="phone_code" class="form-control" style="max-width: 80px;" value="{{ old('phone_code', $user->phone_code) }}" required>
                                        <input type="text" name="mobile_number" class="form-control" value="{{ old('mobile_number', $user->mobile_number) }}" required>
                                    </div>
                                    @error('mobile_number') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Birthdate</label>
                                    <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $user->birthdate) }}">
                                    @error('birthdate') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Latitude</label>
                                    <input type="number" step="0.000001" name="latitude" class="form-control" value="{{ old('latitude', $user->latitude) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Longitude</label>
                                    <input type="number" step="0.000001" name="longitude" class="form-control" value="{{ old('longitude', $user->longitude) }}">
                                </div>
                            </div>

                            @if($user->role === 'doctor')
                                <hr class="my-5 opacity-10">
                                <h6 class="fw-bold text-color-2 mb-4"><i class="fa-solid fa-stethoscope me-2"></i>Professional Information</h6>
                                
                                <div class="row g-3 mb-5">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">Specialization</label>
                                        <select name="specialization" class="form-select">
                                            @foreach($specializations as $spec)
                                                <option value="{{ $spec->id }}" {{ old('specialization', $user->doctor->specialization_id) == $spec->id ? 'selected' : '' }}>
                                                    {{ $spec->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">Clinic</label>
                                        <select name="clinic" class="form-select">
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}" {{ old('clinic', $user->doctor->clinic_id) == $clinic->id ? 'selected' : '' }}>
                                                    {{ $clinic->name_clinic }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">Session Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="session_price" class="form-control" value="{{ old('session_price', $user->doctor->session_price) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">License Number</label>
                                        <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $user->doctor->license_number) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-secondary">Clinic Address</label>
                                        <textarea name="clinic_address" class="form-control" rows="2">{{ old('clinic_address', $user->doctor->clinic_address) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-secondary">Biography</label>
                                        <textarea name="bio" class="form-control" rows="4">{{ old('bio', $user->doctor->bio) }}</textarea>
                                    </div>
                                </div>
                            @endif

                            <hr class="my-5 opacity-10">
                            <h6 class="fw-bold text-color-2 mb-4"><i class="fa-solid fa-lock me-2"></i>Change Password <small class="text-muted fw-normal">(Optional)</small></h6>
                            
                            <div class="row g-3 mb-5">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">New Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" autocomplete="new-password">
                                    @error('password') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm" style="border-radius: 8px;">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

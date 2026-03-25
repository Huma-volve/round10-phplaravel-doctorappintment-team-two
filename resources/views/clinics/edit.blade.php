@extends('layouts.dashboard')

@section('title', 'Chat')

@section('content')
<!-- 
id
name_clinic
phone
address
latitude
longitude
created_at
updated_at
i want to edit clicns make for mwith the aprofesional design plaese

-->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom py-3" style="border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h4 class="card-title mb-0 fw-bold text-dark">Edit Clinic</h4>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.doctors.update-clinic', $clinic->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="name_clinic" class="form-label fw-semibold text-secondary small text-uppercase mb-2">Clinic Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="far fa-building text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" id="name_clinic" name="name_clinic" value="{{ old('name_clinic', $clinic->name_clinic) }}" required>
                                </div>
                                @error('name_clinic') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="phone" class="form-label fw-semibold text-secondary small text-uppercase mb-2">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone-alt text-muted"></i></span>
                                    <input type="tel" class="form-control bg-light border-start-0 ps-0" id="phone" name="phone" value="{{ old('phone', $clinic->phone) }}">
                                </div>
                                @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="address" class="form-label fw-semibold text-secondary small text-uppercase mb-2">Full Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" id="address" name="address" value="{{ old('address', $clinic->address) }}">
                                </div>
                                @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="latitude" class="form-label fw-semibold text-secondary small text-uppercase mb-2">Latitude</label>
                                <input type="text" class="form-control bg-light" id="latitude" name="latitude" value="{{ old('latitude', $clinic->latitude) }}">
                                @error('latitude') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="longitude" class="form-label fw-semibold text-secondary small text-uppercase mb-2">Longitude</label>
                                <input type="text" class="form-control bg-light" id="longitude" name="longitude" value="{{ old('longitude', $clinic->longitude) }}">
                                @error('longitude') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <a href="{{ route('admin.doctors.index-clinic') }}" class="btn btn-light px-4 me-md-2 fw-semibold">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 fw-semibold shadow-sm">Update Clinic</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

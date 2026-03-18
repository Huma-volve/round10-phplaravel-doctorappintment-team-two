@extends('layouts.dashboard')

@section('title', 'Edit Specialization')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom py-3" style="border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h4 class="card-title mb-0 fw-bold text-dark">Edit Specialization</h4>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.doctors.update-specialization', $specialization->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-secondary small text-uppercase mb-2">Specialization Name</label>
                            <input type="text" class="form-control bg-light p-3" id="name" name="name" value="{{ old('name', $specialization->name) }}" required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.doctors.index-specialization') }}" class="btn btn-light px-4 me-md-2 fw-semibold">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 fw-semibold shadow-sm">Update Specialization</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

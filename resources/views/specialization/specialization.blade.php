@extends('layouts.dashboard')

@section('title', 'Chat')

@section('content')
<!-- 

make a pfrofessional form to create specialization

-->
<div class="container py-5">
    <!-- display success mesage -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom py-3" style="border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-clinic-medical"></i>
                        </div>
                        <h4 class="card-title mb-0 fw-bold text-dark">Add New Specialization</h4>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.doctors.store-specialization') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="name" class="form-label fw-semibold text-secondary small text-uppercase mb-2">Specialization Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-clinic-medical text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" id="name" name="name" placeholder="e.g. Cardiology" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button type="submit" class="btn btn-primary px-5 fw-semibold shadow-sm">Save Specialization</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

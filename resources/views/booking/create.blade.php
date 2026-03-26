@extends('layouts.dashboard')

@section('content')

<div class="container py-5">

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                
                {{-- Header --}}
                <div class="card-header bg-white py-3 border-0">
                    <h4 class="fw-bold mb-0 text-primary">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Book Appointment
                    </h4>
                </div>

                {{-- Body --}}
                <div class="card-body p-4">

                    <form action="{{ route('admin.booking.store')}}" method="POST">
                        @csrf

                        <div class="row">

                            {{-- Patient --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Patient</label>
                                <select name="patient_id" class="form-control">
                                    <option value="">Select Patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">
                                            {{ $patient->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Doctor --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Doctor</label>
                                <select name="doctor_id" class="form-control">
                                    <option value="">Select Doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">
                                            Dr. {{ $doctor->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Appointment Time --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Appointment Time</label>
                                <input type="datetime-local" 
                                       name="appointment_time" 
                                       class="form-control">
                            </div>

                            {{-- Payment Method --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Payment Method</label>
                                <select name="payment_method" class="form-control">
                                    <option value="stripe">Stripe</option>
                                </select>
                            </div>

                        </div>

                        {{-- Submit --}}
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                                <i class="fas fa-check me-1"></i>
                                Confirm Booking
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
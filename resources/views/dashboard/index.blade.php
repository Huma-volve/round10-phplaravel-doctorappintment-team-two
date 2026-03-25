@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mt-3">
            <div>
                <h3 class="mb-1 text-color-2 fw-bold">Dashboard Overview</h3>
                <p class="text-muted small mb-0">Welcome back! Here's what's happening today.</p>
            </div>
            <div class="d-none d-md-block">
                <span class="badge bg-light text-color-1 p-2 border">
                    <i class="far fa-calendar-alt me-1"></i> {{ date('D, M d, Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Total Users -->
    <div class="col-12 col-md-6 col-lg-3 mb-4">
        <div class="stats-card p-4 bg-white shadow-sm border-0 h-100" style="border-radius: 15px; border-left: 5px solid #7256C5 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small fw-bold text-uppercase mb-1">Total Users</p>
                    <h2 class="fw-bold mb-0 text-color-2">{{ $users->count() }}</h2>
                </div>
                <div class="icon-wrapper icon-purple rounded-circle p-3 bg-light-purple text-purple">
                    <i class="fas fa-users fa-lg"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-success small fw-bold"><i class="fas fa-arrow-up me-1"></i> Active Platform</span>
            </div>
        </div>
    </div>
    <!-- Total Patients -->
    <div class="col-12 col-md-6 col-lg-3 mb-4">
        <div class="stats-card p-4 bg-white shadow-sm border-0 h-100" style="border-radius: 15px; border-left: 5px solid #FD4E5D !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small fw-bold text-uppercase mb-1">Total Patients</p>
                    <h2 class="fw-bold mb-0 text-color-2">{{ $patientsCount }}</h2>
                </div>
                <div class="icon-wrapper icon-red rounded-circle p-3 bg-light-red text-red">
                    <i class="fas fa-user-injured fa-lg"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-primary small fw-bold">Recent Signups</span>
            </div>
        </div>
    </div>
    <!-- Total Doctors -->
    <div class="col-12 col-md-6 col-lg-3 mb-4">
        <div class="stats-card p-4 bg-white shadow-sm border-0 h-100" style="border-radius: 15px; border-left: 5px solid #43A9D4 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small fw-bold text-uppercase mb-1">Total Doctors</p>
                    <h2 class="fw-bold mb-0 text-color-2">{{ $doctorsCount }}</h2>
                </div>
                <div class="icon-wrapper icon-blue rounded-circle p-3 bg-light-blue text-blue">
                    <i class="fas fa-user-md fa-lg"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-info small fw-bold">Verified Professionals</span>
            </div>
        </div>
    </div>
    <!-- Total Appointments -->
    <div class="col-12 col-md-6 col-lg-3 mb-4">
        <div class="stats-card p-4 bg-white shadow-sm border-0 h-100" style="border-radius: 15px; border-left: 5px solid #68D137 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small fw-bold text-uppercase mb-1">Appointments</p>
                    <h2 class="fw-bold mb-0 text-color-2">{{ $appointmentsCount }}</h2>
                </div>
                <div class="icon-wrapper icon-green rounded-circle p-3 bg-light-green text-green">
                    <i class="fas fa-calendar-check fa-lg"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> Overall</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <!-- Left Column: Recent Appointments & Traffic -->
    <div class="col-lg-8 mb-4">
        <!-- Recent Appointments Table -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-color-2">Recent Appointments</h5>
                <a href="#" class="text-primary small fw-bold">View History</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 border-0">Patient</th>
                                <th class="border-0">Doctor</th>
                                <th class="border-0">Time</th>
                                <th class="border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appointment)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm rounded-circle bg-light text-primary d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                            {{ strtoupper(substr($appointment->patient->user->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-color-2">{{ $appointment->patient->user->name ?? 'Unknown' }}</div>
                                            <div class="text-muted extra-small" style="font-size: 10px;">ID: #{{ $appointment->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-color-1 small fw-medium">Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div class="small fw-semibold">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('M d, H:i') }}</div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'completed' => 'success',
                                            'pending'   => 'warning',
                                            'cancelled' => 'danger'
                                        ][strtolower($appointment->Status)] ?? 'info';
                                    @endphp
                                    <span class="badge rounded-pill bg-{{ $statusClass }} py-1 px-3" style="font-size: 10px;">{{ ucfirst($appointment->Status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No recent appointments found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Traffic/Platform Stats Row -->
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-color-2">Platform Distribution</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center">
                        <div class="chart-container d-inline-block" style="width: 180px; height: 180px;">
                            <canvas id="trafficChart" 
                                data-patients="{{ $patientsCount }}"
                                data-doctors="{{ $doctorsCount }}"
                                data-appointments="{{ $appointmentsCount }}">
                            </canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <div class="traffic-legend px-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-2" style="width: 12px; height: 12px; background: #43A9D4;"></div>
                                    <span class="text-color-1 small fw-medium">Patients</span>
                                </div>
                                <span class="text-color-2 fw-bold small">{{ $patientsCount }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-2" style="width: 12px; height: 12px; background: #68D137;"></div>
                                    <span class="text-color-1 small fw-medium">Doctors</span>
                                </div>
                                <span class="text-color-2 fw-bold small">{{ $doctorsCount }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-2" style="width: 12px; height: 12px; background: #7256C5;"></div>
                                    <span class="text-color-1 small fw-medium">Appointments</span>
                                </div>
                                <span class="text-color-2 fw-bold small">{{ $appointmentsCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Top Doctors & Quick Actions -->
    <div class="col-lg-4 mb-4">
        <!-- Top Doctors List -->
        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-color-2">Featured Doctors</h5>
                <a href="{{ route('admin.doctors.index') }}" class="text-primary small fw-bold">View All</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush px-2">
                    @foreach ($doctors as $doctor)
                    <li class="list-group-item d-flex align-items-center py-3 border-0 mb-1 rounded" style="transition: all 0.2s;">
                        <div class="avatar-md rounded bg-light text-primary d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 45px; height: 45px; border-radius: 12px !important;">
                            <i class="fas fa-user-md fa-lg"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold text-color-2">Dr. {{ $doctor->user->name }}</h6>
                            <small class="text-primary fw-medium">{{ $doctor->specialization->name ?? 'Specialist' }}</small>
                            <div class="text-muted extra-small mt-1" style="font-size: 10px;">
                                <i class="fas fa-hospital me-1"></i> {{ $doctor->clinic->name_clinic ?? 'Private Clinic' }}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-light text-success border-success-subtle p-2">
                                <i class="fas fa-star small"></i> 4.8
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer bg-white border-0 py-3 text-center">
                <p class="text-muted small mb-0">Updated every 5 minutes</p>
            </div>
        </div>
    </div>
</div>
@endsection

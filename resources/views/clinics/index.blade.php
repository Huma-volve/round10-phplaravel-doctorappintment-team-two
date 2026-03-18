@extends('layouts.dashboard')

@section('title', 'Clinics')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Clinics Management</h3>
            </div>
            <a href="{{ route('admin.doctors.create-clinic') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add New Clinic
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif

<div class="mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive" style="border-radius: 12px;">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Clinic Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Coordinates</th>
                            <th class="text-center">Edit</th>
                            <!-- <th class="text-center">Delete</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clinics as $clinic)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">{{ $clinic->name_clinic }}</td>
                            <td>{{ $clinic->phone }}</td>
                            <td><span class="text-muted small">{{ $clinic->address }}</span></td>
                            <td>
                                <span class="badge bg-light text-secondary border">Lat: {{ $clinic->latitude }}</span>
                                <span class="badge bg-light text-secondary border">Lng: {{ $clinic->longitude }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.doctors.edit-clinic', $clinic->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                            </td>
                            <!-- <td class="text-center">
                                <form action="{{ route('admin.doctors.destroy-clinic', $clinic->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this clinic?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td> -->
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No clinics found. Start by adding one!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

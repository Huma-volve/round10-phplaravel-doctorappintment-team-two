@extends('layouts.dashboard')

@section('title', 'Doctors')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Doctors</h3>
            </div>
            <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add Doctor
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
<div class="mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive table-rounded-top">
                <table class="table align-middle">
                    <thead>
                        <tr>

                            <th>Name</th>
                            <th>Email</th>
                            <th>Specialization</th>
                            <th>Mobile Number</th>
                            <th>Phone Code</th>
                            <th class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                            <th class="text-center"><i class="fas fa-edit"></i></th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->user->name }}</td>
                            <td>{{ $doctor->user->email }}</td>
                            <td>{{ $doctor->specialization->name }}</td>
                            <td>{{ $doctor->user->mobile_number }}</td>
                            <td>{{ $doctor->user->phone_code }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this doctor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="my-3 w-100 d-flex justify-content-center">
                    <!-- Pagination removed -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
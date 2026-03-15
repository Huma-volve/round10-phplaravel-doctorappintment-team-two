@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">DataTable</h3>
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<div class="mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-3">
            <h4 class="h3">DataTable</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="datatable">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3">ID</th>
                            <th scope="col" class="py-3">Name</th>
                            <th scope="col" class="py-3">Email</th>
                            <th scope="col" class="py-3">Phone</th>
                            <th scope="col" class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= 5; $i++)
                        <tr>
                            <td>#1259{{ $i }}</td>
                            <td>User {{ $i }}</td>
                            <td>user{{ $i }}@example.com</td>
                            <td>123456789{{ $i }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="nav-link px-3 pt-1 pb-2 text-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item py-2" href="#">Edit</a></li>
                                        <li><a class="dropdown-item py-2" href="#">Delete</a></li>
                                        <li><a class="dropdown-item py-2" href="#">Block</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div> 
    </div> 
</div>
@endsection

@push('scripts')
<script src="{{ asset('dashboard-assets/plugin/datatable/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>
@endpush
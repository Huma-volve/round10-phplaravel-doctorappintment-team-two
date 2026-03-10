@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Students</h3>
            </div>
            <div class="mt-3 mt-lg-0">
                <div class="d-flex align-items-center">
                </div>
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<div class="mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive table-rounded-top">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Location</th>
                            <th class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Static Row 1 -->
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <img src="{{asset('dashboard-assets/images/avatar-1.jpg')}}" class="tbl-img" alt="">
                                    <span class="ms-2">Adin Lauren</span>
                                </div>
                            </td>
                            <td>adin@example.com</td>
                            <td>+1 234 567 890</td>
                            <td>123 Street, New York</td>
                            <td>USA</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        <!-- Static Row 2 -->
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <img src="{{asset('dashboard-assets/images/avatar-2.jpg')}}" class="tbl-img" alt="">
                                    <span class="ms-2">John Doe</span>
                                </div>
                            </td>
                            <td>john@example.com</td>
                            <td>+1 987 654 321</td>
                            <td>456 Avenue, London</td>
                            <td>UK</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        <!-- Static Row 3 -->
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <img src="{{asset('dashboard-assets/images/avatar-3.jpg')}}" class="tbl-img" alt="">
                                    <span class="ms-2">Jane Smith</span>
                                </div>
                            </td>
                            <td>jane@example.com</td>
                            <td>+1 555 123 456</td>
                            <td>789 Road, Sydney</td>
                            <td>Australia</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-100 d-flex justify-content-center mb-3">
                <!-- Pagination links removed -->
            </div>
        </div>
    </div>
</div>
@endsection
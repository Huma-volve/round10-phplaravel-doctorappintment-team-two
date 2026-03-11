@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Teacher</h3>
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
                            <th>Specialization</th>
                            <th class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Static Row 1 -->
                        <tr>
                            <td>Adin Lauren</td>
                            <td>adin@example.com</td>
                            <td>Web Development</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Static Row 2 -->
                        <tr>
                            <td>Ashley Lawson</td>
                            <td>ashley@softnio.com</td>
                            <td>Digital Marketing</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Static Row 3 -->
                        <tr>
                            <td>Jane Montgomery</td>
                            <td>jane84@example.com</td>
                            <td>UI/UX Design</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
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
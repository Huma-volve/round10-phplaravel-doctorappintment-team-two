@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-color-2">Courses</h3>
            </div>
            <div class="mt-3 mt-lg-0">
                <div class="d-flex align-items-center">                                
                    <!-- Reports Button -->
                    <a href="{{route('add-course')}}" class="cursor-pointer ms-4 bg-white bg-primary text-white d-flex align-items-center px-3 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">
                        <i class="fa-solid fa-plus me-3"></i>
                        Add Course
                    </a>
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
                            <th>Image</th> 
                            <th>Course Name</th>
                            <th>Category</th>
                            <th>Instructor</th>
                            <th>Price</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Static Row 1 -->
                        <tr>
                            <td><img src="{{asset('dashboard-assets/images/technology.jpg')}}" alt="" style="width:60px;height:60px" class="img-fluid rounded-2"></td>
                            <td>Web Development Masterclass</td>
                            <td>Web Development</td>
                            <td>Adin Lauren</td>
                            <td>$ 99.00</td>
                            <td class="">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="{{route('course-details')}}" class="btn btn-sm btn-info me-2"><i class="fa-solid fa-eye"></i></a>
                                    <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Static Row 2 -->
                        <tr>
                            <td><img src="{{asset('dashboard-assets/images/technology.jpg')}}" alt="" style="width:60px;height:60px" class="img-fluid rounded-2"></td>
                            <td>Digital Marketing Pro</td>
                            <td>Marketing</td>
                            <td>Ashley Lawson</td>
                            <td>$ 79.00</td>
                            <td class="">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="{{route('course-details')}}" class="btn btn-sm btn-info me-2"><i class="fa-solid fa-eye"></i></a>
                                    <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
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
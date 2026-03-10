@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Staff</h3>
            </div>
            <div class="mt-3 mt-lg-0">
                <div class="d-flex align-items-center">
                    <div class="cursor-pointer bg-white d-flex align-items-center text-color-1 px-3 py-2 rounded-2 text-normal fw-bolder letter-spacing-26 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-filter me-3"></i>
                        Filter by
                        <i class="fa-solid fa-chevron-right ms-3 text-size-sm"></i>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Active</a></li>
                            <li><a class="dropdown-item" href="#">Inactive</a></li>
                        </ul>
                    </div>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#CreateModal" class="cursor-pointer ms-4 bg-white bg-primary text-white d-flex align-items-center px-3 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">
                        <i class="fa-solid fa-plus me-3"></i>
                        Add Staff
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
                            <th><input type="checkbox" id="select-all" class="custom-checkbox"></th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $staffs = [
                                ['Roger', 'roger@example.com', '9865874587', 'Developer', 'Active', 'success', 'avatar-1.jpg'],
                                ['Michael', 'michael@example.com', '9869852145', 'Designer', 'Active', 'success', 'avatar-2.jpg'],
                                ['Sarah', 'sarah@example.com', '9823456712', 'Manager', 'Active', 'success', 'avatar-3.jpg'],
                                ['Emma', 'emma@example.com', '9845623214', 'HR', 'Inactive', 'warning', 'avatar-4.jpg'],
                                ['Chris', 'chris@example.com', '9823456231', 'Team Lead', 'Active', 'success', 'avatar-5.jpg'],
                                ['Olivia', 'olivia@example.com', '9876543210', 'Support', 'Active', 'success', 'avatar-1.jpg'],
                                ['Liam', 'liam@example.com', '9871234567', 'Marketing', 'Inactive', 'warning', 'avatar-2.jpg'],
                                ['Charlotte', 'charlotte@example.com', '9812345678', 'Consultant', 'Active', 'success', 'avatar-3.jpg'],
                                ['Elijah', 'elijah@example.com', '9865321478', 'Analyst', 'Active', 'success', 'avatar-4.jpg'],
                                ['Sophia', 'sophia@example.com', '9823145670', 'Executive', 'Active', 'success', 'avatar-5.jpg']
                            ];
                        @endphp
                        @foreach ($staffs as $staff)
                        <tr>
                            <td><input type="checkbox" class="custom-checkbox row-checkbox"></td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <img src="{{ asset('dashboard-assets/images/' . $staff[6]) }}" class="tbl-img" alt="">
                                </div>
                            </td>
                            <td>{{ $staff[0] }}</td>
                            <td>{{ $staff[1] }}</td>
                            <td>{{ $staff[2] }}</td>
                            <td>{{ $staff[3] }}</td>
                            <td><span class="badge bg-{{ $staff[5] }}">{{ $staff[4] }}</span></td>
                            <td class="text-center">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#EditModal" class="btn btn-sm btn-primary mb-2 mb-lg-0 me-0 me-lg-2"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>                            
            </div>

            <div class="pb-3 ps-3 mt-3 d-flex justify-content-center justify-content-md-between justify-content-lg-between flex-wrap flex-md-nowrap">
                <nav aria-label="Page navigation" class="mb-3 mb-md-0 mb-lg-0">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous"><i class="fa-solid fa-chevron-left text-size-12"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-ellipsis-h"></i></a></li>
                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next"><i class="fa-solid fa-chevron-right text-size-12"></i></a>
                        </li>
                    </ul>
                </nav>
                <div class="d-flex justify-content-end pe-3">
                    <div class="page-selector">
                        <span>PAGE</span>
                        <select class="form-select mx-2" style="width: auto;" aria-label="Select page">
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        <span>OF 10</span>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</div>

<!--Create Modal -->
<div class="modal fade" id="CreateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content rounded-0">
            <div class="modal-body p-4 position-relative">
                <button type="button" class="btn position-absolute end-1" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                <h2 class="h5 text-color-2 py-2">Create Staff</h2>
                <form class="row g-3" action="#" method="POST">
                    <div class="col-12">
                        <label for="UserName" class="form-label text-color-2 text-normal">Name</label>
                        <input type="text" class="form-control" id="UserName" placeholder="Enter name">
                    </div>
                    <div class="col-6">
                        <label for="UserEmail" class="form-label text-color-2 text-normal">Email</label>
                        <input type="email" class="form-control" id="UserEmail" placeholder="Enter email">
                    </div>
                    <div class="col-6">
                        <label for="UserMobile" class="form-label text-color-2 text-normal">Mobile</label>
                        <input type="number" class="form-control" id="UserMobile" placeholder="Enter mobile">
                    </div>
                    <div class="col-6">
                        <label for="Designation" class="form-label text-color-2 text-normal">Designation</label>
                        <input type="text" class="form-control" id="Designation" placeholder="Enter Designation">
                    </div>
                    <div class="col-6">
                        <label class="form-label text-color-2 text-normal">Profile Image</label>
                        <div class="file-input-container max-w-100">
                            <input type="file" id="fileInput" class="file-input">
                            <label for="fileInput" class="file-label">
                                <span class="file-name">Choose file</span>
                                <span class="file-button">Browse</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="Password" class="form-label text-color-2 text-normal">Password</label>
                        <input type="password" class="form-control" id="Password" placeholder="Password">
                    </div>
                    <div class="col-6">
                        <label for="ConfirmPassword" class="form-label text-color-2 text-normal">Confirm Password</label>
                        <input type="password" class="form-control" id="ConfirmPassword" placeholder="Confirm Password">
                    </div>
                    <div class="col-12 mt-5">
                        <button type="button" class="btn bg-white bg-primary text-white d-flex align-items-center px-4 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">Save Information</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Edit Modal -->
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content rounded-0">
            <div class="modal-body p-4 position-relative">
                <button type="button" class="btn position-absolute end-1" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                <h2 class="h5 text-color-2 py-2">Edit Staff</h2>
                <form class="row g-3" action="#" method="POST">
                    <div class="col-12">
                        <label for="EditUserName" class="form-label text-color-2 text-normal">Name</label>
                        <input type="text" class="form-control" id="EditUserName" placeholder="Enter name">
                    </div>
                    <div class="col-6">
                        <label for="EditUserEmail" class="form-label text-color-2 text-normal">Email</label>
                        <input type="email" class="form-control" id="EditUserEmail" placeholder="Enter email">
                    </div>
                    <div class="col-6">
                        <label for="EditUserMobile" class="form-label text-color-2 text-normal">Mobile</label>
                        <input type="number" class="form-control" id="EditUserMobile" placeholder="Enter mobile">
                    </div>
                    <div class="col-6">
                        <label for="EditDesignation" class="form-label text-color-2 text-normal">Designation</label>
                        <input type="text" class="form-control" id="EditDesignation" placeholder="Enter Designation">
                    </div>
                    <div class="col-6">
                        <label class="form-label text-color-2 text-normal">Profile Image</label>
                        <div class="file-input-container max-w-100">
                            <input type="file" id="editFileInput" class="file-input">
                            <label for="editFileInput" class="file-label">
                                <span class="file-name">Choose file</span>
                                <span class="file-button">Browse</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="EditPassword" class="form-label text-color-2 text-normal">Password</label>
                        <input type="password" class="form-control" id="EditPassword" placeholder="Password">
                    </div>
                    <div class="col-6">
                        <label for="EditConfirmPassword" class="form-label text-color-2 text-normal">Confirm Password</label>
                        <input type="password" class="form-control" id="EditConfirmPassword" placeholder="Confirm Password">
                    </div>
                    <div class="col-12 mt-5">
                        <button type="button" class="btn bg-white bg-primary text-white d-flex align-items-center px-4 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">Update Information</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
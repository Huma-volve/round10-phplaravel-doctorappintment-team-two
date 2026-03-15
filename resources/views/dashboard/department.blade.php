@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Department</h3>
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
                        Add Departments
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
                            <th>Name</th>
                            <th>Status</th>
                            <th class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $departments = ['Computer', 'Mobile', 'Books', 'Electronics', 'Fashion', 'Furniture', 'Groceries', 'Sports', 'Health', 'Accessories'];
                        @endphp
                        @foreach ($departments as $dept)
                        <tr>
                            <td><input type="checkbox" class="custom-checkbox row-checkbox"></td>
                            <td>{{ $dept }}</td>
                            <td><span class="badge bg-{{ $loop->index % 3 == 0 ? 'success' : ($loop->index % 3 == 1 ? 'danger' : 'warning') }}">{{ $loop->index % 3 == 1 ? 'Inactive' : 'Active' }}</span></td>
                            <td class="text-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#EditModal" class="btn btn-sm btn-primary mb-2 mb-lg-0 me-0 me-lg-2"><i class="fa-regular fa-pen-to-square"></i></a>
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
                <h2 class="h5 text-color-2 py-2">Create Department</h2>
                <form class="row g-3" action="#" method="POST">
                    <div class="col-12">
                        <label for="UserDepartment" class="form-label text-color-2 text-normal">Department Name</label>
                        <input type="text" class="form-control" id="UserDepartment" placeholder="Enter department name">
                    </div>
                    <div class="col-12">
                        <label for="UserStatus1" class="form-label text-color-2 text-normal">Status</label>
                        <select id="UserStatus1" class="form-select text-normal">
                            <option value="">Choose status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 mt-5">
                        <button type="button" class="btn bg-white bg-primary text-white d-flex align-items-center px-4 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">Save Informations</button>
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
                <h2 class="h5 text-color-2 py-2">Edit Department</h2>
                <form class="row g-3" action="#" method="POST">
                    <div class="col-12">
                        <label for="UserDepartment2" class="form-label text-color-2 text-normal">Department Name</label>
                        <input type="text" class="form-control" id="UserDepartment2" placeholder="Enter department name">
                    </div>
                    <div class="col-12">
                        <label for="UserStatus2" class="form-label text-color-2 text-normal">Status</label>
                        <select id="UserStatus2" class="form-select text-normal">
                            <option value="">Choose status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 mt-5">
                        <button type="button" class="btn bg-white bg-primary text-white d-flex align-items-center px-4 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">Save Informations</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
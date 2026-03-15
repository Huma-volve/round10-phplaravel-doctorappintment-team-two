@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Library</h3>
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
                        Add Library
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
                            <th>Book Name</th>
                            <th>Department</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $books = [
                                ['Computer', 'Architecture', 'Comics', 'Active', 'success'],
                                ['Data Science', 'Technology', 'Textbook', 'Active', 'success'],
                                ['Marketing 101', 'Business', 'Guide', 'Pending', 'warning'],
                                ['Intro to Physics', 'Science', 'Textbook', 'Inactive', 'danger'],
                                ['World History', 'History', 'Documentary', 'Active', 'success'],
                                ['Art for Beginners', 'Arts', 'Guide', 'Pending', 'warning'],
                                ['Python Programming', 'Technology', 'Textbook', 'Active', 'success'],
                                ['Chemistry Essentials', 'Science', 'Workbook', 'Inactive', 'danger'],
                                ['Photography Basics', 'Arts', 'Guide', 'Active', 'success'],
                                ['Economics Made Easy', 'Business', 'Textbook', 'Active', 'success']
                            ];
                        @endphp
                        @foreach ($books as $book)
                        <tr>
                            <td><input type="checkbox" class="custom-checkbox row-checkbox"></td>
                            <td>{{ $book[0] }}</td>
                            <td>{{ $book[1] }}</td>
                            <td>{{ $book[2] }}</td>
                            <td><span class="badge bg-{{ $book[4] }}">{{ $book[3] }}</span></td>
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
                        <span>OF 102</span>
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
                <h2 class="h5 text-color-2 py-2">Create Library</h2>
                <form class="row g-3" action="#" method="POST">
                    <div class="col-12">
                        <label for="BookName" class="form-label text-color-2 text-normal">Book Name</label>
                        <input type="text" class="form-control" id="BookName" placeholder="Enter book name">
                    </div>
                    <div class="col-12">
                        <label for="UserDepartment" class="form-label text-color-2 text-normal">Department</label>
                        <select id="UserDepartment" class="form-select text-normal">
                            <option value="">Choose Department</option>
                            <option value="B.tech">B.Tech</option>
                            <option value="M.Tech">M.Tech</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="UserType" class="form-label text-color-2 text-normal">Type</label>
                        <select id="UserType" class="form-select text-normal">
                            <option value="">Choose type</option>
                            <option value="B.tech">B.Tech</option>
                            <option value="M.Tech">M.Tech</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="UserStatus" class="form-label text-color-2 text-normal">Status</label>
                        <select id="UserStatus" class="form-select text-normal">
                            <option value="">Choose status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
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
                <h2 class="h5 text-color-2 py-2">Edit Library</h2>
                <form class="row g-3" action="#" method="POST">
                    <div class="col-12">
                        <label for="EditBookName" class="form-label text-color-2 text-normal">Book Name</label>
                        <input type="text" class="form-control" id="EditBookName" placeholder="Enter book name">
                    </div>
                    <div class="col-12">
                        <label for="EditUserDepartment" class="form-label text-color-2 text-normal">Department</label>
                        <select id="EditUserDepartment" class="form-select text-normal">
                            <option value="">Choose Department</option>
                            <option value="B.tech">B.Tech</option>
                            <option value="M.Tech">M.Tech</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="EditUserType" class="form-label text-color-2 text-normal">Type</label>
                        <select id="EditUserType" class="form-select text-normal">
                            <option value="">Choose type</option>
                            <option value="B.tech">B.Tech</option>
                            <option value="M.Tech">M.Tech</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="EditUserStatus" class="form-label text-color-2 text-normal">Status</label>
                        <select id="EditUserStatus" class="form-select text-normal">
                            <option value="">Choose status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
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
@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Fees</h3>
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
                        Add Fees
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
                            <th>Student Name</th>
                            <th>Roll no.</th>
                            <th>Class</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Mode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $fees = [
                                ['Roger', '01', 'V', '$98', '10-01-2024', 'cash', 'Active', 'success'],
                                ['Emily', '02', 'V', '$105', '11-01-2024', 'credit', 'Pending', 'warning'],
                                ['John', '03', 'VI', '$150', '12-01-2024', 'cash', 'Inactive', 'danger'],
                                ['Alice', '04', 'VI', '$120', '13-01-2024', 'credit', 'Active', 'success'],
                                ['Michael', '05', 'VII', '$80', '14-01-2024', 'cash', 'Pending', 'warning'],
                                ['Sarah', '06', 'VII', '$110', '15-01-2024', 'credit', 'Inactive', 'danger'],
                                ['David', '07', 'VIII', '$90', '16-01-2024', 'cash', 'Active', 'success'],
                                ['Olivia', '08', 'VIII', '$130', '17-01-2024', 'credit', 'Pending', 'warning'],
                                ['James', '09', 'IX', '$95', '18-01-2024', 'cash', 'Inactive', 'danger'],
                                ['Grace', '10', 'IX', '$105', '19-01-2024', 'credit', 'Active', 'success']
                            ];
                        @endphp
                        @foreach ($fees as $fee)
                        <tr>
                            <td>{{ $fee[0] }}</td>
                            <td>{{ $fee[1] }}</td>
                            <td>{{ $fee[2] }}</td>
                            <td>{{ $fee[3] }}</td>
                            <td>{{ $fee[4] }}</td>
                            <td>{{ $fee[5] }}</td>
                            <td><span class="badge bg-{{ $fee[7] }}">{{ $fee[6] }}</span></td>
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
                <h2 class="h5 text-color-2 py-2">Create Fees</h2>
                <form class="row g-3" action="#" method="POST">
                    <div class="col-12">
                        <label for="UserName" class="form-label text-color-2 text-normal">Student name</label>
                        <input type="text" class="form-control" id="UserName" placeholder="Enter name">
                    </div>
                    <div class="col-6">
                        <label for="UserRoll" class="form-label text-color-2 text-normal">Roll no.</label>
                        <input type="text" class="form-control" id="UserRoll" placeholder="Enter roll no.">
                    </div>
                    <div class="col-6">
                        <label for="UserClass" class="form-label text-color-2 text-normal">Class</label>
                        <input type="number" class="form-control" id="UserClass" placeholder="Enter class">
                    </div>
                    <div class="col-6">
                        <label for="fees" class="form-label text-color-2 text-normal">Amount</label>
                        <input type="text" class="form-control" id="fees" placeholder="Enter fees">
                    </div>
                    <div class="col-6">
                        <label for="UserMode" class="form-label text-color-2 text-normal">Payment mode</label>
                        <select id="UserMode" class="form-select text-normal">
                            <option value="">Choose mode</option>
                            <option value="Cash">Cash</option>
                            <option value="Online">Online</option>
                        </select>
                    </div>
                    <div class="col-12 mt-5">
                        <button type="button" class="btn bg-white bg-primary text-white d-flex align-items-center px-4 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
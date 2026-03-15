@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Bootstrap Table</h3>
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>

<div class="mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-3">
            <h4 class="h3">Table 1</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive table-rounded-top">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jane Cooper</td>
                            <td>Male</td>
                            <td>info@example.com</td>
                            <td>9658745874</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jane Cooper</td>
                            <td>Male</td>
                            <td>info@example.com</td>
                            <td>9658745874</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 
    </div> 
</div>

<div class="mt-2 mt-lg-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-3">
            <h4 class="h3">Table 2 (Striped)</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive table-rounded-top">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jane Cooper</td>
                            <td>Male</td>
                            <td>info@example.com</td>
                            <td>9658745874</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 
    </div> 
</div>
@endsection
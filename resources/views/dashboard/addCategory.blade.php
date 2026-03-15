@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-color-2">Add Category</h3>
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>

<div class="mt-4 d-flex align-items-center justify-content-center">
    <div class="col-md-6 col-12">
        <div class="card shadow-sm border-0 rounded-2">
            <div class="card-body bg-white p-4">
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label text-color-2">Category Name</label>
                        <input type="text" id="categoryName" name="category" class="form-control" placeholder="Enter category name" />
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary px-4 mt-2">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
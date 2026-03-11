@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-color-2">Add Course</h3>
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<div class="mt-4 d-flex align-items-center justify-content-center">
    <div class="col-md-6 col-12">
        <div class="card-body bg-white p-3">
            <h2 class="h5 text-color-2 py-2">Create Course</h2>
            <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                <div class="col-12">
                    <label for="courseName" class="form-label text-color-2 text-normal">Course Name</label>
                    <input type="text" name="title" class="form-control" id="courseName" placeholder="e.g. Responsive Design">
                </div>

                <div class="col-md-6">
                    <label for="courseCategory" class="form-label text-color-2 text-normal">Course category</label>
                    <select id="courseCategory" name="category" class="form-select text-normal">
                        <option value="">Choose category</option>
                        <option value="1">Web Development</option>
                        <option value="2">App Development</option>
                        <option value="3">Digital Marketing</option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="CourseThubmnail" class="form-label text-color-2 text-normal">Course Image</label>
                    <div class="file-input-container">
                        <input type="file" id="fileInput" name="image" class="file-input">
                        <label for="fileInput" class="file-label">
                            <span class="file-name">Choose image</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="courseTrainer" class="form-label text-color-2 text-normal">Course Trainer</label>
                    <select id="courseTrainer" name="trainer" class="form-select text-normal">
                        <option value="">Choose Trainer</option>
                        <option value="1">Adin Lauren</option>
                        <option value="2">Ashley Lawson</option>
                        <option value="3">Jane Montgomery</option>
                    </select>
                </div>

                <div class="col-6">
                    <label for="coursePrice" class="form-label text-color-2 text-normal">Course Price</label>
                    <input type="number" name="price" class="form-control" id="coursePrice" placeholder="Course price">
                </div>
                <div class="col-12">
                    <label for="desc" class="form-label text-color-2 text-normal">Course Description</label>
                    <textarea name="desc" class="form-control" id="desc" cols="10" rows="0"></textarea>
                </div>

                <div class="col-12 mt-5">
                    <button type="button" class="btn bg-white bg-primary text-white d-flex align-items-center px-4 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">Save Informations</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
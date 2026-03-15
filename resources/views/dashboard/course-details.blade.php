@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-color-2">Courses Details</h3>
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<div class="mt-4">
    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h1 class="text-size-26 mb-0 font-weight-600 ">Web Development Masterclass</h1>
                            <div class="d-flex gap-3">
                                <button class="btn btn-light"><i class="fas fa-share"></i></button>
                                <button class="btn btn-light"><i class="fas fa-bookmark"></i></button>
                            </div>
                        </div>
                        <div class="text-muted">Prof. Adin Lauren</div>
                        <div class="badge bg-primary mt-2">Web Development</div>
                    </div>

                    <div class="mb-5">
                        <img src="{{ asset('dashboard-assets/images/technology.jpg') }}" alt="Course Image" class="img-fluid rounded">
                    </div>

                    <div class="mb-5">
                        <h3 class="text-size-18">Description</h3>
                        <p class="text-muted text-size-15">Learn the fundamentals of modern web development, from HTML/CSS to advanced JavaScript frameworks. This course is designed for beginners and intermediate developers looking to polish their skills.</p>
                    </div>

                    <div>
                        <h3 class="text-size-18 mb-3">This Course Includes</h3>
                        <div class="row g-3 course-features mb-5 text-size-15">
                            <div class="col-md-6">
                                <div><i class="fas fa-clock"></i> 1.3 Hours on-demand video</div>
                            </div>
                            <div class="col-md-6">
                                <div><i class="fas fa-question-circle"></i> 35 Quizzes</div>
                            </div>
                            <div class="col-md-6">
                                <div><i class="fas fa-pencil-alt"></i> 7 Design Exercises</div>
                            </div>
                            <div class="col-md-6">
                                <div><i class="fas fa-book"></i> Lectures: 19</div>
                            </div>
                            <div class="col-md-6">
                                <div><i class="fas fa-video"></i> 48 Articles</div>
                            </div>
                            <div class="col-md-6">
                                <div><i class="fas fa-closed-captioning"></i> Captions: Yes</div>
                            </div>
                            <div class="col-md-6">
                                <div><i class="fas fa-download"></i> 120 Download Resources</div>
                            </div>
                            <div class="col-md-6">
                                <div><i class="fas fa-globe"></i> Language: English</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h3 class="text-size-18">Instructor</h3>
                        <div class="d-flex align-items-center gap-3 mt-3">
                            <img src="{{ asset('dashboard-assets/images/avatar-1.jpg') }}" alt="Adin Lauren" class="instructor-avatar">
                            <div>
                                <h5 class="mb-0 text-size-15">Adin Lauren</h5>
                                <div class="text-muted mb-0 text-size-14">Senior Web Developer</div>
                                <div class="rating-stars text-size-14">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                    <span class="text-muted ms-2">4.9 (12k)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="faq-item active">
                        <div class="faq-question">
                            <div>
                                <h4 class="mb-1 text-size-16">The Courses Program</h4>
                                <div class="text-muted text-size-14">2/5 | 4.4 min</div>
                            </div>
                        </div>
                        <div class="faq-answer">
                            <div class="lesson-list">
                                <div class="lesson-item completed">
                                    <div class="d-flex">
                                        <div><i class="fas fa-check-circle check-circle me-2 text-success"></i></div>
                                        <div>
                                            <div><p class="m-0">1. Welcome to this course</p></div>
                                            <div class="text-muted">2.4 min</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lesson-item completed">
                                    <div class="d-flex">
                                        <div><i class="fas fa-check-circle check-circle me-2 text-success"></i></div>
                                        <div>
                                            <div><p class="m-0">2. Watch before you start</p></div>
                                            <div class="text-muted">4.4 min</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<div class="header d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <div class="collapse-sidebar me-3 d-none d-lg-block text-color-1">
            <span><i class="fa-solid fa-bars font-size-24"></i></span>
        </div>
        <div class="menu-toggle me-3 d-block d-lg-none text-color-1">
            <span><i class="fa-solid fa-bars font-size-24"></i></span>
        </div>
        <div class="d-none d-md-block d-lg-block">
            <div class="input-group flex-nowrap">
                <!-- <span class="input-group-text bg-white" id="addon-wrapping">
                    <i class="fa-solid search-icon fa-magnifying-glass text-color-1"></i>
                </span> -->
                <!-- <input type="text" class="form-control search-input border-l-none ps-0" placeholder="Search anything"> -->
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center">
        <ul class="nav d-flex align-items-center">

            <!-- Messages Dropdown -->
            <li class="nav-item me-2-5">
                <a href="#" class="text-color-1 position-relative" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-message font-size-24"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end mt-4">
                    <div id="chatmessage" class="h-380 scroll-y p-3 custom-scrollbar">
                        <ul class="timeline">
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2">
                                        <img alt="image" width="50" src="{{ asset('dashboard-assets/images/avatar-1.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mb-1">We talked about a project...</h6>
                                        <small class="d-block"><i class="fa-solid fa-clock"></i> 30 min ago</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2">
                                        <img alt="image" width="50" src="{{ asset('dashboard-assets/images/avatar-2.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mb-1">You sent an email to the client...</h6>
                                        <small class="d-block"><i class="fa-solid fa-clock"></i> 1 hour ago</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2">
                                        <img alt="image" width="50" src="{{ asset('dashboard-assets/images/avatar-3.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mb-1">Meeting with the design team...</h6>
                                        <small class="d-block"><i class="fa-solid fa-clock"></i> 2 hours ago</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2">
                                        <img alt="image" width="50" src="{{ asset('dashboard-assets/images/avatar-4.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mb-1">Reviewed the project documents...</h6>
                                        <small class="d-block"><i class="fa-solid fa-clock"></i> Yesterday</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2">
                                        <img alt="image" width="50" src="{{ asset('dashboard-assets/images/avatar-5.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mb-1">Finalized the project timeline...</h6>
                                        <small class="d-block"><i class="fa-solid fa-clock"></i> 2 days ago</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <a class="all-notification" href="#">See all message <i class="fas fa-arrow-right"></i></a>
                </div>
            </li>

            <!-- Notifications Dropdown -->
            <li class="nav-item me-2-5">
                <a href="#" class="text-color-1 notification" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-bell font-size-24"></i>
                    <div class="marker"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end mt-4">
                    <div id="Notification" class="h-380 scroll-y p-3 custom-scrollbar">
                        <ul class="timeline">
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2">
                                        <img alt="image" width="50" src="{{ asset('dashboard-assets/images/profile.png') }}">
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mb-1">Dr Smith uploaded a new report</h6>
                                        <small class="d-block">10 December 2023 - 08:15 AM</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2 media-info">AP</div>
                                    <div class="media-body">
                                        <h6 class="mb-1">New Appointment Scheduled</h6>
                                        <small class="d-block">10 December 2023 - 09:45 AM</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2 media-success"><i class="fa fa-check-circle"></i></div>
                                    <div class="media-body">
                                        <h6 class="mb-1">Patient checked in at reception</h6>
                                        <small class="d-block">10 December 2023 - 10:20 AM</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2">
                                        <img alt="image" width="50" src="{{ asset('dashboard-assets/images/profile.png') }}">
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mb-1">Dr Alice shared a prescription</h6>
                                        <small class="d-block">10 December 2023 - 11:00 AM</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2 media-danger">EM</div>
                                    <div class="media-body">
                                        <h6 class="mb-1">Emergency Alert: Critical Patient</h6>
                                        <small class="d-block">10 December 2023 - 11:30 AM</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2 media-primary"><i class="fa fa-calendar-alt"></i></div>
                                    <div class="media-body">
                                        <h6 class="mb-1">Next Appointment Reminder</h6>
                                        <small class="d-block">10 December 2023 - 12:00 PM</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <a class="all-notification" href="#">See all notifications <i class="fas fa-arrow-right"></i></a>
                </div>
            </li>

            <!-- User Profile -->
            <li class="nav-item dropdown user-profile">
                <a href="#" class="d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Avatar" class="rounded-circle me-0 me-lg-3" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <span class="user-avatar me-0 me-lg-3">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    @endif
                    <div class="d-none d-lg-block">
                        <span class="d-block auth-role text-capitalize">{{ auth()->user()->role }}</span>
                        <span class="auth-name">{{ auth()->user()->name }}</span>
                        <span class="ms-2 text-color-1 text-size-sm"><i class="fa-solid fa-angle-down"></i></span>
                    </div>
                </a>

                <ul class="dropdown-menu mt-3 dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
                    <li><hr class="dropdown-divider"></li>
                    <li class="mx-3">
                        <form action="{{ route('logout-dash') }}" method="POST" onsubmit="return confirm('Are you sure you want to logout?')">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>

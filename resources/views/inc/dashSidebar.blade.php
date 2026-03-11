<div class="sidebar">
    <!-- Sidebar -->
    <div class="sidebar-header">
        <div class="lg-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('dashboard-assets/images/logo.png') }}" alt="logo large">
            </a>
        </div>
        <div class="sm-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('dashboard-assets/images/small-logo.png') }}" alt="logo small">
            </a>
        </div>
    </div>

    <div class="sidebar-body custom-scrollbar">
        <ul class="sidebar-menu">
            <li><a href="{{ route('dashboard.index') }}" class="sidebar-link active"><i class="fa-solid fa-house"></i><p>Dashboard</p></a></li>
            <li><a href="{{ route('courses') }}" class="sidebar-link"><i class="fa-brands fa-discourse"></i><p>Courses</p></a></li>
            <li><a href="{{ route('students') }}" class="sidebar-link"><i class="fa-solid fa-user"></i><p>Students</p></a></li>
            <li><a href="{{ route('teachers') }}" class="sidebar-link"><i class="fa-solid fa-chalkboard-user"></i><p>Teachers</p></a></li>
            <li><a href="{{ route('add-category') }}" class="sidebar-link"><i class="fa-solid fa-folder-plus"></i><p>Add Category</p></a></li>

            <li><a href="{{ route('library') }}" class="sidebar-link"><i class="fa-solid fa-book"></i><p>Library</p></a></li>
            <li><a href="{{ route('department') }}" class="sidebar-link"><i class="fa-solid fa-building"></i><p>Department</p></a></li>
            <li><a href="{{ route('staff') }}" class="sidebar-link"><i class="fa-solid fa-users"></i><p>Staff</p></a></li>
            <li><a href="{{ route('fees') }}" class="sidebar-link"><i class="fa-solid fa-dollar-sign"></i><p>Fees</p></a></li>
            <li><a href="{{ route('chat.index') }}" class="sidebar-link"><i class="fa-solid fa-comments"></i><p>Chat</p></a></li>

            <!-- Pages -->
            <li>
                <a href="#" class="sidebar-link submenu-parent"><i class="fa-solid fa-list"></i><p>Pages <i class="fa-solid fa-chevron-right right-icon"></i></p></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('login-dash') }}" class="submenu-link">Login</a></li>
                    <li><a href="{{ route('signup-dash') }}" class="submenu-link">Register</a></li>
                    <li><a href="{{ route('forgot-password-dash') }}" class="submenu-link">Forgot password</a></li>
                    <li><a href="{{ route('404-dash') }}" class="submenu-link">404 page</a></li>
                    <li><a href="{{ route('500-dash') }}" class="submenu-link">500 page</a></li>
                </ul>
            </li>

            <!-- Tables -->
            <li>
                <a href="#" class="sidebar-link submenu-parent"><i class="fa-solid fa-list"></i><p>Table <i class="fa-solid fa-chevron-right right-icon"></i></p></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('bootstrap-table') }}" class="submenu-link">Bootstrap</a></li>
                    <li><a href="{{ route('data-table') }}" class="submenu-link">DataTable</a></li>
                </ul>
            </li>

            <!-- Components -->
            <li>
                <a href="#" class="sidebar-link submenu-parent"><i class="fa-solid fa-list"></i><p>Components <i class="fa-solid fa-chevron-right right-icon"></i></p></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('form') }}" class="submenu-link">Form Element</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

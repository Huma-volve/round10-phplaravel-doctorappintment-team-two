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
            <li><a href="{{ route('dashboard.index') }}" class="sidebar-link active"><i class="fa-solid fa-house"></i>
                    <p>Dashboard</p>
                </a></li>
            @if(auth()->user()->role === 'admin')
            <li><a href="{{ route('admin.users.index') }}" class="sidebar-link"><i class="fa-solid fa-users"></i>
                    <p>Users</p>
                </a></li>
           <!-- Doctors -->
            <li>
                <a href="#" class="sidebar-link submenu-parent"><i class="fa-solid fa-list"></i>
                    <p>Doctors <i class="fa-solid fa-chevron-right right-icon"></i></p>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('admin.doctors.index') }}" class="submenu-link">All Doctors</a></li>
                    <li><a href="{{ route('admin.doctors.create') }}" class="submenu-link">Add Doctor</a></li>
                </ul>
            </li>
              <!-- clinics -->
               <li>
                    <a href="#" class="sidebar-link submenu-parent"><i class="fa-solid fa-list"></i>
                    <p>Clinics <i class="fa-solid fa-chevron-right right-icon"></i></p>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('admin.doctors.index-clinic') }}" class="submenu-link">All Clinics</a></li>
                    <li><a href="{{ route('admin.doctors.create-clinic') }}" class="submenu-link">Add Clinic</a></li>
                </ul>
               </li>
               <!-- Specialization -->
                <li>
                    <a href="#" class="sidebar-link submenu-parent"><i class="fa-solid fa-list"></i>
                    <p>Specializations <i class="fa-solid fa-chevron-right right-icon"></i></p>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('admin.doctors.index-specialization') }}" class="submenu-link">All Specializations</a></li>
                    <li><a href="{{ route('admin.doctors.create-specialization') }}" class="submenu-link">Add Specialization</a></li>
                </ul>
                </li>
            <li>
                <a href="#" class="sidebar-link submenu-parent"><i class="fa-solid fa-list"></i>
                    <p>Booking <i class="fa-solid fa-chevron-right right-icon"></i></p>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('admin.booking.index') }}" class="submenu-link">Booking All</a></li>
                    <li><a href="{{ route('admin.booking.create') }}" class="submenu-link">Add Booking</a>
            </li> 

                </ul>
            </li>
          
        @endif


        <li><a href="{{ route('chat.index') }}" class="sidebar-link"><i class="fa-solid fa-comments"></i>
                <p>Chat</p>
            </a></li>
        <li><a href="{{ route('review.create') }}" class="sidebar-link"><i class="fa-solid fa-clipboard-check"></i>
                <p>Review</p>
            </a></li>



        @if(auth()->user()->role === 'admin')
        <!-- Pages -->
        <li>
            <a href="#" class="sidebar-link submenu-parent"><i class="fa-solid fa-list"></i>
                <p>Admin <i class="fa-solid fa-chevron-right right-icon"></i></p>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('faqs.create') }}" class="submenu-link">Add FAQs</a></li>
                <li><a href="{{ route('faqs.index') }}" class="submenu-link">FAQs</a></li>
                <li><a href="{{ route('policies.create') }}" class="submenu-link">Add policy</a></li>
                <li><a href="{{ route('policies.index') }}" class="submenu-link">policies</a></li>

            </ul>
        </li>
        @endif
        <li>
            <a href="#" class="sidebar-link submenu-parent"><i class="fa-solid fa-list"></i>
                <p>Auth <i class="fa-solid fa-chevron-right right-icon"></i></p>
            </a>
            <ul class="sidebar-submenu">
                <li>

                    @guest
                    <a href="{{ route('show-login') }}" class="submenu-link">Login</a>
                    @endguest

                    @auth
                    <form action="{{ route('logout-dash') }}" method="POST" onsubmit="return confirm('Are you sure you want to logout?')">
                        @csrf
                        <button type="submit" class="submenu-link border-0 bg-transparent">
                            Logout
                        </button>
                    </form>
                    @endauth

                </li>
            </ul>
        </li>

        </ul>
    </div>
</div>
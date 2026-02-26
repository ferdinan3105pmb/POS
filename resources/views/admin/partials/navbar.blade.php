<header id="header" class="header fixed-top d-flex align-items-center shadow-sm">
    <div class="d-flex align-items-center">
        <a href="{{ url('/')}}" class="logo d-flex align-items-center">
        </a>
        <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
    </div>
    @yield('breadcrumb')
    <nav class="header-nav ms-auto">
        <style>
            .dropdown-menu.notifications {
                max-height: 400px; /* Set the maximum height for the dropdown */
                overflow-y: auto; /* Enable vertical scrolling if content exceeds the max height */
            }
        </style>
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img
                        src="{{ !empty(auth()->user()?->profile_photo_path) ? serveImage(auth()->user()?->profile_photo_path, ['w' => 100]) : asset('assets/img/avatar.png') }}"
                        alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()?->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ auth('admin')->user()->email }}</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('/profile/changePassword') }}">
                            <i class="bi bi-gear"></i>
                            <span>Change password</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('/logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- <li class="nav-item dropdown pe-3">
                <div class="d-flex align-items-center justify-content-between d-block d-md-none">
                    <i class="bi bi-list toggle-sidebar-btn" style="z-index: 120;"></i>
                </div>
            </li> --}}
        </ul>
    </nav>
</header>
@push('js')
@endpush

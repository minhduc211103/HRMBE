<div class="d-flex min-vh-100 bg-light">
    <div class="col-md-2 bg-white border-end shadow-sm d-flex flex-column p-0 sticky-top" style="height: 100vh;">
        <div class="p-4 border-bottom">
            <h5 class="fw-bold text-primary mb-0">
                <i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL
            </h5>
        </div>

        <ul class="nav flex-column p-2 mt-2 gap-2">
            <li class="nav-item">
                <a href="{{ route('admin.index') }}"
                   class="nav-link rounded {{ Request::is('admin') || Request::is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.hr.index')}}"
                   class="nav-link rounded {{ Request::is('admin/hr*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Human resource
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.projects.index')}}"
                   class="nav-link rounded {{ Request::is('admin/projects*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase me-2"></i> Projects
                </a>
            </li>
        </ul>

        <div class="mt-auto p-4 border-top">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-2 text-primary">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <small class="text-muted d-block" style="font-size: 0.75rem">Logged in as</small>
                    <span class="fw-bold text-dark">Admin</span>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right me-1"></i> Log Out
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-10 p-4" style="overflow-y: auto; height: 100vh;">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark">@yield('page-title', 'Overview')</h2>
                <p class="text-muted mb-0">Welcome back to dashboard</p>
            </div>
        </div>

        @yield('content')

    </div>
</div>

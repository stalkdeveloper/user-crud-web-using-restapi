<div class="leftside-menu">
    <!-- Topbar Brand Logo -->
    <div class="logo-topbar">
        <a href="/" class="logo logo-light">
            {{-- <span class="logo-lg">
                <img src="{{ asset(config('constant.default.logo')) }}" alt="logo">
            </span>
            <span class="logo-sm">
                <img src="{{ asset(config('constant.default.logo')) }}" alt="small logo">
            </span> --}}
        </a>
        <a href="/" class="logo logo-dark">
            <span class="logo-lg">
                <img src="{{ asset(config('constant.default.darklogo')) }}" alt="dark logo">
            </span>
            <span class="logo-sm">
                <img src="{{ asset(config('constant.default.darklogo')) }}" alt="small logo">
            </span>
        </a>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!--- Sidemenu -->
        <ul class="side-nav">
            <!-- Dashboard Link -->
            <li class="side-nav-item {{ request()->is('dashboard') ? 'menuitem-active' : '' }}">
                <a href="{{ route('dashboard') }}" class="side-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="ri-pulse-line"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <!-- User Management Section -->
            <li class="side-nav-item {{ request()->is('users*') ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#sidebarPagesUser" aria-expanded="false" aria-controls="sidebarPagesUser" class="side-nav-link">
                    <i class="ri-user-line"></i>
                    <span>User</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->is('users*') ? 'show' : '' }}" id="sidebarPagesUser">
                    <ul class="side-nav-second-level">
                        {{-- <li class="{{ request()->is('users/create') ? 'menuitem-active' : '' }}">
                            <a href="{{ route('users.create') }}" class="{{ request()->is('users/create') ? 'active' : '' }}">
                                Create User
                            </a>
                        </li> --}}
                        <li class="{{ request()->is('users') ? 'menuitem-active' : '' }}">
                            <a href="{{ route('users.index') }}" class="{{ request()->is('users') ? 'active' : '' }}">
                                List Users
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <!--- End Sidemenu -->
        <div class="clearfix"></div>
    </div>
</div>

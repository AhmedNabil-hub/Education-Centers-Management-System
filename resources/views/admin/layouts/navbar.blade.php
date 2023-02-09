@php
$nav_user = getResourceResponse(request(), 'user', 'ShowResource', auth()->user());
@endphp

<!-- Navbar -->
<nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
  id="layout-navbar">
  <div class="container-fluid">
		<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
			<div class="navbar-nav align-items-center">Welcome {{ auth()->user()->username }} 🎉</div>
      <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-{{ $nav_user->status == 'active' ? 'online' : 'offline' }}">
              <img src="{{ $nav_user->profile_image }}" alt class="w-px-40 h-auto rounded-circle">
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="javascript:void(0);">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-{{ $nav_user->status == 'active' ? 'online' : 'offline' }}">
                      <img src="{{ $nav_user->profile_image }}" alt class="w-px-40 h-auto rounded-circle">
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <span class="fw-semibold d-block">{{ $nav_user->username }}</span>
                    <small class="text-muted">{{ ucfirst($nav_user->role ?? 'admin') }}</small>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('admin.users.profile') }}">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">My Profile</span>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="javascript:void(0);"
                onclick="event.preventDefault();document.getElementById('logout-form').submit()">
                <i class='bx bx-power-off me-2'></i>
                <span class="align-middle">Log Out</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                @csrf
              </form>
            </li>
          </ul>
        </li>
        <!--/ User -->
      </ul>
    </div>
  </div>
</nav>
<!-- / Navbar -->

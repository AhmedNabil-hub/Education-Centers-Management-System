<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
      <img class="app-brand-logo demo flex-shrink-1" src="{{ asset('assets/img/favicon/favicon.png') }}">
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('app.name') }}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-item @if(Route::currentRouteName() == 'admin.dashboard') active @endif">
      <a href="{{ route('admin.dashboard') }}" class="menu-link">
        <i class='bx bxs-dashboard me-2'></i>
        <div>Dashboard</div>
      </a>
    </li>
		<li class="menu-item @if(Route::currentRouteName() == 'admin.users.index') active @endif">
      <a href="{{ route('admin.users.index') }}" class="menu-link">
        <i class='bx bxs-user me-2'></i>
        <div>Users</div>
      </a>
    </li>
  </ul>
</aside>

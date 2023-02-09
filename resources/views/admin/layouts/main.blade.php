<!DOCTYPE html>

<html class="light-style layout-menu-fixed">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') | Admin Panel</title>
  <meta name="description" content="" />
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />
  <!-- Include Styles -->
  @include('admin.layouts.head-styles')

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('admin.layouts.scriptsIncludes')
</head>

<body>
  <!-- Layout Content -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      @include('admin.layouts.main-sidebar')

      <!-- Layout page -->
      <div class="layout-page">
        <!-- BEGIN: Navbar-->
        {{-- @include('admin.layouts.navbar') --}}
        <!-- END: Navbar-->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-fluid flex-grow-1 container-p-y">
            @yield('content')
          </div>
          <!-- / Content -->

          <!-- Footer -->
          @include('admin.layouts.footer')
          <!-- / Footer -->
          <div class="content-backdrop fade"></div>
        </div>
        <!--/ Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->
  <!--/ Layout Content -->

  <!-- Include Scripts -->
  @include('admin.layouts.footer-scripts')
</body>

</html>

<!DOCTYPE html>

<html class="light-style layout-menu-fixed">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title')</title>
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
  @yield('content')
  <!--/ Layout Content -->

  <!-- Include Scripts -->
  @include('admin.layouts.footer-scripts')
</body>

</html>

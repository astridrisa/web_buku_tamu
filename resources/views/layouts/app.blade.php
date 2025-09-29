<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>

  <head>
      <title>@yield('title') &mdash; PJT</title>
      <link rel="icon" type="image/png" href="{{ url('img/logopjt2.png') }}">
  </head>


  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link href="css/material-icons.min.css" rel="stylesheet">

  {{-- Styles tambahan dari child Blade --}}
  @stack('styles')
</head>
<body>
  <div class="container-scroller">
    {{-- Navbar --}}
    @include('partials.navbar')

    <div class="container-fluid page-body-wrapper">
      {{-- Sidebar --}}
      @include('partials.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          {{-- Konten Dinamis --}}
          @yield('content')
        </div>
        {{-- Footer --}}
        @include('partials.footer')
      </div>
    </div>
  </div>

  {{-- JS --}}
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>

  {{-- Scripts tambahan dari child Blade --}}
  @stack('scripts')
</body>
</html>

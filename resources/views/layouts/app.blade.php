<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
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
  {{-- <script src="{{ asset('assets/js/misc.js') }}"></script> --}}
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>

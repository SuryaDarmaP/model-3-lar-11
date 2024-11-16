<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('assets/templates/admin/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/templates/admin/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/templates/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/templates/admin/css/components.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-94034622-3');
    </script>
    <title>{{ config('app.name', 'title') }}</title>
    @include('sweetalert::alert')
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      @include('layouts.admin.navbar')
      <div class="main-content">
        @include('layouts.admin.sidebar')
        <div class="section">
          @yield('content')
        </div>
      </div>
      @include('layouts.admin.footer')
    </div>
  </div>
  @include('layouts.admin.script')
</body>
</html>
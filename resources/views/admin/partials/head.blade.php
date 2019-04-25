<head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

      <title>@yield('title')</title>
      <!-- Scripts -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <script src="{{ asset('js/app.js') }}" defer></script>

      <!-- General CSS Files -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <!-- CSS Libraries -->
      {{-- <link rel="stylesheet" href="css/style.css"> --}}
      {{-- <link rel="stylesheet" href="css/components.css">  --}}
      
      <!-- Styles -->
      <link href="{{ asset('css/admin.app.css') }}" rel="stylesheet">
      @stack('styles')
      
        
  </head>
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>@yield('title')</title>
      <!-- Scripts -->
      <meta name="csrf-token" content="{{ csrf_token() }}">


      <!-- Styles -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      @stack('styles')
  </head>
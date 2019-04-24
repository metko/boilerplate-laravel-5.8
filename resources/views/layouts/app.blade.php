<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   @include('includes.partials.head')
    <body>
        <div id="app" class="">
           @include('sweetalert::alert')
          
           @include('includes.partials.nav')

            <div class="content">                
                @yield('content')
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}" defer></script>
        @stack('scripts')
    </body>
</html>

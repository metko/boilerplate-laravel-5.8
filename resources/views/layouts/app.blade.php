<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   @include('includes.partials.head')
    <body>
        <div id="app" class="">
           @include('includes.partials.nav')

            <div class="content">
                @yield('content')
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <title>App Name - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/font-awesome/css/font-awesome.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">

    </head>
    <body>
        <div class="container">
             @yield('content')
        </div>
    </body>
</html>
<script src="{{asset('/js/libs/jquery-3.2.1.min.js')}}" type="text/javascript" charset="utf-8" async defer></script>
<script src="{{ asset('/js/main.js') }}" type="text/javascript" charset="utf-8" async defer></script>
<script src="{{ asset('/js/index.js') }}" type="text/javascript" charset="utf-8" async defer></script>
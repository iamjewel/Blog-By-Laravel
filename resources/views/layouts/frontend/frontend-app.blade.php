<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title> @yield('title')-{{ config('app.name', 'Laravel') }}</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">

    <!-- Common Stylesheets -->
    <link href="{{asset('/')}}assets/frontend/css/bootstrap.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/frontend/css/swiper.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/frontend/css/ionicons.css" rel="stylesheet">

    <!--ToastrJs CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    <!-- Specific Page Stylesheets -->
    @stack('css')

</head>
<body>

{{--Header--}}
@include('layouts.frontend.partial.header')

@yield('content')

{{--Footer--}}
@include('layouts.frontend.partial.footer')

<!--Scripts -->

<script src="{{asset('/')}}assets/frontend/js/jquery-3.1.1.min.js"></script>
<script src="{{asset('/')}}assets/frontend/js/tether.min.js"></script>
<script src="{{asset('/')}}assets/frontend/js/bootstrap.js"></script>
<script src="{{asset('/')}}assets/frontend/js/swiper.js"></script>
<script src="{{asset('/')}}assets/frontend/js/scripts.js"></script>

<!-- Toastr Js -->
<script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}

@stack('js')

</body>
</html>

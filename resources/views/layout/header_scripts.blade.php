<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('assets/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('header_scripts')
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- /theme JS files -->
    <style>
        .app-logo {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.05rem;
            color: #292c42;
        }

        .hidden:not(.show) {
            display: none;
        }
    </style>

</head>

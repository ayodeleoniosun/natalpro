<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('assets/images/favicon.png') }}">
        <title>@yield('title')</title>
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/wizard/steps.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
        <link href="{{ asset('css/colors/blue.css') }}" id="theme" rel="stylesheet">
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

        <style>
            #owl-demo .item img {
                display: block;
                width: 100%;
                height: auto;
            }
            #owl-demo2 .item {
                margin: 3px;
            }

            .text-success {
                color: #28a745!important
            }

            a.text-success:focus,
            a.text-success:hover {
                color: #28a745!important
            }

        </style>

    </head>

    <body>

        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>
        
        @include("admin.includes.nav")
        
        @yield("content")

        <script src="{{ asset('js/natalpro.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
        <!--Wave Effects -->
        <script src="{{ asset('js/waves.js') }}"></script>
        <!--Menu sidebar -->
        <script src="{{ asset('js/sidebarmenu.js') }}"></script>
        <!--stickey kit -->
        <script src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <!--Custom JavaScript -->
        <script src="{{ asset('assets/plugins/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/wizard/jquery.steps.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/wizard/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/wizard/steps.js') }}"></script>
        <script src="{{ asset('js/custom.min.js') }}"></script>
</body>
</html>
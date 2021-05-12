<?php

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

?>

<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('assets/images/favicon.png') }}">
        <title>@yield('title')</title>
        <!-- Bootstrap Core CSS -->
        <link href="{{ URL::asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
        <!-- Page plugins css -->
        <link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Daterange picker plugins css -->
        <link href="{{ URL::asset('assets/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/colors/blue.css') }}" id="theme" rel="stylesheet">
        <script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
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

        <script src="{{ URL::asset('js/natalpro.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('js/jquery.slimscroll.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('js/sidebarmenu.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ URL::asset('js/custom.min.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
        <!-- Date Picker Plugin JavaScript -->
        <script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <!-- Date range Plugin JavaScript -->
        <script>

        $(document).ready(function() {
            
            $('#example23').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('.dataTables_info, #example23_paginate').hide('fast');
        });
        // MAterial Date picker    
        $('#mdate').bootstrapMaterialDatePicker({ weekStart : 0, time: false,autoclose: true });
    </script>

</body>
</html>
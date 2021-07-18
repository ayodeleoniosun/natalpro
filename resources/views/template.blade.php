<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="{{ asset('home/images/favicon/favicon.png') }}" rel="icon"/>
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet"/>
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet"/>
    <link href="{{ asset('home/css/particles.css') }}" rel="stylesheet"/>
</head>
<body>
    <div class="page-wrapper">
        @include("header")

        <div class="banner-wrapper">
            @yield("content")
        
            @include("footer")
        </div><!-- /.page-wrapper -->
    </div>  
    
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
    
    <script src="{{ asset('home/js/jquery.js') }}"></script>
    <script src="{{ asset('home/js/particles.min.js') }}"></script>
    <script src="{{ asset('home/js/particles.js') }}"></script>
    <script src="{{ asset('home/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('home/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('home/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('home/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('home/js/theme.js') }}"></script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5dfef7757e39ea1242a15f94/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>
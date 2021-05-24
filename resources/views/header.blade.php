<header class="site-header header-one">
    <nav class="navbar navbar-expand-lg navbar-light header-navigation stricky">
        <div class="container clearfix">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="logo-box clearfix">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('home/images/resources/logo.png') }}" style="width:70px" class="main-logo" alt="Natalpro Logo"/>
                    <img src="{{ asset('home/images/resources/logo.png') }}" style="width:70px" class="stick-logo" alt="Natalpro Logo"/>
                </a>
                <button class="menu-toggler" data-target=".main-navigation">
                    <span class="fa fa-bars"></span>
                </button>
            </div><!-- /.logo-box -->
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="main-navigation">
                <ul class=" navigation-box">
                    <li class="current"><a href="{{ route('index') }}">Home </a></li>
                    <li><a href="{{ route('vaccination.add') }}">Signup for Vaccination </a></li>
                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                    <li style="display:none">
                        <ul class="submenu">
                            
                        </ul><!-- /.submenu -->
                    </li>
                    
                </ul>
            </div><!-- /.navbar-collapse -->
            <div class="right-side-box">
                <a href="tel:1800-456-7890" class="header-one__cta">
                    <span class="header-one__cta-icon">
                        <i class="dentallox-icon-call-answer"></i>
                    </span>
                    <span class="header-one__cta-content">
                        <span class="header-one__cta-text">Feel free to call us:</span>
                        <a href="tel:+2348063712314"><span class="header-one__cta-number">+2348063712314</span></a>
                    </span>
                </a>
            </div><!-- /.right-side-box -->
        </div>
        <!-- /.container -->
    </nav>
</header><!-- /.header-one -->
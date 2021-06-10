<div id="main-wrapper">
    
    <header class="topbar" style="background-color:#31516E"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <div class="navbar-header" style="border-bottom:2px solid #ccc">
                <a class="navbar-brand" href="#">
                    <b>
                        <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="img-responsive img-circle" style="max-width:40px"/>
                    </b>
                    <span> NatalPro </span> </a>
            </div> 

            <div class="navbar-collapse">

                <ul class="navbar-nav mr-auto mt-md-0">
                    
                    <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    
                    <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>

                    <li class="nav-item m-l-10"> <a href="{{ route('admin.settings.index') }}" class="nav-link text-muted waves-effect waves-dark"  data-toggle="tooltip" title="Basic settings"><i class="mdi mdi-settings"></i></a> </li>

                </ul>

                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:30px;max-height:30px"/>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li><a href="{{ route('admin.change-password.index') }}"><i class="ti-key"></i> Change Password</a></li>
                                <li><a href="{{ route('admin.logout') }}" onclick="return confirm('Logout?')"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
                
            </div>
        </nav>
    </header>
    
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">

                    <li> <a class="waves-effect waves-dark" href="http://www.natalpro.org" aria-expanded="false" target="_blank"><i class="mdi mdi-home"></i><span class="hide-menu">Home</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('admin.dashboard') }}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a></li>

                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-user-circle"></i><span class="hide-menu">Users </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('admin.users.type', ['type' => 'nursing_mothers']) }}">Nursing Mothers</a></li>
                        </ul>
                    </li>

                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-medical-bag"></i><span class="hide-menu">Requests </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('admin.vaccination.index', ['userType' => 'admin']) }}">Vaccination Reminders</a></li>
                        </ul>
                    </li>

                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-email"></i><span class="hide-menu">Vaccination SMS </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('admin.vaccination.sms-sample.index') }}">SMS Samples</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
